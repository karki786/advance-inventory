<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;

class StorageLocation extends Model
{
    use PresentableTrait;
    use ActionTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $presenter = 'CodedCell\Presenters\StorageLocation';

    /**
     * Get the comments for the blog post.
     */
    public function products()
    {
        return $this->hasMany('App\ProductLocation', 'binLocation', 'id');
    }

    public function warehouse(){
        return $this->hasOne('App\Warehouse', 'id', 'whsId');
    }
}
