<?php

namespace App;

use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoicePayment extends Model
{
    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    use SoftDeletes;
    protected $presenter = 'CodedCell\Presenters\Payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function invoice()
    {
        return $this->hasOne('App\Invoice', 'id', 'invoiceId')->withTrashed();
    }


    public function creator()
    {
        return $this->belongsTo('App\User', 'createdBy', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'updatedBy', 'id');
    }

    public function scopeDeletions($query)
    {
        return $query->onlyTrashed();
    }

}
