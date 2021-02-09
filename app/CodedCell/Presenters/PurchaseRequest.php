<?php namespace CodedCell\Presenters;

use Carbon;

/**
 * Class Product
 * @package CodedCell\Presenters
 */
class PurchaseRequest extends Presenter
{
    protected $entity;

    public function requestDate()
    {
        return $this->entity->created_at->diffForHumans();
    }

}

