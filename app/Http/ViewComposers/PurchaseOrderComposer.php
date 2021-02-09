<?php namespace App\Http\ViewComposers;

use App\Country;
use App\Helper;
use CodedCell\Repository\Department\DepartmentInterface;
use CodedCell\Repository\Dispatch\DispatchInterface;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\PurchaseOrder\PurchaseOrderInterface;
use CodedCell\Repository\Supplier\SupplierInterface;
use CodedCell\Repository\User\UserInterface;
use Illuminate\Contracts\View\View;
use App\PurchaseOrder;
use Auth;
use App\Company;
use Illuminate\Support\Facades\DB;

class PurchaseOrderComposer
{

    /**
     * @var SupplierInterface
     */
    private $supplier;

    public function __construct(DepartmentInterface $department, ProductInterface $product, SupplierInterface $supplier, PurchaseOrderInterface $purchaseOrder)
    {
        $this->product = $product;

        $this->supplier = $supplier;

        $this->purchaseOrder = $purchaseOrder;

        $this->department = $department;
    }

    public function compose(View $view)
    {
        $x = $this->product->getProductForDataGrid()->toArray();
        array_unshift($x, array('id' => 'null', 'multilocation' => 1, 'productName' => '', 'text' => 'Please Choose an Item'));
        $view->with('prods', $x);
        $countries = Country::select(DB::raw('currency'))->get()->toArray();
        $countryList = array();
        foreach ($countries as $country) {
            array_push($countryList, array('id' => $country['currency'], 'text' => $country['currency']));
        }
        $view->with('countries', $countryList);

        //$view->with('products', $this->purchaseOrder->autoSuggestList());

        $view->with('suppliers', Helper::selectArray($this->supplier->all(array())->pluck('supplierName', 'id')->all()));

        $orders = $this->purchaseOrder->all();
        $view->with('undeliveredCount', PurchaseOrder::undelivered()->count());
        $view->with('deliveredCount', PurchaseOrder::delivered()->count());
        $view->with('partdeliveredCount', PurchaseOrder::partdelivery()->count());
        $view->with('waitingApprovalCount', PurchaseOrder::waitingApproval()->count());
        $view->with('lateDeliveryCount', PurchaseOrder::lateDelivery()->count());
        $view->with('currency', Country::select('currency')->pluck('currency', 'currency'));
        $view->with('departments', $this->department->departmentList());
        $view->with('defaultLpoTaxAmount', Company::find(Auth::user()->companyId)->defaultLpoTaxAmmount);
    }


}