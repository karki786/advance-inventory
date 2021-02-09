<?php namespace CodedCell\Presenters;

/**
 * Class Supplier
 * @package CodedCell\Presenters
 */
class Supplier extends Presenter
{
    protected $entity;

    public function getSupplierProduct()
    {
        //{{$restock->product->productName}}
        if ($this->entity->product) {
            return $this->entity->product->productName;
        }
        return "UnTracked Product";

    }

    public function itemCost(){
        return number_format($this->entity->restocks->sum('unitCost'), 2, ".", ",");
    }

    public function restockCount(){
        return number_format($this->entity->restocks->count(), 2, ".", ",");
    }


}
