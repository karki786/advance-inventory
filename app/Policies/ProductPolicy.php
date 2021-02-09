<?php

namespace App\Policies;

use App\Product;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    protected $BaseModel = 'Product';
    protected $ability = 'Product';

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
     * Determine whether the user can view the product.
     *
     * @param  \App\User $user
     * @param  \App\Product $product
     * @return mixed
     */
    public function view(User $user, Product $product)
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
     * Determine whether the user can create products.
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
     * Determine whether the user can update the product.
     *
     * @param  \App\User $user
     * @param  \App\Product $product
     * @return mixed
     */
    public function update(User $user, Product $product)
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
     * Determine whether the user can delete the product.
     *
     * @param  \App\User $user
     * @param  \App\Product $product
     * @return mixed
     */
    public function delete(User $user, Product $product)
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
