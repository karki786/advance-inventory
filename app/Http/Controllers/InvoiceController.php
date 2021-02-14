<?php

namespace App\Http\Controllers;

use App\Company;
use App\Currency;
use App\Events\InvoiceEdited;
use App\Events\InvoiceRaised;
use App\Http\Requests;
use App\Invoice;
use App\InvoiceItem;
use App\SalesOrderItem;
use Auth;
use Carbon\Carbon;
use CodedCell\Repository\Customer\CustomerInterface;
use CodedCell\Repository\Invoice\InvoiceInterface;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\SalesOrder\SalesOrderInterface;
use CodedCell\Traits\PaginateTrait;
use Excel;
use Illuminate\Http\Request;
use Input;
use PDF;
use Response;

class InvoiceController extends Controller
{
    use PaginateTrait;

    public function __construct(InvoiceInterface $invoice, ProductInterface $product, SalesOrderInterface $order, CustomerInterface $customer)
    {
        $this->invoice = $invoice;
        $this->product = $product;
        $this->order = $order;
        $this->customer = $customer;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('glance', Invoice::class);
        $invoices = $this->invoice->all(array('*'), $request->scope);
        return view('invoice.view_invoices')->with(compact('invoices'));
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->invoice->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $this->authorize('create', Invoice::class);
        
        $contacts = [];
        print_r($req)
        //Check if has salesOrder id and Load Items for Invoice
        if ($request->order) {
            dd(123);
            $salesOrder = $this->order->find($request->order);
            if ($salesOrder) {
                
                $invoice = new Invoice(array(
                    'customerId' => $salesOrder->customerId,
                    'contactId' => $salesOrder->contactId,
                    'paymentMethod' => $salesOrder->paymentMethod,
                    'currencyTypeId' => $salesOrder->currencyTpeId,
                    'paymentTerms' => $salesOrder->paymentTerms,
                    'salesOrderId' => $salesOrder->id
                ));
            } else {
                $invoice = new Invoice();
            }

            $prevCurr = $salesOrder->currencyTypeText;
            $contacts = $this->customer->find($salesOrder->customerId)->contacts->pluck('customerName', 'id');
            $sales = SalesOrderItem::whereSalesorderid($salesOrder->id)->get(array(
                'productId',
                'binLocation',
                'productDescription',
                'quantity',
                'sellingPrice',
                'convertedPrice',
                'convertedRate',
                'tax',
                'taxRate',
                'discount',
                'taxable',
                'returned',
                'total'
            ));
            $create = 1;
            return view('invoice/create_invoice')->with(compact('invoice', 'sales', 'contacts', 'prevCurr', 'create'));
        }
        $companySettings = Company::find(Auth::user()->companyId);
        $prevCurr = $companySettings->defaultCurrency;
        return view('invoice/create_invoice')->with(compact('contacts', 'prevCurr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Requests\InvoiceFormRequest $form)
    {
        $this->authorize('create', Invoice::class);
        $request->merge(array('currencyTypeText' => $request->currency));
        $invoice = $request->except(['sales', 'products','productId', 'generatePackingSlip', 'emailCustomer', 'remark', 'currency', 'saleType', 'barcode']);
        //  $invoiceItems = $request->except();
        $invoice = $this->invoice->create($invoice, json_decode($request->sales));
        //event(new InvoiceRaised($invoice));
        return redirect()->action('InvoiceController@show', array('id' => $invoice->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $items = $this->invoice->allCombined($id);
        $invoice = $this->invoice->find($id);
        $this->authorize('view', $invoice);
        if ($request->download == true) {
            $company = Company::find(Auth::user()->companyId);
            $pdf = PDF::loadView("reports.invoice.invoice_1", compact('items', 'invoice', 'company'));
            $paper_orientation = 'landscape';
            $customPaper = array(0, 0, 1300, 650);
            return $pdf->setPaper($customPaper, $paper_orientation)->download('Invoice.pdf');
        }
        return view('invoice.view_invoice')->with(compact('invoice', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = $this->invoice->find($id);
        $this->authorize('view', $invoice);
        $sales = $invoice->items;
        foreach ($sales as $item){
            $item->prod_id = $item->productId;
            if($item->product->usesMultipleStorage){
                $item->productId = $item->locationHash.'-'.'M';
            }else{
                $item->productId = $item->locationHash.'-'.'N';
            }

        }
        $contacts = [];

        $prevCurr = $invoice->currencyTypeText;

        return view('invoice.create_invoice')->with(compact('invoice', 'sales', 'contacts', 'delete_url', 'prevCurr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Requests\InvoiceFormRequest $form)
    {
        $request->merge(array('currencyTypeText' => $request->currency));
        $invoice = $request->except(['sales', 'products', 'generatePackingSlip', 'emailCustomer', 'remark', 'currency', 'saleType', 'barcode']);
        $this->invoice->update($invoice, $id);
        //event(new InvoiceEdited(Invoice::with('items')->find($id)));
        return redirect()->action('InvoiceController@show', array('id' => $id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->invoice->delete($id);
        return Response::json(['ok' => 'ok']);
    }

    /**
     * Delete Invoice Item
     * @param $id
     */
    public function destroyItem($id)
    {
        $invoiceId = InvoiceItem::find($id)->invoiceId;
        InvoiceItem::destroy($id);
        $invoice = $this->invoice->find($invoiceId);
        $sales = $invoice->items;
        return array('deleted' => true, 'sales' => $sales);
    }

    /**
     * Gets Deleted Items
     */
    public function getDeleted()
    {
        $invoices = $this->invoice->all(array('*'), 'deletions');
        $restore = 1;
        return view('invoice.view_invoices')->with(compact('invoices', 'restore'));
    }

    /**
     * Restore Deleted Customer
     * @param $id
     */
    public function restore($id)
    {
        Invoice::withTrashed()->find($id)->restore();
        $invoice = Invoice::with('items')->find($id);
        $this->invoice->decreaseInWarehouse($invoice);
        return redirect()->action('InvoiceController@show', array('id' => $id));
    }

    public function getInvoiceItem($id, $type, $curr)
    {
        $product = $this->product->getProductForAjaxGrid($id, $type);
        //Currency conversion
        $currencyConv = Currency::where('startDate', '<=', Carbon::today())
            ->where('endDate', '>=', Carbon::today())
            ->where('currency', '=', $curr)
            ->first();
        if ($currencyConv != null) {
            $product['convertedPrice'] = $currencyConv->amount * $product['sellingPrice'];
            $product['convertedRate'] = $currencyConv->amount;
        } else {
            $product['convertedPrice'] = 1 * $product['sellingPrice'];
            $product['convertedRate'] = 1;
        }
        return $product;
    }

    public function getBarcodeScan($barcode, $curr)
    {
        $product = $this->product->getProductByBarcode($barcode);
        //Currency conversion
        $currencyConv = Currency::where('startDate', '<=', Carbon::today())
            ->where('endDate', '>=', Carbon::today())
            ->where('currency', '=', $curr)
            ->first();
        if ($currencyConv != null) {
            $product['convertedPrice'] = $currencyConv->amount * $product['sellingPrice'];
            $product['convertedRate'] = $currencyConv->amount;
        } else {
            $product->convertedPrice = 1 * $product->sellingPrice;
            $product->convertedRate = 1;
        }
        return $product;
    }

    public function getInvoiceProducts()
    {
        $query = Input::query('q');
        return $this->product->getProductForDataGrid($query);
    }

    public function getReport()
    {
        $format = Input::query('type');
        $filename = Carbon::now()->format('Ymd_') . "Invoices";
        $file = Excel::create($filename, function ($excel) {

            $excel->sheet('Paid', function ($sheet) {
                $sheet->setfitToPage(0);
                $sheet->setfitToWidth(0);
                $sheet->setfitToHeight(0);
                $sheet->freezeFirstRowAndColumn();
                $sheet->setOrientation('landscape');
                $invoices = $this->invoice->all(array('*'), 'paid');
                $sheet->loadView('reports.invoice.report')->with(compact('invoices'));

            });

            $excel->sheet('UnPaid', function ($sheet) {
                $sheet->setfitToPage(0);
                $sheet->setfitToWidth(0);
                $sheet->setfitToHeight(0);
                $sheet->freezeFirstRowAndColumn();
                $sheet->setOrientation('landscape');
                $invoices = $this->invoice->all(array('*'), 'unpaid');
                $sheet->loadView('reports.invoice.report')->with(compact('invoices'));

            });

            $excel->sheet('Deleted', function ($sheet) {
                $sheet->setfitToPage(0);
                $sheet->setfitToWidth(0);
                $sheet->setfitToHeight(0);
                $sheet->freezeFirstRowAndColumn();
                $sheet->setOrientation('landscape');
                $invoices = $this->invoice->all(array('*'), 'deletions');
                $sheet->loadView('reports.invoice.report')->with(compact('invoices'));

            });


        });

        if ($format == "email") {
            $email = Input::get('email');
            $save_details = $file->store('xlsx');
            $content = "Please find attached a list of products and their levels";
            Mail::send('emails.master', array('content' => $content), function ($message) use ($save_details, $email) {
                $message->to($email)->subject('Products And Their Levels in Stock Control System');
                $message->attach($save_details['full']);
            });
            return Response::json(['ok' => 'ok']);
        } else {
            $file->download($format);
        }
    }

}
