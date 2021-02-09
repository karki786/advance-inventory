<?php

namespace App;

use Auth;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Company;

class Receipt extends Model
{
    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    use SoftDeletes;

    protected $presenter = 'CodedCell\Presenters\Receipt';
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
            if (Auth::check()) {
                $user = Auth::user();
            } elseif (Auth::guard('customer')->check()) {
                $user = Auth::guard('customer')->user();
            }
            $model->salesPersonId = $user->id;
            $model->salesPersonText = $user->name;
            $model->companyId = $user->companyId;
            $model->createdBy = $user->id;
        });
    }

    public function items()
    {
        return $this->hasMany('App\ReceiptItem', 'receiptId', 'id');
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'createdBy', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'updatedBy', 'id');
    }
}
