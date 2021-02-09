<?php namespace App;

use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dispatch extends Model
{
    use ActionTrait;
    use PresentableTrait;
    use MultitenantTrait;
    protected $presenter = 'CodedCell\Presenters\Dispatch';
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    //
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dispatches';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    public function getDates()
    {
        return ['deleted_at', 'created_at', 'updated_at'];
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'dispatchedItem', 'id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'departmentId', 'id');
    }

    public function warehouse()
    {
        return $this->hasOne('App\Warehouse', 'id', 'warehouseId');
    }

    public function binLocation()
    {
        return $this->hasOne('App\StorageLocation', 'id', 'binLocationId');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff', 'dispatchedTo', 'id');
    }


    public function creator()
    {
        return $this->belongsTo('App\User', 'createdBy', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'updatedBy', 'id');
    }

    public function scopeDispatchedItem($query, $type)
    {
        if ($type != null or $type != "")
            return $query->whereDispatcheditem($type);
    }

    public function scopeDispatchedTo($query, $type)
    {
        if ($type != null or $type != "")
            return $query->whereDispatchedto($type);
    }
}
