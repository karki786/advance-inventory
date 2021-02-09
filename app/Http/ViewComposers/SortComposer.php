<?php namespace App\Http\ViewComposers;

//App::singleton('ProductsComposer');
use Illuminate\Contracts\View\View;
use Input;

class SortComposer
{

    public function __construct()
    {

    }

    public function compose(View $view)
    {
        $view->with('sort', [
                'sortBy' => Input::query('sortBy'),
                'direction' => Input::query('direction'),
                'search' => Input::query('search'),
                'status' => Input::query('status')
            ]
        );
        if (Input::query('search')) {
            $view->with('search', Input::query('search'));
        } else {
            $view->with('search', null);
        }

    }


}