<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests;
use App\Http\Requests\PurchaseOrderFormRequest;
use App\Http\Requests\PurchaseRestockForm;
use App\Patient;
use App\PurchaseOrder;
use Auth;
use Carbon;
use CodedCell\Repository\Department\DepartmentInterface;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\PurchaseOrder\PurchaseOrderInterface;
use CodedCell\Traits\PaginateTrait;
use PDF;
use CodedCell\Repository\Report\ReportInterface;
use CodedCell\Repository\Restock\RestockInterface;
use Excel;
use Illuminate\Http\Request;
use Mail;
use Redirect;
use Response;
use Session;

class PurchaseOrderController extends Controller
{

    use PaginateTrait;

    /**
     * @var ProductInterface
     */
    private $product;
    /**
     * @var PurchaseOrderInterface
     */
    private $purchaseOrder;
    /**
     * @var RestockInterface
     */
    private $restock;

    public function __construct(
        ProductInterface $product,
        PurchaseOrderInterface $purchaseOrder,
        RestockInterface $restock,
        DepartmentInterface $department
    )
    {

        $this->product = $product;
        $this->purchaseOrder = $purchaseOrder;
        $this->restock = $restock;
        $this->department = $department;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $this->authorize('glance', PurchaseOrder::class);
        $purchaseOrders = $this->purchaseOrder->all();
        return view('purchaseorder.view_purchaseorders')->with(compact('purchaseOrders'));
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->purchaseOrder->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', PurchaseOrder::class);
        $companySettings = Company::find(Auth::user()->companyId);
        $prevCurr = $companySettings->defaultCurrency;
        return view('purchaseorder.create_purchaseorder')->with(compact('product', 'departments', 'requestNo', 'prevCurr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PurchaseOrderFormRequest $request
     * @return Response
     */
    public function store(Request $request, PurchaseOrderFormRequest $form)
    {
        $this->authorize('create', PurchaseOrder::class);
        $this->purchaseOrder->create($request->except('products', 'sales', 'currency'), json_decode($request->sales));
        return Redirect::action('PurchaseOrderController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        $order = $this->purchaseOrder->find($id);
        $this->authorize('view', $order);
        $company = Company::find(Auth::user()->companyId);
        $pdf = PDF::loadView("purchaseorder.formats.{$company->purchaseOrderFormat}", compact('order', 'company'));
        $paper_orientation = 'landscape';
        $customPaper = array(0, 0, 1300, 650);
        return $pdf->setPaper($customPaper, $paper_orientation)->download('PurchaseOrder.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $purchaseorder = $this->purchaseOrder->find($id);
        $this->authorize('view', $purchaseorder);
        $orders = $purchaseorder->orders;

        $orders = $orders->map(function ($item) {
            // $item->quantity = $item->amount;
            $item->quantity = $item->amount;
            $item->sellingPrice = $item->unitCost;
            return $item;
        });
        $prevCurr = $purchaseorder->lpoCurrencyType;
        return view('purchaseorder.create_purchaseorder')->with(compact('purchaseorder', 'orders', 'prevCurr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id, Request $request, PurchaseOrderFormRequest $form)
    {
        $this->purchaseOrder->update($request->except('products', 'orders', 'products', 'sales', 'currency'), $id);
        return Redirect::action('PurchaseOrderController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->purchaseOrder->deletePurchaseOrder($id);
        return Response::json(['ok' => 'ok']);
    }

    public function getDeleted()
    {
        $deleted = 1;
        $purchaseOrders = $this->purchaseOrder->getPurchaseOrders(compact('deleted'));
        $restore = 1;
        return view('purchaseorder.view_purchaseorders')->with(compact('purchaseOrders', 'restore'));
    }

    public function restore(Request $request)
    {
        $this->purchaseOrder->restore($request->id);
        return redirect()->action('PurchaseOrderController@index');
    }

    /**
     * Get Restock with suggestion
     * @param $id
     */
    public function getRestock($id, $type)
    {
        $product = $this->purchaseOrder->getProductByIdOrProd($id, $type);
        return $product;
    }

    /**
     * Used to get Restock View for purchase order
     * @param $id
     * @return $this
     */
    public function getRestockFromPurchaseOrder($id)
    {
        //Fix It : get if MultipleLocation
        $purchaseorder = $this->purchaseOrder->find($id);
        $orders = $this->buildOrders($purchaseorder->orders);
        return view('purchaseorder.restockfrompurchaseorder')->with(compact('purchaseorder', 'orders'));
    }

    function buildOrders($orders)
    {
        $breakdown = array();
        foreach ($orders->toArray() as $order) {
            $order['received'] = 0;
            $order['location'] = '';
            $order['sellingPrice'] = '';
            $limit = $order['amount'] - $order['delivered'];
            if ($order['usesMultipleStorage'] == 1) {
                array_push($breakdown, (array)$order);
            } else {
                array_push($breakdown, (array)$order);
            }

        }
        return $breakdown;
    }

    /**
     * Delete Reorder Item
     * @param $id
     */
    public
    function deleteReorder($id)
    {
        return $this->purchaseOrder->deletePurchaseOrderItem($id);
    }

    /**
     * Performs a restock from purchase order
     * @return mixed
     */
    public function postRestockFromPurchaseOrder(Request $request, PurchaseRestockForm $form)
    {
        $restock = collect(json_decode($request->orders))->filter(function ($s, $v) {
            if (isset($s->received)) {
                return $s->received > 0;
            }
        });
        $restock->each(function ($item, $key) use ($request) {
            if ($item->received <= ($item->amount - $item->delivered)) {
                if ($item->location != "" or $item->usesMultipleStorage==0) {
                    $this->purchaseOrder->restockFromPurchaseOrder($item, $request->supplierId);
                }
            } else {
                Session::flash('Restock-Error', 'Not all Items could be restocked since the restocked value was higher than ordered value');
            }
        });

        return Redirect::back();
    }
}
