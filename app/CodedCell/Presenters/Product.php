<?php namespace CodedCell\Presenters;

use Illuminate\Support\Facades\Storage;
/**
 * Class Product
 * @package CodedCell\Presenters
 */
class Product extends Presenter
{
    protected $entity;


    /**
     * @return string
     */
    public function productName()
    {
        return strtoupper($this->entity->productName);
    }


    public function image()
    {
        if (count($this->entity->photos) > 0) {
            if ($this->entity->photos()->whereIsthumbnail(1)->first() == null) {
                return url('products') . '/' . 'productplaceholder.png';
            }
            $url = Storage::url('products/' . $this->entity->photos()->wherePicturewidth(100)->first()->filename['filename']);

            return '<img class="img-thumbnail" src="'.$url.'"/>';
        }
        $url = Storage::url('products/placeholder.png');
        return '<img class="img-thumbnail" src="'.$url.'"/>';

    }

    public function productLocationName(){
        if (count($this->entity->locations) > 0){
            return $this->entity->locations->first()->productLocationName;
        }

    }
    public function binLocationName(){
        if (count($this->entity->locations) > 0){
            return $this->entity->locations->sum('amount');
        }

    }

    /**
     * @return string
     */
    public function unitCost()
    {
        if ($this->entity->usesMultipleStorage == 1) {
            return number_format($this->entity->locations->min('unitCost'), 2, ".", ",") . '-' . number_format($this->entity->locations->max('unitCost'), 2, ".", ",");
        }
        return number_format($this->entity->unitCost, 2, ".", ",");
    }

    /**
     * @return string
     */
    public function totalCost()
    {
        if ($this->entity->usesMultipleStorage == 1) {
            $totalCost = 0;
            if (count($this->entity->locations)) {
                foreach ($this->entity->locations as $location) {
                    $cost = $location->unitCost * $location->amount;
                    $totalCost = $cost + $totalCost;
                }
            }
            return number_format($totalCost, 2, ".", ",");
        }
        return number_format(floatval($this->entity->unitCost) * floatval($this->entity->amount), 2, ".", ",");
    }

    /**
     * @return string
     */
    public function amount()
    {
        if ($this->entity->usesMultipleStorage == 1) {
            if (count($this->entity->locations)) {
                return number_format($this->entity->locations->sum('amount'), 2, ".", ",");
            }

        }
        return number_format($this->entity->amount, 2, ".", ",");
    }

    /**
     * @return string
     */
    public function reorderAmount()
    {
        return number_format($this->entity->reorderAmount, 0, ".", ",");
    }

    public function color()
    {

        if ($this->entity->amount < $this->entity->reorderAmount) {
           return  $this->entity->color = 'danger';
        }
    }




    /**
     * @return string
     */
    public function viewPercentage()
    {
        if ($this->entity->amount < $this->entity->reorderAmount) {
            return "progress-bar-danger";
        }
        return "progress-bar-success";
    }

    public function editDetails()
    {
        return 'Created By : ' . $this->entity->creator->name . '<br/> Updated By : ' . $this->entity->creator->name;
    }

    public function location()
    {
        if (count($this->entity->locations)) {
            $str = '';
            foreach ($this->entity->locations as $loc) {
                $str = $str . " " . $loc->binLocationName;
            }
            return str_limit($str, 10);
        }
        return str_limit($this->entity->location, 10);
    }
}
