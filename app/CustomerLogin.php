<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Notifications\Notifiable;

class CustomerLogin extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use SoftDeletes;
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'customers';


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
