<?php namespace App\Http\ViewComposers;

//App::singleton('ProductsComposer');
use CodedCell\Repository\User\UserInterface;
use Illuminate\Contracts\View\View;

class WarehouseComposer
{

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function compose(View $view)
    {
        $view->with('users', $this->user->usersList());
    }


}