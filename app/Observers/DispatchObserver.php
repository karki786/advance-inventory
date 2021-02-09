<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 20/May/2017
 * Time: 6:01 PM
 */

namespace App\Observers;

use App\Dispatch;
use App\Product;
use App\ProductPhotos;
use App\SalesOrder;
use App\SalesOrderItem;
use App\ProductLocation;
use Facades\CodedCell\Classes\InventoryWatcher;
use Hashids\Hashids;

class DispatchObserver
{


    /**
     * Listen to the SalesOrderItem created event.
     *
     * @param  SalesOrderItem $salesOrderItem
     * @return void
     */
    public function created(Dispatch $dispatch)
    {

        $storage = Product::find($dispatch->dispatchedItem)->usesMultipleStorage;
        if ($storage) {
            $loc = ProductLocation::where('hash', $dispatch->productLocationHash)->first();
            $dispatch->isMultipleStorage = 1;
            $dispatch->warehouseId = $loc->productLocation;
            $dispatch->binLocationId = $loc->binLocation;
            $dispatch->productLocationId = $loc->id;
            InventoryWatcher::decreaseProductMagic($dispatch->dispatchedItem, $dispatch->amount, $dispatch->productLocationHash);
        } else {
            InventoryWatcher::decreaseProductMagic($dispatch->dispatchedItem, $dispatch->amount, null);
        }

    }

    public function updating(Dispatch $dispatch)
    {

        $storage = Product::find($dispatch->dispatchedItem)->usesMultipleStorage;
        if ($storage) {
            $loc = ProductLocation::where('hash', $dispatch->productLocationHash)->first();
            $dispatch->isMultipleStorage = 1;
            $dispatch->warehouseId = $loc->productLocation;
            $dispatch->binLocationId = $loc->binLocation;
            $dispatch->productLocationId = $loc->id;
            InventoryWatcher::increaseProductMagic($dispatch->dispatchedItem, $dispatch->getOriginal('amount'), $dispatch->productLocationHash);
            InventoryWatcher::decreaseProductMagic($dispatch->dispatchedItem, $dispatch->amount, $dispatch->productLocationHash);
        } else {
            InventoryWatcher::increaseProductMagic($dispatch->dispatchedItem, $dispatch->getOriginal('amount'), $dispatch->productLocationHash);
            InventoryWatcher::decreaseProductMagic($dispatch->dispatchedItem, $dispatch->amount, null);
        }

    }



    public function deleting(Dispatch $dispatch)
    {
        InventoryWatcher::increaseProductMagic($dispatch->dispatchedItem, $dispatch->amount, $dispatch->productLocationHash);
    }
}