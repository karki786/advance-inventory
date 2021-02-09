<?php namespace App\Http\ViewComposers;

//App::singleton('ProductsComposer');
use App\Country;
use App\SalesOrder;
use CodedCell\Repository\Customer\CustomerInterface;
use CodedCell\Repository\Invoice\InvoiceInterface;
use CodedCell\Repository\Product\ProductInterface;
use Illuminate\Contracts\View\View;
use DB;
use App\Helper;

class InvoiceComposer
{

    protected $customer;
    protected $product;

    public function __construct(ProductInterface $product, CustomerInterface $customer, InvoiceInterface $invoice)
    {
        $this->product = $product;
        $this->customer = $customer;
        $this->invoice = $invoice;
    }

    public function compose(View $view)
    {
        $x = $this->product->getProductForDataGrid()->toArray();
        array_unshift($x, array('id' => 'null', 'multilocation' => 1, 'productName' => '', 'text' => 'Please Choose an Item'));
        //$view->with('products', $this->product->productsList());
        $view->with('customers', Helper::selectArray($this->customer->all()->pluck('companyName', 'id')->all()));

        $view->with('orders', Helper::selectArray(SalesOrder::all()->pluck('orderNo', 'id')->all()));
        $view->with('prods', $x);

        $view->with('deletedCount', count($this->invoice->all(array('*'), $scope = 'deletions')));
        $view->with('paidCount', count($this->invoice->all(array('*'), $scope = 'paid')));
        $view->with('unpaidCount', count($this->invoice->all(array('*'), $scope = 'unpaid')));
        $countries = Country::select(DB::raw('currency'))->get()->toArray();
        $countryList = array();
        foreach ($countries as $country) {
            array_push($countryList, array('id' => $country['currency'], 'text' => $country['currency']));
        }
        $view->with('countries', $countryList);
    }




}