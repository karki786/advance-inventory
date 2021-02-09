<?php

namespace App\Http\Controllers;

use App\Company;
use App\Invoice;
use App\InvoiceItem;
use App\InvoicePayment;
use App\Product;
use App\Supplier;
use App\User;
use Carbon\Carbon;
use CodedCell\Repository\Invoice\InvoiceInterface;
use Illuminate\Http\Request;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InvoiceInterface $invoice)
    {
        $this->invoice = $invoice;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get Paid and Unpaid Invoices
        $homepage = Company::findOrFail(Auth::user()->companyId)->homepage;
        if ($homepage != null) {
            return redirect()->action($homepage);
        }
        $paidInvoices = InvoiceItem::leftJoin('invoices', 'invoices.id', '=', 'invoice_items.invoiceId')
            ->select('invoices.invoiceNo', DB::raw('sum(invoice_items.total) as amount'))
            ->where('invoices.paid', 1)
            ->groupBy('invoice_items.invoiceId')
            ->where('invoices.created_at', '>', Carbon::today()->subMonth(1))
            ->get();
        $unPaidInvoices = InvoiceItem::leftJoin('invoices', 'invoices.id', '=', 'invoice_items.invoiceId')
            ->select('invoices.invoiceNo', DB::raw('sum(invoice_items.total) as amount'))
            ->whereNull('invoices.paid')
            ->groupBy('invoice_items.invoiceId')
            ->where('invoices.created_at', '>', Carbon::today()->subMonth(1))
            ->get();
        $topFiveCustomers = InvoicePayment::leftJoin('customers', 'customers.id', '=', 'invoice_payments.customerId')
            ->select('customers.companyName', DB::raw('ceil(sum(invoice_payments.paymentAmount)) as amount'))
            ->groupBy('customers.companyName')
            ->limit(5)
            ->get();

        $supplierCount = Supplier::count();
        $paidGroupInvoices = InvoiceItem::leftJoin('invoices', 'invoices.id', '=', 'invoice_items.invoiceId')
            ->select(DB::raw('sum(invoice_items.total) as amount'), DB::raw('MONTHNAME(invoices.created_at) as month'))
            ->where('invoices.paid', 1)
            ->groupBy(DB::raw('MONTH(invoices.created_at)'))
            ->where('invoices.created_at', '>', Carbon::today()->subYear(1))
            ->get();
        $productCount = Product::count();
        $userCount = User::count();
        $lowStock = Product::where('amount', '<', 'reorderAmount')->count();
        return view('dashboard.index')->with(compact('paidInvoices', 'userCount', 'paidGroupInvoices', 'supplierCount', 'unPaidInvoices', 'productCount', 'lowStock', 'topFiveCustomers'));
    }
}
