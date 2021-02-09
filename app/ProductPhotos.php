<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use CodedCell\Traits\ActionTrait;
use CodedCell\Traits\MultitenantTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPhotos extends Model
{

    use ActionTrait;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the file path.
     *
     * @param  string $value
     * @return string
     */
    public function getFilenameAttribute($value)
    {
        return array('path' => url('products') . '/' . $value, 'filename' => $value);
    }


    /**
     * Get the file path.
     *
     * @param  string $value
     * @return string
     */
    public function getCaptionAttribute($value)
    {
        if ($value == "" or $value == null) {
            return "Please enter an Image Caption";
        }
        return $value;

    }

    /**
     * Get the file path.
     *
     * @param  string $value
     * @return string
     */
    public function getTitleAttribute($value)
    {
        if ($value == "" or $value == null) {
            return "Please enter an Image Title";
        }
        return $value;
    }
}
