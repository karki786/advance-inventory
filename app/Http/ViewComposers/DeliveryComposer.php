<?php namespace App\Http\ViewComposers;

//App::singleton('ProductsComposer');
use CodedCell\Repository\SalesOrder\SalesOrderInterface;
use CodedCell\Repository\Staff\StaffInterface;
use Illuminate\Contracts\View\View;

class DeliveryComposer
{

    protected $customer;
    protected $product;

    public function __construct(SalesOrderInterface $sales, StaffInterface $staffInterface)
    {
        $this->sales = $sales;
        $this->staff = $staffInterface;
    }

    public function compose(View $view)
    {
        $view->with('staff', $this->staff->all(array())->pluck('name','id'));

    }


}