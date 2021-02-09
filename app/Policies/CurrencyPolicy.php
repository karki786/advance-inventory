<?php

namespace App\Policies;

use App\User;
use App\Currency;
use Illuminate\Auth\Access\HandlesAuthorization;

class CurrencyPolicy
{
    use HandlesAuthorization;
    protected $BaseModel = 'Currency';
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
     * Determine whether the user can view the currency.
     *
     * @param  \App\User $user
     * @param  \App\Currency $currency
     * @return mixed
     */
    public function view(User $user, Currency $currency)
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
     * Determine whether the user can create currencies.
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
     * Determine whether the user can update the currency.
     *
     * @param  \App\User $user
     * @param  \App\Currency $currency
     * @return mixed
     */
    public function update(User $user, Currency $currency)
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
     * Determine whether the user can delete the currency.
     *
     * @param  \App\User $user
     * @param  \App\Currency $currency
     * @return mixed
     */
    public function delete(User $user, Currency $currency)
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
