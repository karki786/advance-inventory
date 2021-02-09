<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Helper;
use App\Http\Requests;
use App\Invoice;
use App\InvoicePayment;
use App\Mail\PaymentReceived;
use Carbon\Carbon;
use CodedCell\Repository\Customer\CustomerInterface;
use CodedCell\Repository\Invoice\InvoiceInterface;
use CodedCell\Repository\Payment\PaymentInterface;
use CodedCell\Traits\PaginateTrait;
use Excel;
use Illuminate\Http\Request;
use Input;
use Mail;
use Response;
use DB;

class PaymentController extends Controller
{
    protected $payment;
    protected $invoice;
    use PaginateTrait;

    public function __construct(CustomerInterface $customer, PaymentInterface $payment, InvoiceInterface $invoice)
    {
        $this->payment = $payment;
        $this->invoice = $invoice;
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
        $this->authorize('glance', InvoicePayment::class);
        $payments = $this->payment->all(array('*'), $request->scope);
        return view('payment.view_payments')->with(compact('payments'));
    }

    public function table(Request $request)
    {
        $paginate = boolval($request->paginate);
        $model = $this->payment->paginate(20, $request->filter, $request->scope, $paginate);
        return $this->paginate($model, $request);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', InvoicePayment::class);
        if ($request->orderNo) {
            $orderNo = $request->orderNo;
            $invoice = Invoice::find($orderNo);
            $customerId = $invoice->customerId;
        } else {
            $customerId = '';
            $orderNo = '';
        }
        return view('payment.create_payment')->with(compact('orderNo', 'customerId'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function groupCreate(Request $request)
    {
        $orderNo = $request->orderNo;
        return view('payment.create_payment_multiple')->with(compact('orderNo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Requests\PaymentFormRequest $form)
    {
        $this->authorize('create', InvoicePayment::class);
        $payment = $this->payment->create($request->all());
        if (env('SENDPAYMENTNOTIFICATIONS') == true) {
            $unpaidInvoices = $this->customer->getPendingPayments($payment->invoice->customerId);
            $dueAmmount = $unpaidInvoices;
            Mail::to($payment->invoice->contact->email)->send(new PaymentReceived($payment->invoice, $dueAmmount, $payment->paymentAmount));
        }
        if (env('SENDSMS') == true) {
            Helper::sendSms('payment', $payment->invoice, $dueAmmount, $payment->paymentAmount);
        }
        return redirect()->action('InvoiceController@show', array('id' => $payment->invoiceId));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function groupSave(Request $request, Requests\PaymentFormGroupRequest $form)
    {
        $payment = $this->payment->createGroup($request->except('paymentDue'));
        return redirect()->action('InvoiceController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = $this->payment->find($id);
        return view('payment.view_payment')->with(compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = $this->payment->find($id);
        $this->authorize('view', $payment);
        $customerId = null;
        $orderNo = null;
        return view('payment.create_payment')->with(compact('payment', 'orderNo', 'customerId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Requests\PaymentFormRequest $form)
    {
        $this->payment->update($request->all(), $id);
        return redirect()->action('InvoiceController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->payment->delete($id);
        return Response::json(['ok' => 'ok']);
    }

    public function restore($id)
    {
        InvoicePayment::withTrashed()->find($id)->restore();
        return redirect()->action('PaymentController@index');
    }

    public function getdeleted()
    {
        $restore = 1;
        $payments = $this->payment->all(array('*'), 'deletions');
        return view('payment.view_payments')->with(compact('payments', 'restore'));
    }

    public function getInvoices($id)
    {
        return Invoice::select(DB::raw('invoiceNo as text,id as id'))->where('customerId', $id)->get();

    }

    public function getInvoicesCost($id)
    {
        $invoices = Invoice::select(DB::raw('invoiceNo as text,id as id'))->where('customerId', $id)->where('paid', 0)->get();
        $finalCost = 0;
        foreach ($invoices as $invoice) {
            if ($invoice) {
                $payments = InvoicePayment::where('invoiceId', $invoice->id)->get();
                if ($payments != null) {
                    $payments = $payments->sum('paymentAmount');
                } else {
                    $payments = 0;
                }
                $cost = (floatval($invoice->items->sum('total') + $invoice->items->sum('tax'))) - floatval($payments);
                $finalCost = $finalCost + $cost;
            }
        }
        $customer = Customer::with('credits')->find($id);
        $creditAmount = $customer->credits->sum('amount');
        return array('cost' => $finalCost, 'credit' => $creditAmount);
    }

    public function getInvoice($id)
    {
        $id = explode(",", $id);
        $invoices = $this->invoice->find($id);
        $finalCost = 0;
        foreach ($invoices as $invoice) {
            if ($invoice) {
                $payments = InvoicePayment::where('invoiceId', $invoice->id)->get();
                if ($payments != null) {
                    $payments = $payments->sum('paymentAmount');
                } else {
                    $payments = 0;
                }
                $cost = (floatval($invoice->items->sum('total') + $invoice->items->sum('tax'))) - floatval($payments);
                $finalCost = $finalCost + $cost;
            }
        }
        return array('cost' => $finalCost);

    }

    public function getReport()
    {
        $format = Input::query('type');
        $filename = Carbon::now()->format('Ymd_') . "Sales Orders";
        $file = Excel::create($filename, function ($excel) {

            $excel->sheet('Payments', function ($sheet) {
                $sheet->setfitToPage(0);
                $sheet->setfitToWidth(0);
                $sheet->setfitToHeight(0);
                $sheet->freezeFirstRowAndColumn();
                $sheet->setOrientation('landscape');
                $payments = $this->payment->all(array('*'));
                $sheet->loadView('reports.payment.report')->with(compact('payments'));

            });

            $excel->sheet('Deleted Payments', function ($sheet) {
                $sheet->setfitToPage(0);
                $sheet->setfitToWidth(0);
                $sheet->setfitToHeight(0);
                $sheet->freezeFirstRowAndColumn();
                $sheet->setOrientation('landscape');
                $payments = $this->payment->all(array('*'), 'deletions');
                $sheet->loadView('reports.payment.report')->with(compact('payments'));

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
