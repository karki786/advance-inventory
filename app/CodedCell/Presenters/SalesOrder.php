<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 7/30/2016
 * Time: 20:03
 */

namespace CodedCell\Presenters;

class SalesOrder extends Presenter
{
    protected $entity;

    public function customerName()
    {
        if (count($this->entity->customer)) {
            return $this->entity->customer->companyName;
        }
        return "-";
    }

    public function isApproved()
    {
        if ($this->entity->approved) {
            return "Yes";
        }
        return "No";
    }

    public function isDelivered()
    {
        if ($this->entity->delivered) {
            return "Yes";
        }
        return "No";
    }

    public function isInvoiced()
    {
        if ($this->entity->invoiced) {
            return "Yes";
        }
        return "No";
    }

    public function contactName()
    {
        if (count($this->entity->contacts)) {
            return $this->entity->contacts->customerName;
        }
        return "-";
    }

    public function hold()
    {
        if ($this->entity->onHold) {
            return "Yes";
        }
        return "No";
    }

    public function paymentMethod()
    {
        if ($this->entity->paymentMethod == null) {
            return "-Not Specified-";
        }
        return $this->entity->paymentMethod;
    }

    public function contact()
    {
        if ($this->entity->contacts) {
            return $this->entity->contacts->address1;
        } else {
            return '-';
        }
    }

    public function street()
    {
        if (count($this->entity->contacts) > 0) {
            return $this->entity->contacts->street;
        } else {
            return '-';
        }
    }

    public function email()
    {
        if ($this->entity->contacts) {
            return $this->entity->contacts->email;
        } else {
            return '-';
        }
    }

    public function country()
    {
        if ($this->entity->contacts) {
            return $this->entity->contacts->country;
        } else {
            return '-';
        }
    }

    public function total()
    {
        return number_format($this->entity->items->sum('total'), 2);
    }


}
