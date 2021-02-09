<?php

use App\Invoice;
use Illuminate\Database\Seeder;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Auth::loginUsingId(1);
        for ($x = 0; $x <= 10; $x++) {
            $invoice = Invoice::whereNull('paid')->inRandomOrder()->first();
            \App\InvoicePayment::create(array(
                'customerId' => $invoice->customerId,
                'invoiceId' => $invoice->id,
                'paymentAmount' => $invoice->items->sum('total'),

            ));
            $invoice->paid = 1;
            $invoice->save();
        }
    }
}
