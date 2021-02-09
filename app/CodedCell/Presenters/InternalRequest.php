<?php namespace CodedCell\Presenters;

class InternalRequest extends Presenter
{
    protected $entity;

    public function department()
    {
        if ($this->entity->department) {
            return $this->entity->department->name;
        }
        return "-";
    }

    public function user()
    {
        if ($this->entity->user) {
            return $this->entity->user->name;
        }
        return "-";
    }

    public function dispatched(){

    }
}
