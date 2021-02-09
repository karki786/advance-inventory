<?php

namespace App;

use Auth;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Model
{

    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    use SoftDeletes;

    protected $presenter = 'CodedCell\Presenters\SalesOrder';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];



    public function items()
    {
        return $this->hasMany('App\SalesOrderItem', 'salesOrderId', 'id');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer', 'id', 'customerId')->withTrashed();
    }

    public function contacts()
    {
        return $this->hasOne('App\CustomerContact', 'id', 'contactId');
    }

    public function shipping()
    {
        return $this->hasOne('App\ShippingZone', 'id', 'shippingZone');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'createdBy', 'id');
    }
    public function salesPerson()
    {
        return $this->belongsTo('App\User', 'salesPersonId', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'updatedBy', 'id');
    }


    public function scopeDeletions($query)
    {
        return $query->onlyTrashed();
    }

    public function scopeInvoiced($query)
    {
        $ids = Invoice::whereNotNull('salesOrderId')->get(array('salesOrderId'))->pluck('salesOrderId');
        //dd($ids->flatten()->all());
        return $query->whereIn('id', $ids);
    }

    public function scopeUninvoiced($query)
    {
        $ids = Invoice::whereNotNull('salesOrderId')->get(array('salesOrderId'))->pluck('salesOrderId');
        //dd($ids->flatten()->all());
        return $query->whereNotIn('id', $ids);
    }

    public function scopeApproved($query)
    {
      //  $ids = Invoice::whereNotNull('salesOrderId')->get(array('salesOrderId'))->pluck('salesOrderId');
        //dd($ids->flatten()->all());
        return $query->whereapproved(1);
    }

}
