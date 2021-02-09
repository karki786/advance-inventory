<?php namespace App\Http\ViewComposers;

//App::singleton('ProductsComposer');
use App\Country;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\Warehouse\WarehouseInterface;
use Illuminate\Contracts\View\View;

class CurrencyRequestComposer
{


    public function compose(View $view)
    {
        $view->with('currencies', Country::select('currency')->get()->pluck('currency', 'currency'));
    }


}