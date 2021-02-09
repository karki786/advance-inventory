<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 4/16/2017
 * Time: 13:52
 */

namespace CodedCell\Presenters;


class Warehouse extends Presenter
{

    protected $entity;

    public function viewProducts()
    {
        return count($this->entity->products) . ' <a href="' . action('WarehouseController@show', $this->entity->id) . '">View Products</a>';
    }

    public function addBin()
    {
        return '<a href="' . action('BinLocationController@create', array('warehouseid' => $this->entity->id)) . '">Add BinLocation</a>';
    }

    public function viewBin(){
        return '<a href="'.action('BinLocationController@show',$this->entity->id).'">View Bin Locs</a>';
    }

}