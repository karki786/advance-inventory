<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentCredit extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes excsoluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
