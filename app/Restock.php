<?php namespace App;

use CodedCell\Presenters\PresentableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CodedCell\Traits\MultitenantTrait;
use CodedCell\Traits\ActionTrait;

class Restock extends Model
{
    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    protected $presenter = 'CodedCell\Presenters\Restock';
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'restocks';

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

    public function warehouse()
    {
        return $this->hasOne('App\Warehouse', 'id', 'warehouseId');
    }

    public function binLocation()
    {
        return $this->hasOne('App\StorageLocation', 'id', 'binLocationId');
    }

    public function product()
    {
        return $this->belongsTo('App\Product', 'productID', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier', 'supplierID', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'receivedBy', 'id');
    }

    public function scopeProductID($query, $type)
    {
        if ($type != null or $type != "") {
            return $query->whereProductid($type);
        }
    }

    public function scopeUnitCost($query, $type)
    {
        if ($type != null or $type != "") {
            return $query->whereUnitcost($type);
        }
    }

    public function scopeAmount($query, $type)
    {
        if ($type != null or $type != "") {
            return $query->whereAmount($type);
        }
    }

    public function scopeSupplierID($query, $type)
    {
        if ($type != null or $type != "") {
            return $query->whereSupplierid($type);
        }
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
