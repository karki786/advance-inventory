<?php

namespace App\Policies;

use App\User;
use App\Warehouse;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarehousePolicy
{
    use HandlesAuthorization;
    protected $BaseModel = 'Warehouse';
    protected $ability = '';

    public function before($user, $ability)
    {
        $this->ability = 'can' . ucfirst($ability);
    }

    /**
     * Determine whether the user can create warehouses.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function glance(User $user)
    {
        $method = (string)$this->ability;
        if ($user->hasRole($this->BaseModel) === null) {
            return 0;
        }
        return $user->hasRole($this->BaseModel)->$method;
    }

    /**
     * Determine whether the user can view the warehouse.
     *
     * @param  \App\User $user
     * @param  \App\Warehouse $warehouse
     * @return mixed
     */
    public function view(User $user, Warehouse $warehouse)
    {
        if ($user->companyId != func_get_arg(1)->companyId) {
            return false;
        }
        $method = (string)$this->ability;
        if ($user->hasRole($this->BaseModel) === null) {
            return 0;
        }
        return $user->hasRole($this->BaseModel)->$method;
    }

    /**
     * Determine whether the user can create warehouses.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        $method = (string)$this->ability;
        if ($user->hasRole($this->BaseModel) === null) {
            return 0;
        }
        return $user->hasRole($this->BaseModel)->$method;
    }

    /**
     * Determine whether the user can update the warehouse.
     *
     * @param  \App\User $user
     * @param  \App\Warehouse $warehouse
     * @return mixed
     */
    public function update(User $user, Warehouse $warehouse)
    {
        if ($user->companyId != func_get_arg(1)->companyId) {
            return false;
        }
        $method = (string)$this->ability;
        if ($user->hasRole($this->BaseModel) === null) {
            return 0;
        }
        return $user->hasRole($this->BaseModel)->$method;
    }

    /**
     * Determine whether the user can delete the warehouse.
     *
     * @param  \App\User $user
     * @param  \App\Warehouse $warehouse
     * @return mixed
     */
    public function delete(User $user, Warehouse $warehouse)
    {
        if ($user->companyId != func_get_arg(1)->companyId) {
            return false;
        }
        $method = (string)$this->ability;
        if ($user->hasRole($this->BaseModel) === null) {
            return 0;
        }
        return $user->hasRole($this->BaseModel)->$method;
    }
}
