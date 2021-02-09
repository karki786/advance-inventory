<?php

namespace App;

use Auth;
use Illuminate\Database\Eloquent\Model;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\MultitenantTrait;
use CodedCell\Traits\ActionTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class PurchaseOrder extends Model
{
    use SoftDeletes;
    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    protected $presenter = 'CodedCell\Presenters\PurchaseOrder';
    protected $dates = ['lpoApprovedOn'];



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'purchase_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];


    public function getLpostatusAttribute($value)
    {
        if ($value == 0) {
            return "Rejected";
        } elseif ($value == 1) {
            return "Approved";
        } elseif ($value == 2) {
            return "Awaiting Approval";
        }
    }

    public function orders()
    {
        return $this->hasMany('App\PurchaseOrderItem', 'lpoId', 'id');
    }

    public function supplier()
    {
        return $this->hasOne('App\Supplier', 'id', 'supplierId')->withTrashed();
    }

    public function department()
    {
        return $this->hasOne('App\Department', 'id', 'departmentId');
    }


    public function creator()
    {
        return $this->belongsTo('App\User', 'createdBy', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'updatedBy', 'id');
    }

    /**
     * Get Delivered Items
     * @param $query
     * @param $type
     * @return mixed
     */
    public function scopeDelivered($query)
    {
        return $query->whereFulldelivery(1);

    }

    /**
     * Get Undelivered Items
     * @param $query
     * @return mixed
     */
    public function scopeUndelivered($query)
    {
        return $query->whereFulldelivery(0)->wherePartdelivery(0)->whereLpostatus(1);
    }

    /**
     * Get Undelivered Items
     * @param $query
     * @return mixed
     */
    public function scopeLateDelivery($query)
    {
        return $query->whereFulldelivery(0)->where('deliverBy', '<', Carbon::today());
    }

    public function scopeWaitingApproval($query)
    {
        return $query->whereLpostatus(2);
    }

    /**
     * Get Part Delivery
     * @param $query
     * @return mixed
     */
    public function scopePartdelivery($query)
    {
        return $query->wherePartdelivery(1);
    }

}
