<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 18/May/2017
 * Time: 9:31 AM
 */

namespace CodedCell\Presenters;


class ProductCategory extends Presenter
{
    protected $entity;
    public function count(){
        return $this->entity->products->count();
    }
}