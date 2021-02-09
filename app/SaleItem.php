<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class SaleItem extends Model
{
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

    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->total = $model->quantity * $model->sellingPrice;
            if ($model->taxable == 1) {
                $model->tax = ($model->taxRate / 100) * $model->total;
            }
        });

        static::creating(function ($model) {

            $user = Auth::user();
            $model->companyId = $user->companyId;
            $model->createdBy = $user->id;
        });

        static::updating(function ($model) {

            if (Auth::check()) {
                $user = Auth::user();
                $model->companyId = $user->companyId;
                $model->updatedBy = $user->id;
                $model->total = $model->quantity * $model->sellingPrice;
                if ($model->taxable == 1) {
                    $model->tax = ($model->taxRate / 100) * $model->total;
                }
            }

        });
    }

}
