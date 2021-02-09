<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use CodedCell\Presenters\PresentableTrait;
class Company extends Model
{
    protected $presenter = 'CodedCell\Presenters\Company';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    use SoftDeletes;
}
