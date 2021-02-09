<?php namespace App\Http\ViewComposers;



use CodedCell\Repository\User\UserInterface;
use Illuminate\Contracts\View\View;

class SidebarComposer
{

    /**
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function compose(View $view)
    {

        #User
        $view->with('users', $this->user->getCompanyMembers());


    }


}