<?php namespace CodedCell\Presenters;

use Carbon;

/**
 * Class Product
 * @package CodedCell\Presenters
 */
class PurchaseOrder extends Presenter
{
    protected $entity;

    /**
     * Returns count of delivered items
     * @return string
     */
    public function delivered()
    {
        $string = $this->entity->orders->sum('delivered') . '/' . $this->entity->orders->sum('amount');

        if ($this->entity->fullDelivery == 1) {
            $string = $string . ' ( in ' . Carbon::createFromFormat('Y-m-d', $this->entity->lpoDate)->diffInDays($this->entity->updated_at) . ' days)';
        }

        return $string;
    }


    public function getDeliveryTime()
    {


        if ($this->entity->fullDelivery == 1) {
            return Carbon::createFromFormat('Y-m-d', $this->entity->lpoDate)->diffInDays($this->entity->updated_at);
        }

        return "-";
    }

    public function restockButton()
    {
        return '<a class="btn btn-flat btn-sm bg-purple" href="'.action('PurchaseOrderController@getRestockFromPurchaseOrder',$this->entity->id).'" ><i class="fa fa-archive"></i></a>';
    }

    /**
     * Returns count of delivered items
     * @return string
     */
    public function fullDelivery()
    {
        if ($this->entity->orders->sum('delivered') == $this->entity->orders->sum('amount')) {
            return true;
        } else {
            return false;
        }


    }

    public function delivery()
    {
        $deliveryDate = Carbon::parse($this->entity->deliverBy);
        $dateCreated = $this->entity->created_at;
        $days = $dateCreated->diffInDays($deliveryDate);
        return Carbon::parse($this->entity->deliverBy)->format('d-M-y');
    }

    public function deliveryPopOver()
    {
        $deliveryDate = Carbon::parse($this->entity->deliverBy);
        $dateCreated = $this->entity->created_at;
        $days = $dateCreated->diffInDays($deliveryDate);
        return "Delivery should be made in  " . $days . " days";
    }

    public function created()
    {
        if ($this->entity->lpoApprovedOn != null) {
            $days = $this->entity->lpoApprovedOn->diffForHumans();
            return $this->entity->lpoApprovedOn->format('d-M-y');
        }
        return "-";

    }

    public function lpoSigned()
    {
        $days = $this->entity->created_at->diffForHumans();
        if ($this->entity->approvedOn != null or $this->entity->approvedOn != "") {
            return $this->entity->approvedOn->format('d-M-y');
        }
        return "-";
    }

    public function createdPopOver()
    {
        $days = $this->entity->created_at->diffForHumans();
        return "LPO was created   " . $days;
    }

    public function supplierContact()
    {
        if ($this->entity->supplier) {
            return $this->entity->supplier->email;
        } else {
            return "-Deleted Supplier-";
        }

    }

    public function supplierDetails()
    {
        if ($this->entity->supplier) {
            return $this->entity->supplier->supplierName . ' Tel - ' . $this->entity->supplier->phone;
        } else {
            return "-Deleted Supplier-";
        }

    }

    public function supplierName()
    {
        if ($this->entity->supplier) {
            return $this->entity->supplier->supplierName;
        } else {
            return "-Deleted Supplier-";
        }

    }

    public function favourite()
    {
        if ($this->entity->isFavourite) {
            return "<a href='" . action('PurchaseOrderController@create',
                    array('id' => $this->entity->id)) . "'><i class='fa fa-star'></i></a>";
        }
    }

    public function lpoStatus()
    {
        return $this->entity->lpoStatus;
    }

    public function deliveryStatus()
    {
        if ($this->entity->fullDelivery == 1) {
            return "Full Delivery";
        } elseif ($this->entity->partDelivery == 1) {
            return "Part Delivery";
        } else {
            return "Undelivered";
        }
    }

    public function totalCash()
    {
        $total = $this->entity->orders->sum('total');

        if ($this->entity->lpoCurrencyType == "KES") {
            return "KES " . number_format($total, 2);
        } elseif ($this->entity->lpoCurrencyType == "USD") {
            return "<i class='fa fa-usd'></i> " . number_format($total, 2);
        } elseif ($this->entity->lpoCurrencyType == "EURO") {
            return "<i class='fa fa-euro'></i> " . number_format($total, 2);
        } else {
            return $this->entity->lpoCurrencyType . " " . number_format($total, 2);
        }
    }

    public function color()
    {

    }

}


