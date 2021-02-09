<?php namespace App;

use Carbon\Carbon;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use CodedCell\Presenters\PresentableTrait;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use PresentableTrait;
    use SoftDeletes;

    protected $presenter = 'CodedCell\Presenters\Staff';
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

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

    public function department()
    {
        return $this->belongsTo('App\Department', 'departmentId', 'id');
    }

    public function role()
    {
        return $this->hasMany('App\ModulePermission', 'roleId', 'role_id');
    }

    public function company()
    {
        return $this->hasOne('App\Company', 'id', 'companyId');
    }
    public function myrole()
    {
        return $this->hasOne('App\Role', 'id', 'role_id');
    }

    public function hasRole($model)
    {

        $this->have_role = $this->getUserRole($model);

        // Check if the user is a root account
        if ($this->have_role == null) {
            return null;
        }
        return $this->have_role;

        if ($this->have_role->name == 'Root') {
            return true;
        }
        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->checkIfUserHasRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->checkIfUserHasRole($roles);
        }
        return false;
    }

    private function getUserRole($model)
    {

        return $this->role()->where('model', '=', $model)->first();
    }

    private function checkIfUserHasRole($need_role)
    {
        return (strtolower($need_role) == strtolower($this->have_role->name)) ? true : false;
    }

    public function scopeName($query, $type)
    {
        if ($type != null or $type != "")
            return $query->whereName($type);
    }

    public function scopeEmail($query, $type)
    {
        if ($type != null or $type != "")
            return $query->whereEmail($type);
    }

    public function scopeRole_Id($query, $type)
    {
        if ($type != null or $type != "")
            return $query->whereRoleId($type);
    }

    public function scopeDepartmentId($query, $type)
    {
        if ($type != null or $type != "")
            return $query->whereDepartmentid($type);
    }


    /**
     * Confirm the user.
     *
     * @return void
     */
    public function confirmEmail()
    {
        $this->verified = true;
        $this->token = null;
        $this->save();
    }

    public function scopeTrash($query)
    {
        return $query->onlyTrashed();
    }

    public function scopeLastUpdate($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeToday($query)
    {
        return $query->where('created_at', '>', Carbon::today())->where('created_at', '<', Carbon::today()->addDay());
    }

    public function scopeWeek($query)
    {
        return $query->where('created_at', '>', Carbon::today()->subWeek())->where('created_at', '<', Carbon::today()->addDay());
    }

    public function scopeMonth($query)
    {
        return $query->where('created_at', '>', Carbon::today()->subMonth())->where('created_at', '<', Carbon::today()->addDay());
    }

}
