<?php

namespace App\Mail;

use App\Customer;
use App\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PDF;

class PaymentReceived extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice, $dueAmmount, $paymentAmount)
    {
        $this->invoice = $invoice;
        $this->dueAmmount = $dueAmmount;
        $this->paymentAmount = $paymentAmount;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $customer = Customer::with('invoices')->with('payments')->find($this->invoice->customerId);
        $pdf = PDF::loadView('reports.customers.statement', compact('customer'))->save(storage_path('app') . '/' . $customer->companyName . '.pdf');
        return $this->view('emails.payment_received')
            ->with(['invoice' => $this->invoice, 'dueAmmount' => $this->dueAmmount, 'paymentAmount' => $this->paymentAmount])
            ->attach(storage_path('app') . '/' . $customer->companyName . 'pdf', [
                'as' => $customer->companyName.'_Account_Statement.pdf',
                'mime' => 'application/pdf',
            ]);

    }
}
