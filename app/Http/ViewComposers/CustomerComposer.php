<?php namespace App\Http\ViewComposers;

use App\Country;

use Illuminate\Contracts\View\View;

class CustomerComposer
{

    public function __construct()
    {

    }

    public function compose(View $view)
    {
        $view->with('countries', Country::select('country')->pluck('country', 'country'));
        $view->with('currency', Country::select('currency')->pluck('currency', 'currency'));

    }


}