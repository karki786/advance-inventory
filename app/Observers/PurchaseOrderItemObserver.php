<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 15/May/2017
 * Time: 7:11 PM
 */

namespace App\Observers;


use App\Product;
use App\ProductLocation;
use App\PurchaseOrderItem;
use Hashids\Hashids;
use Facades\CodedCell\Classes\InventoryWatcher;

class PurchaseOrderItemObserver
{

    public function created(PurchaseOrderItem $item)
    {
        $storage = Product::find($item->productId)->usesMultipleStorage;
        $item->usesMultipleStorage = $storage;
        $item->save();
    }

}