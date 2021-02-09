<?php namespace CodedCell\Presenters;

class Dispatch extends Presenter
{
    protected $entity;

    /**
     * @return string
     */
    public function totalCost()
    {
        return number_format($this->entity->totalCost, 2, ".", ",");
    }

    /**
     * @return string
     */
    public function warehouseName()
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
    public function request()
    {
        if ($this->entity->request) {
            return "<a href='" . action('InternalRequestAdminController@show', $this->entity->request->id) . "'>View Request</a>";
        }
        return "-";

    }

    public function user()
    {
        $string = "-";
        if (isset($this->entity->staff->name)) {
            $string = str_limit($this->entity->staff->name, 15);
        }

        if (isset($this->entity->department->name)) {
            $string = $string . " (" . str_limit($this->entity->department->name, 15) . ")";
        }
        return $string;
    }

    /**
     * @return string
     */
    public function productName()
    {
        if (count($this->entity->product)) {
            return $this->entity->product->productName;
        }
        return "-";
    }

    /**
     * @return string
     */
    public function category()
    {
        if (count($this->entity->product)) {
            if (count($this->entity->product->category)) {
                return $this->entity->product->category->categoryName;
            }
            return "-";

        }
        return "-";
    }

    /**
     * @return mixed
     */
    public function createdAt()
    {
        return $this->entity->updated_at;
    }
}
