<?php

namespace App;

use CodedCell\Presenters\PresentableTrait;
use CodedCell\Traits\ActionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Translation extends Model
{
    use SoftDeletes;
    use PresentableTrait;

    use ActionTrait;

    protected $presenter = 'CodedCell\Presenters\Translation';
    protected $guarded = [];

    public function lang()
    {
        return $this->hasOne('App\Language', 'id', 'languageId');
    }
}
