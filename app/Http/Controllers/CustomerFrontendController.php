<?php

namespace App\Http\Controllers;

use App\Company;
use App\CustomerLogin;
use App\Invoice;
use App\InvoiceItem;
use App\InvoicePayment;
use App\Mail\QuotationApproved;
use App\SalesOrder;
use App\SalesOrderItem;
use Auth;
use Braintree;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use PDF;
use Session;

class CustomerFrontendController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('customer')->user();
        $customer = CustomerLogin::with('invoices')->find($user->id);
        $invoices = Invoice::with('items')->whereCustomerid($user->id)->orderBy('id')->withoutGlobalScopes()->paginate(10);;
        return view('customer.view_dashboard')->with(compact('customer', 'invoices'));
    }

    public function quotations()
    {
        $orders = SalesOrder::with('items')->orderBy('id', 'desc')->paginate(10);;
        return view('customer.view_orders')->with(compact('customer', 'orders'));
    }

    public function viewQuotation(Request $request, $orderNo)
    {
        $salesOrder = SalesOrder::with('items')->where('orderNo', $orderNo)->first();
        $items = SalesOrderItem::select('salesOrderId', 'productId', 'productDescription', DB::raw('sum(quantity) as qty'), 'convertedPrice', 'tax', 'total')
            ->where('salesOrderId', $salesOrder->id)
            ->groupBy('salesOrderId', 'productId', 'productDescription', 'convertedPrice', 'tax', 'total')
            ->get();
        if ($request->download == true) {
            $company = Company::find($salesOrder->companyId);
            $pdf = PDF::loadView("reports.salesorder.sales_order_1", compact('items', 'salesOrder', 'company'));
            $paper_orientation = 'landscape';
            $customPaper = array(0, 0, 1300, 650);
            return $pdf->setPaper($customPaper, $paper_orientation)->download('SalesOrder.pdf');
        }
        return view('customer.view_own_quotation')->with(compact('salesOrder', 'items'));
    }

    public function approveQuotation(Request $request, $orderNo)
    {
        SalesOrder::whereOrderno($orderNo)->update(array('approved' => 1));
        $salesorder = SalesOrder::whereOrderno($orderNo)->first();
        Mail::to([$salesorder->salesPerson->email, $salesorder->creator->email])->send(new QuotationApproved($salesorder));
        Session::flash('approved', 'You have approved the quotation');
        return redirect()->back();
    }

    public function viewInvoice(Request $request, $invoiceNumber)
    {
        $invoice = Invoice::with('payment')->whereInvoiceno($invoiceNumber)->first();
        $items = InvoiceItem::select('invoiceid', 'productId', 'productDescription', DB::raw('sum(quantity) as qty'), DB::raw('sum(returned) as returned'), 'convertedPrice', 'tax', 'total')
            ->where('invoiceId', $invoice->id)
            ->groupBy('invoiceid', 'productId', 'productDescription', 'convertedPrice', 'tax', 'total')
            ->get();
        if ($request->download == true) {
            $company = Company::find($invoice->companyId);
            $pdf = PDF::loadView("reports.invoice.invoice_1", compact('items', 'invoice', 'company'));
            $paper_orientation = 'landscape';
            $customPaper = array(0, 0, 1300, 650);
            return $pdf->setPaper($customPaper, $paper_orientation)->download('Invoice.pdf');
        }
        return view('customer.view_own_invoice')->with(compact('invoice', 'items'));
    }

    public function payInvoice(Request $request, $invoiceNumber)
    {
        $invoice = Invoice::with('items')->where('invoiceNo', '=', $invoiceNumber)->first();
        if ($invoice->paid == 1) {
            Session::flash('card-successful', 'Invoice is already settled no need of paying');
            return redirect()->action('CustomerFrontendController@viewInvoice', array('invoiceNumber' => $invoice->invoiceNo));
        }
        Braintree\Configuration::environment(env('Braintree_environment'));
        Braintree\Configuration::merchantId(env('Braintree_merchantId'));
        Braintree\Configuration::publicKey(env('Braintree_publicKey'));
        Braintree\Configuration::privateKey(env('Braintree_privateKey'));
        $token = Braintree\ClientToken::generate();

        $amount = $invoice->items->sum('total') + $invoice->items->sum('tax');
        if ($request->payment_method_nonce) {
            $result = Braintree\Transaction::sale([
                'amount' => $amount,
                'paymentMethodNonce' => $request->payment_method_nonce,
            ]);
            if ($result->success) {
                InvoicePayment::create(array(
                    'paymentAmount' => $result->transaction->amount,
                    'paymentMethod' => $result->transaction->paymentInstrumentType,
                    'invoiceId' => $invoice->id,
                    'customerId' => $invoice->customerId,
                    'companyId' => $invoice->companyId
                ));
                Invoice::find($invoice->id)->update(array('paid' => 1));
                Session::flash('card-successful', 'Your Payment was successfully recorded');
                return redirect()->action('CustomerFrontendController@viewInvoice', array('invoiceNumber' => $invoice->invoiceNo));
            } else {
                Session::flash('card-error', $result->message);
                return redirect()->action('CustomerFrontendController@viewInvoice', array('invoiceNumber' => $invoice->invoiceNo));
            }
        }
        return view('payment.customer_invoice_payment')->with(compact('token', 'amount', 'invoiceNumber', 'invoice'));
    }
}
