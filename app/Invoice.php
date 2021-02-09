<?php

namespace App;

use Auth;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    use SoftDeletes;

    protected $presenter = 'CodedCell\Presenters\Invoice';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];



    /**
     * @param $value
     */
    public function setSalesorderidAttribute($value)
    {
        if ($value == "") {
            $this->attributes['salesOrderId'] = null;
        } else {
            $this->attributes['salesOrderId'] = $value;
        }
    }


    public function items()
    {
        return $this->hasMany('App\InvoiceItem', 'invoiceId', 'id');
    }

    public function payment()
    {
        return $this->hasMany('App\InvoicePayment', 'invoiceId', 'id');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer', 'id', 'customerId')->withTrashed();
    }

    public function contacts()
    {
        return $this->hasOne('App\CustomerContact', 'id', 'contactId');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'createdBy', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'updatedBy', 'id');
    }

    public function scopePaid($query)
    {
        return $query->wherePaid(1);
    }

    public function scopeUnpaid($query)
    {
        return $query->wherePaid(0);
    }

    public function scopeDeletions($query)
    {
        return $query->onlyTrashed();
    }
}
