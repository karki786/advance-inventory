<?php namespace App\Http\ViewComposers;

use CodedCell\Repository\Department\DepartmentInterface;
use CodedCell\Repository\Shipping\ShippingInterface;
use CodedCell\Repository\User\UserInterface;
use CodedCell\Repository\UserRoles\UserRolesInterface;
use Illuminate\Contracts\View\View;

class StaffFormComposer
{

    public function __construct(DepartmentInterface $department, UserRolesInterface $roles, UserInterface $user)
    {
        $this->department = $department;
        $this->roles = $roles;
        $this->user = $user;
    }

    public function compose(View $view)
    {
        $view->with('departments', $this->department->departmentList());
        $view->with('roles', $this->roles->roleList());
    }


}