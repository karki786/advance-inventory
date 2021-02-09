<?php namespace App\Http\ViewComposers;

//App::singleton('ProductsComposer');
use App\Country;
use CodedCell\Repository\Category\CategoryInterface;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\Warehouse\WarehouseInterface;
use Illuminate\Contracts\View\View;
use DB;

class AddProductsComposer
{

    public function __construct(WarehouseInterface $warehouse, ProductInterface $product, CategoryInterface $category)
    {
        $this->warehouse = $warehouse;
        $this->product = $product;
        $this->category = $category;
    }

    public function compose(View $view)
    {
        $x = $this->product->getWarehouseLocationsForGrid()->toArray();
        array_unshift($x, array('id' => 'null', 'multilocation' => 1, 'productName' => '', 'text' => 'Please Choose a location'));
        $view->with('locs', json_encode($x));
        $countries = Country::select(DB::raw('currency'))->get()->toArray();
        $countryList = array();
        foreach ($countries as $country) {
            array_push($countryList, array('id' => $country['currency'], 'text' => $country['currency']));
        }
        $view->with('currencies', $countryList);
        $view->with('categories', ['' => ''] + $this->category->all()->pluck('categoryName', 'id')->toArray());

    }


}