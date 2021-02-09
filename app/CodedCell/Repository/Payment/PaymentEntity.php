<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 7/31/2016
 * Time: 15:51
 */

namespace CodedCell\Repository\Payment;

use App\Invoice;
use App\InvoicePayment;
use App\PaymentCredit;
use Illuminate\Support\Facades\Auth;

class PaymentEntity implements PaymentInterface
{
    public function all($columns = array('*'), $scope = null)
    {
        $payment = new InvoicePayment();
        if (count($scope) != 0) {
            $payment = call_user_func(array($payment, $scope));
        }
        return $payment->with('invoice')->orderBy('created_at', 'desc')->get($columns);
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        return InvoicePayment::with('invoice')->paginate($perPage, $columns);
    }

    public function create(array $data)
    {
        //Get Due amount to be paid
        $invoice = Invoice::find($data['invoiceId']);
        $payments = InvoicePayment::whereInvoiceid($data['invoiceId'])->get();
        $alreadyPaid = $payments->sum('paymentAmount');
        $invoiceAmount = $invoice->items->sum('total') + $invoice->items->sum('tax');
        $dueAmount = $invoiceAmount - $alreadyPaid;
        if ($data['paymentAmount'] > $dueAmount) {
            $overPayment = $data['paymentAmount'] - $dueAmount;
            PaymentCredit::create(array(
                'amount' => $overPayment,
                'customerId' => $data['customerId']
            ));
            $data['paymentAmount'] = $dueAmount;
        }

        //Update Payment
        $payment = InvoicePayment::create($data);
        $this->updateInvoicePayment($payment);

        return $payment;
    }

    /**
     * Save Payment
     * @param array $data
     * @return mixed
     */
    public function createGroup(array $data)
    {
        $invoices = Invoice::where('customerId', $data['customerId'])->where('paid', 0)->get();
        if (!$invoices) {
            dd('No Invoices to pay, Everything is paid up');
        }
        if ($data['paymentCredit'] > 0) {
            $credit = true;
            $paymentAmount = $data['paymentCredit'];
            $data['paymentNarration'] = 'Payment made with previous credit of ' . number_format($paymentAmount, 2);
        } else {
            $credit = false;
            $paymentAmount = $data['paymentAmount'];
        }
        unset($data['paymentCredit']);
        foreach ($invoices as $invoice) {
            if ($paymentAmount > 0) {
                $invoiceAmount = $invoice->items->sum('total') + $invoice->items->sum('tax');
                if ($paymentAmount - $invoiceAmount > 0) {
                    $paymentAmount = $paymentAmount - $invoiceAmount;
                    $pay = $invoiceAmount;
                } elseif ($paymentAmount > 0 && $paymentAmount < $invoiceAmount) {
                    $pay = $paymentAmount;
                    $paymentAmount = 0;
                } else {
                    $pay = $data['paymentAmount'];
                }
                $payment = array(
                    'customerId' => $data['customerId'],
                    'invoiceId' => $invoice->id,
                    'paymentAmount' => $pay,
                    'paymentMethod' => $data['paymentMethod'],
                    'paymentDetails' => $data['paymentDetails'],
                    'paymentRemarks' => $data['paymentRemarks'],
                    'paymentType' => $data['paymentType'],
                    'paymentNarration' => $data['paymentNarration']
                );


                $payment = InvoicePayment::create($payment);
                $this->updateInvoicePayment($payment);
            }
        }
        if ($credit == false) {
            if ($paymentAmount > 0) {
                PaymentCredit::create(array(
                    'amount' => $paymentAmount,
                    'customerId' => $data['customerId']
                ));
            }
        } else {
            PaymentCredit::where('customerId', $data['customerId'])->delete();
            PaymentCredit::create(array(
                'amount' => $paymentAmount,
                'customerId' => $data['customerId']
            ));
        }
    }


    private function buildRelationShip($arrayItems)
    {
        $empty = [];
        foreach ($arrayItems as $array) {
            array_push($empty, new Invoice((array)$array));
        }
        return $empty;
    }

    public function createRelation(array $data, $relation)
    {
        $data = $this->buildRelationShip($data);
        return $relation->invoice()->saveMany($data);
    }

    public function update(array $data, $id)
    {
        $payment = InvoicePayment::findOrFail($id);
        if (Auth::user()->can('update', $payment)) {
            $payment->update($data);
            $this->updateInvoicePayment($payment);
            return $payment;
        }

    }

    public function delete($id)
    {
        return InvoicePayment::destroy($id);
    }

    public function find($id, $columns = array('*'))
    {
        return InvoicePayment::with('invoice')->findOrFail($id, $columns);
    }

    public function findBy($field, $value, $columns = array('*'))
    {
        return InvoicePayment::where($field, '=', $value)->firstOrFail($columns);
    }

    /**
     * @param $payment
     */
    public function updateInvoicePayment($payment)
    {
        $payments = InvoicePayment::whereInvoiceid($payment->invoiceId)->get();
        $invoice = Invoice::find($payment->invoiceId);
        $paid = $payments->sum('paymentAmount');
        $total = $invoice->items->sum('total') + $invoice->items->sum('tax');
        if ($paid == $total or $paid > $total) {
            Invoice::find($payment->invoiceId)->update(array('paid' => 1));
        }
    }

}