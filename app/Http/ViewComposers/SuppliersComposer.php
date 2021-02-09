<?php namespace App\Http\ViewComposers;

use CodedCell\Repository\Supplier\SupplierInterface;
use Illuminate\Contracts\View\View;

class SuppliersComposer
{

    public function __construct(SupplierInterface $supplier)
    {
        $this->supplier = $supplier;
    }

    public function compose(View $view)
    {
        $view->with('supplierCount', $this->supplier->getSuppliersCount());
        $view->with('deletedCount', $this->supplier->getDeletedSuppliersCount());
    }


}