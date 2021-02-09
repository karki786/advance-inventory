<?php

namespace App;

use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use CodedCell\Presenters\PresentableTrait;

class Staff extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    use PresentableTrait;
    use SoftDeletes;

    protected $presenter = 'CodedCell\Presenters\Staff';
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
    protected $hidden = ['password', 'remember_token'];

    public function creator()
    {
        return $this->belongsTo('App\User', 'createdBy', 'id');
    }

    public function updater()
    {
        return $this->belongsTo('App\User', 'updatedBy', 'id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department', 'departmentId', 'id');
    }

    public function getNameAndDepartmentAttribute()
    {
        return $this->attributes['name'] . "(" . $this->department->name . ")";
    }

    public function dispatches()
    {
        return $this->hasMany('App\Dispatch', 'userId', 'id');
    }

    public function company()
    {
        return $this->hasOne('App\Company', 'id', 'companyId');
    }

    /**
     * Set the user's first name.
     *
     * @param  string $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
