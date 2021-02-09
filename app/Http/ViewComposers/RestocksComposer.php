<?php namespace App\Http\ViewComposers;

use CodedCell\Repository\Warehouse\WarehouseInterface;
use Illuminate\Contracts\View\View;
use CodedCell\Repository\User\UserInterface;
use CodedCell\Repository\Restock\RestockInterface;
use CodedCell\Repository\Product\ProductInterface;
use CodedCell\Repository\Supplier\SupplierInterface;

class RestocksComposer
{

    public function __construct(ProductInterface $product, SupplierInterface $supplier, WarehouseInterface $warehouse)
    {
        $this->product = $product;
        $this->supplier = $supplier;
        $this->warehouse = $warehouse;
    }

    public function compose(View $view)
    {
        $x = $this->product->getProductForRestock()->toArray();
        array_unshift($x, array('id' => 'null', 'multilocation' => 1, 'productName' => '', 'text' => 'Please Choose an Item'));
        $view->with('prods', $x);
        $x = $this->product->getWarehouseLocationsForGrid()->toArray();
        array_unshift($x, array('id' => 'null', 'multilocation' => 1, 'productName' => '', 'text' => 'Please Choose a location'));
        $view->with('locs', json_encode($x));
        $view->with('warehouses', $this->warehouse->getWarehouseSelectList());
        $view->with('allSuppliers', $this->supplier->supplierList());
    }


}