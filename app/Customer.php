<?php

namespace App;

use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    use SoftDeletes;

    protected $presenter = 'CodedCell\Presenters\Customer';
    protected $notNullable = ['addressName1', 'addressName2'];

    /** Turn Empties to Nullables */
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {

        });
    }

    public function getCustomerTypeAttribute($value)
    {
        if ($value == 0) {
            return "Cash";
        }
        return "Credit";
    }

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

    public function orders()
    {
        return $this->hasMany('App\SalesOrder', 'customerId', 'id')->withTrashed();
    }

    public function invoices()
    {
        return $this->hasMany('App\Invoice', 'customerId', 'id')->with('items')->withTrashed();
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Subscription', 'customerId', 'id')->withTrashed();
    }

    public function invoiceItems()
    {
        return $this->hasManyThrough('App\InvoiceItem', 'App\Invoice', 'customerId', 'invoiceId', 'id')->withTrashed();
    }

    public function returns()
    {
        return $this->hasManyThrough('App\SalesOrderItem', 'App\SalesOrder', 'customerId', 'salesOrderId', 'id')->withTrashed()->where('returned', '>', 0);
    }

    public function payments()
    {
        return $this->hasManyThrough('App\InvoicePayment', 'App\Invoice', 'customerId', 'invoiceId', 'id')->withTrashed();
    }

    public function salesItems()
    {
        return $this->hasManyThrough('App\SalesOrderItem', 'App\SalesOrder', 'customerId', 'salesOrderId', 'id');
    }

    public function quotes()
    {
        return $this->hasMany('App\SalesOrder', 'customerId', 'id');
    }

    public function contacts()
    {
        return $this->hasMany('App\CustomerContact', 'customerId', 'id');
    }

    public function credits()
    {
        return $this->hasMany('App\PaymentCredit', 'customerId', 'id');
    }

    public function scopeDeletions($query)
    {
        return $query->onlyTrashed();
    }

    public function shipping()
    {
        return $this->hasOne('App\ShippingZone', 'id', 'shippingZone')->withTrashed();
    }

    public function subzone()
    {
        return $this->hasOne('App\ShippingSubZone', 'id', 'shippingSubZone')->withTrashed();
    }
}
