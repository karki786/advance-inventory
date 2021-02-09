<?php namespace CodedCell\Presenters;

class Customer extends Presenter
{
    protected $entity;

    public function customerType()
    {
        if ($this->entity->customerType == 0) {
            return "Cash";
        }
        return "Credit";
    }

    public function active()
    {
        if ($this->entity->active == 1) {
            return "Active";
        }
        return "Disabled";
    }

    public function quotes()
    {
        return number_format($this->entity->salesItems->sum('total'), 2);
    }

    public function invoices()
    {
        return number_format($this->entity->invoiceItems->sum('total'), 2);
    }

    public function paymentsMade()
    {
        return number_format($this->entity->payments->sum('paymentAmount'), 2);
    }

    public function statement()
    {
        return '<a href = "' . action('CustomerController@getStatement', $this->entity->id) . '" > Download</a >';
    }

    public function due()
    {
        return number_format($this->entity->invoiceItems->sum('total') + $this->entity->invoiceItems->sum('tax') - $this->entity->payments->sum('paymentAmount'), 2);
    }
}
