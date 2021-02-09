<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use PresentableTrait;
    use MultitenantTrait;
    use ActionTrait;
    use SoftDeletes;

    protected $presenter = 'CodedCell\Presenters\Warehouse';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the comments for the blog post.
     */
    public function products()
    {
        return $this->hasMany('App\ProductLocation', 'productLocation', 'id');
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
     * Get Quote Lines
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function binLocations()
    {
        return $this->hasMany('App\StorageLocation', 'whsId', 'id');
    }
}
