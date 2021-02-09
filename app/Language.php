<?php

namespace App;

use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{

    use SoftDeletes;
    use PresentableTrait;

    use ActionTrait;

    protected $presenter = 'CodedCell\Presenters\Language';
    protected $guarded = [];

    public function translations(){
        return $this->hasMany('App\Translation', 'languageId', 'id');

    }
}
