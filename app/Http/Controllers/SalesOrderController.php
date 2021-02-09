<?php

namespace App\Http\Controllers;

use App\Company;
use App\Events\SalesOrderRaised;
use App\Http\Requests;
use App\SalesOrder;
use App\SalesOrderItem;
use Auth;
use Carbon\Carbon;
use CodedCell\Repository\SalesOrder\SalesOrderInterface;
use CodedCell\Traits\PaginateTrait;
use Excel;
use Illuminate\Http\Request;
use Input;
use PDF;
use Response;


class SalesOrderController extends Controller
{
    use PaginateTrait;
    private $sales;

    public function __construct(SalesOrderInterface $sales)
    {
        $this->sales = $sales;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('glance', SalesOrder::class);
        $salesOrders = $this->sales->all(array('*'), $request->scope);
        return view('salesorder.view_salesorders')->with(compact('salesOrders'));
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->sales->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', SalesOrder::class);
        $companySettings = Company::find(Auth::user()->companyId);
        $prevCurr = $companySettings->defaultCurrency;
        return view('salesorder.create_salesorder')->with(compact('prevCurr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Requests\SalesOrderRequest $form)
    {
        $this->authorize('create', SalesOrder::class);
        $request->merge(array('currencyTypeText' => $request->currency));
        $salesOrder = $request->except(['sales', 'products', 'productId', 'generatePackingSlip', 'emailCustomer', 'remark', 'currency', 'saleType', 'barcode']);
        //  $SalesOrderItems = $request->except();
        $salesOrder = $this->sales->create($salesOrder, json_decode($request->sales));
        //event(new SalesOrderRaised($salesOrder));
        return redirect()->action('SalesOrderController@show', array('id' => $salesOrder->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $items = $items = $this->sales->allCombined($id);
        $salesOrder = $this->sales->find($id);
        $this->authorize('view', $salesOrder);
        if ($request->download == true) {
            $company = Company::find(Auth::user()->companyId);
            $pdf = PDF::loadView("reports.salesorder.sales_order_1", compact('items', 'salesOrder', 'company'));
            $paper_orientation = 'landscape';
            $customPaper = array(0, 0, 1300, 650);
            return $pdf->setPaper($customPaper, $paper_orientation)->download('SalesOrder.pdf');
        }

        return view('salesorder.view_salesorder')->with(compact('salesOrder', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $salesOrder = $this->sales->find($id);
        $this->authorize('view', $salesOrder);
        $sales = $salesOrder->items;
        foreach ($sales as $item){
            $item->prod_id = $item->productId;
            if($item->product->usesMultipleStorage){
                $item->productId = $item->locationHash.'-'.'M';
            }else{
                $item->productId = $item->locationHash.'-'.'N';
            }

        }
        $delete_url = url('sales/stock/delete/');
        $prevCurr = $salesOrder->currencyTypeText;
        return view('salesorder.create_salesorder')->with(compact('salesOrder', 'sales', 'delete_url', 'prevCurr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Requests\SalesOrderRequest $form)
    {
        $request->merge(array('currencyTypeText' => $request->currency));
        $salesOrder = $request->except(['sales', 'products', 'generatePackingSlip', 'emailCustomer', 'remark', 'currency', 'saleType', 'barcode']);
        $this->sales->update($salesOrder, $id);
        return redirect()->action('SalesOrderController@show', array('id' => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->sales->delete($id);
        return Response::json(['ok' => 'ok']);
    }

    /**
     * Delete Invoice Item
     * @param $id
     */
    public function destroyItem($id)
    {
        $salesOrderId = SalesOrderItem::find($id)->salesOrderId;
        SalesOrderItem::destroy($id);
        $salesOrder = $this->sales->find($salesOrderId);
        $sales = $salesOrder->items;
        return array('deleted' => true, 'sales' => $sales);
    }

    /**
     * Gets Deleted Items
     */
    public function getDeleted()
    {
        $salesOrders = $this->sales->all(array('*'), 'deletions');
        $restore = 1;
        return view('salesorder.view_salesorders')->with(compact('salesOrders', 'restore'));
    }

    /**
     * Restore Deleted Customer
     * @param $id
     */
    public function restore($id)
    {
        SalesOrder::withTrashed()->find($id)->restore();
        return redirect()->action('SalesOrderController@show', array('id' => $id));
    }


}
