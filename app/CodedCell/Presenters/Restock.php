<?php namespace CodedCell\Presenters;

class Restock extends Presenter
{
    protected $entity;

    /**
     * @return string
     */
    public function warehouse()
    {
        if ($this->entity->warehouse) {
            return $this->entity->warehouse->whsName;
        }
        return "-";

    }

    /**
     * @return string
     */
    public function bin()
    {
        if ($this->entity->binLocation) {
            return $this->entity->binLocation->binCode;
        }
        return "-";

    }

    /**
     * @return string
     */
    public function productName()
    {
        if ($this->entity->product) {
            return strtoupper($this->entity->product->productName);
        } else {
            return strtoupper($this->entity->productName) . "-Untracked";
        }

    }

    /**
     * @return string
     */
    public function untCost()
    {
        return number_format($this->entity->unitCost, 2, ".", ",");
    }

    /**
     * @return string
     */
    public function itemCost()
    {
        return number_format($this->entity->unitCost*$this->entity->amount, 2, ".", ",");
    }

    /**
     * @return string
     */
    public function supplierName()
    {
        if ($this->entity->supplier) {
            return $this->entity->supplier->supplierName;
        } else {
            return "- Deleted Supplier -";
        }
    }

    /**
     * @return null|string
     */
    public function hasDownload()
    {
        if ($this->entity->restockDocs != "") {
            return " <a href='" . action('RestockController@getDownload', array('file' => $this->entity->restockDocs)) . "'><i class='fa fa-download'></i></a>";
        }
        return null;
    }
}
