<?php namespace CodedCell\Presenters;

/**
 * Class Product
 * @package CodedCell\Presenters
 */
class Payment extends Presenter
{
    protected $entity;


    public function invoiceNo()
    {
        if (count($this->entity->invoice)) {
            return $this->entity->invoice->invoiceNo;
        }
        return "-";
    }

    public function customer()
    {
        if (count($this->entity->invoice)) {
            return $this->entity->invoice->customerText;
        }
        return "-";
    }

    public function total()
    {
        return number_format($this->entity->paymentAmount, 2);
    }

    public function viewInvoice()
    {
        return '<a class="btn btn-sm btn-flat bg-green btn-block" href="' . action('InvoiceController@show', $this->entity->invoice->id) . '"><small>View Invoice</small></a>';
    }
}
