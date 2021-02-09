<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excsoluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $presenter = 'CodedCell\Presenters\SalesOrder';
    //
    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $customer = Customer::find($model->customerId);
            $model->customerText = $customer->companyName;
            $user = Auth::user();
            $model->salesPersonId = $user->id;
            $model->salesPersonText = $user->name;
            $model->companyId = $user->companyId;
            $model->createdBy = $user->id;
        });
    }

    public function items()
    {
        return $this->hasMany('App\SaleItem', 'saleId', 'id');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer', 'id', 'customerId')->withTrashed();
    }

    public function contact()
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


    public function scopeDeletions($query)
    {
        return $query->onlyTrashed();
    }

}
