<?php

namespace App\Policies;

use App\User;
use App\SalesOrder;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesOrderPolicy
{
    use HandlesAuthorization;

    protected $BaseModel = 'SalesOrder';
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
     * Determine whether the user can view the salesOrder.
     *
     * @param  \App\User $user
     * @param  \App\SalesOrder $salesOrder
     * @return mixed
     */
    public function view(User $user, SalesOrder $salesOrder)
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
     * Determine whether the user can create salesOrders.
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
     * Determine whether the user can update the salesOrder.
     *
     * @param  \App\User $user
     * @param  \App\SalesOrder $salesOrder
     * @return mixed
     */
    public function update(User $user, SalesOrder $salesOrder)
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
     * Determine whether the user can delete the salesOrder.
     *
     * @param  \App\User $user
     * @param  \App\SalesOrder $salesOrder
     * @return mixed
     */
    public function delete(User $user, SalesOrder $salesOrder)
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
