<?php namespace App\Http\ViewComposers;

//App::singleton('ProductsComposer');
use CodedCell\Repository\SalesOrder\SalesOrderInterface;
use Illuminate\Contracts\View\View;

class SalesOrderComposer
{

    protected $customer;
    protected $product;

    public function __construct(SalesOrderInterface $sales)
    {
        $this->sales = $sales;
    }

    public function compose(View $view)
    {
        $view->with('deletedCount', count($this->sales->all(array('*'), $scope = 'deletions')));
        $view->with('unInvoicedCount', count($this->sales->all(array('*'), $scope = 'uninvoiced')));
        $view->with('invoicedCount', count($this->sales->all(array('*'), $scope = 'invoiced')));
        $view->with('approvedCount', count($this->sales->all(array('*'), $scope = 'approved')));
    }


}