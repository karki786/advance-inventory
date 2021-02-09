<?php

namespace App\Policies;

use App\User;
use App\Restock;
use Illuminate\Auth\Access\HandlesAuthorization;

class RestockPolicy
{
    use HandlesAuthorization;
    protected $BaseModel = 'Restock';
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
     * Determine whether the user can view the restock.
     *
     * @param  \App\User $user
     * @param  \App\Restock $restock
     * @return mixed
     */
    public function view(User $user, Restock $restock)
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
     * Determine whether the user can create restocks.
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
     * Determine whether the user can update the restock.
     *
     * @param  \App\User $user
     * @param  \App\Restock $restock
     * @return mixed
     */
    public function update(User $user, Restock $restock)
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
     * Determine whether the user can delete the restock.
     *
     * @param  \App\User $user
     * @param  \App\Restock $restock
     * @return mixed
     */
    public function delete(User $user, Restock $restock)
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
