<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrderItem extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->total = (($model->quantity - $model->returned) * $model->sellingPrice) - $model->discount;
            if ($model->taxable == 1) {
                $model->tax = ($model->taxRate / 100) * $model->total;
            }
        });

        static::creating(function ($model) {

            if (Auth::check()) {
                $user = Auth::user();
                $model->companyId = $user->companyId;
                $model->createdBy = $user->id;
            }

        });

        static::updating(function ($model) {

            if (Auth::check()) {
                $user = Auth::user();
                $model->companyId = $user->companyId;
                $model->updatedBy = $user->id;
                $model->total = ($model->quantity - $model->returned) * $model->sellingPrice;
                if ($model->taxable == 1) {
                    $model->tax = ($model->taxRate / 100) * $model->total;
                }
            }

        });
    }

    public function order()
    {
        return $this->belongsTo('App\SalesOrder', 'salesOrderId', 'id');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'productId', 'id');
    }

}

