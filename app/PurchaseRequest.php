<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\MultitenantTrait;
use CodedCell\Traits\ActionTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRequest extends Model
{
    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    use SoftDeletes;

    protected $presenter = 'CodedCell\Presenters\PurchaseRequest';

    protected $notNullable = [];

    /** Turn Empties to Nullables */
    public static function boot()
    {
        parent::boot();
        static::saving(function ($model) {
            foreach ($model->attributes as $key => $value) {
                if (in_array($key, $model->notNullable) == false) {
                    $model->{$key} = empty($value) ? null : $value;
                }
            }
        });
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

    public function requests()
    {
        return $this->hasMany('App\PurchaseRequestItem', 'purchaserequestId', 'id');
    }

    public function requestOwner()
    {
        return $this->belongsTo('App\User', 'owner', 'id');
    }

    public function requestedBy()
    {
        return $this->belongsTo('App\User', 'requesterName', 'id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'departmentId', 'id');
    }

    public function scopeWaitingApproval($query)
    {
        return $query->whereRequestapproved(0);
    }

    public function scopeRequestApproved($query)
    {
        return $query->whereRequestapproved(1)->where('lpoCreated', 0);
    }

    public function scopeLpoCreated($query)
    {
        return $query->whereLpocreated(1)->whereLpoapproved(0);
    }

    public function scopeLpoApproved($query)
    {
        return $query->whereLpoapproved(1);
    }

}
