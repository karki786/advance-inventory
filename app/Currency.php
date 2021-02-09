<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    //use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function creator()
    {
        return $this->belongsTo('App\User', 'createdBy', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'updatedBy', 'id');
    }
}
