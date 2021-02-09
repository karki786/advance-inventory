<?php namespace App\Http\ViewComposers;

//App::singleton('ProductsComposer');
use App\Customer;

use CodedCell\Repository\Customer\CustomerInterface;

use Illuminate\Contracts\View\View;
use App\Helper;
class PaymentsComposer
{

    protected $customer;


    public function __construct( CustomerInterface $customer)
    {

        $this->customer = $customer;
    }

    public function compose(View $view)
    {

       // $view->with('invoices', ['' => 'Please Choose'] + Invoice::where('paid', 0)->get()->pluck('invoiceNo', 'id')->all());
        $view->with('customers', Helper::selectArray(Customer::has('invoices')->get()->pluck('companyName', 'id')->all()));
       // $view->with('customers', ['' => 'Please Choose'] + Customer::has('invoices')->get()->pluck('companyName', 'id')->all());
    }


}