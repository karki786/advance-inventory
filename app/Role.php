<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    protected $guarded = [];

    public function users()
    {
        return $this->hasMany('App\User', 'role_id', 'id');
    }

    public function permissions()
    {
        return $this->hasMany('App\ModulePermission', 'roleId', 'id');
    }

}
