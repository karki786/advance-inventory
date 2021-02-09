<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 4/16/2017
 * Time: 13:52
 */

namespace CodedCell\Presenters;


class StorageLocation extends Presenter
{

    protected $entity;

    public function binDisabled()
    {
        if ($this->entity->binDisabled) {
            return 'Disabled';
        }
        return "Enabled";
    }

    public function whs(){
        return $this->entity->warehouse->whsName;
    }

}