<?php

namespace App;


use Auth;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\Model;


class PurchaseOrderItem extends Model
{

    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    protected $presenter = 'CodedCell\Presenters\PurchaseOrder';
    protected $dates = ['lpoApprovedOn'];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'creator', 'updater', 'updatedBy', 'createdBy'];


    protected static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            $model->total = $model->amount * $model->unitCost;
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
            }

        });
    }


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'purchase_orders_items';

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

    public function order()
    {
        return $this->belongsTo('App\PurchaseOrder', 'lpoId', 'id');
    }

}
