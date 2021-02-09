<?php namespace App\Http\ViewComposers;

use App\PurchaseRequest;
use CodedCell\Repository\Department\DepartmentInterface;
use CodedCell\Repository\Dispatch\DispatchInterface;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\PurchaseOrder\PurchaseOrderInterface;
use CodedCell\Repository\Staff\StaffInterface;
use CodedCell\Repository\Supplier\SupplierInterface;
use CodedCell\Repository\User\UserInterface;
use Illuminate\Contracts\View\View;
use App\PurchaseOrder;

class PurchaseRequestComposer
{

    /**
     * @var SupplierInterface
     */
    private $supplier;

    public function __construct(StaffInterface $staff, DepartmentInterface $department, ProductInterface $product, SupplierInterface $supplier, PurchaseOrderInterface $purchaseOrder)
    {
        $this->product = $product;

        $this->supplier = $supplier;

        $this->purchaseOrder = $purchaseOrder;

        $this->department = $department;

        $this->staff = $staff;

    }

    public function compose(View $view)
    {
        $view->with('products', $this->purchaseOrder->autoSuggestList());
        $view->with('suppliers', $this->supplier->supplierList());
        $view->with('awaitingApproval', PurchaseRequest::waitingApproval()->count());
        $view->with('approvedRequests', PurchaseRequest::requestApproved()->count());
        $view->with('lpoCreated', PurchaseRequest::lpoCreated()->count());
        $view->with('lpoApproved', PurchaseRequest::lpoApproved()->count());
        $view->with('departments', $this->department->departmentList());
        $view->with('staff', $this->staff->staffList());
    }


}