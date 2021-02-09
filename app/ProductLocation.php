<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CodedCell\Presenters\PresentableTrait;

class ProductLocation extends Model
{
    use PresentableTrait;

    protected $presenter = 'CodedCell\Presenters\ProductLocation';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $hidden = ['created_at', 'updated_at'];

    /**
     * Get the comments for the blog post.
     */
    public function product()
    {
        return $this->hasOne('App\Product', 'id', 'productId');
    }
    public function warehouse()
    {
        return $this->hasOne('App\Warehouse', 'id', 'productLocation');
    }


}
