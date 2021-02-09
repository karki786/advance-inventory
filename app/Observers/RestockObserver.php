<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 15/May/2017
 * Time: 7:11 PM
 */

namespace App\Observers;


use App\PurchaseOrderItem;
use App\Restock;
use Hashids\Hashids;
use Facades\CodedCell\Classes\InventoryWatcher;

class RestockObserver
{

    public function deleting(Restock $restock)
    {
        InventoryWatcher::decreaseProductMagic($restock->productID, $restock->amount, $restock->locationHash);
        if ($restock->lpoId != null) {
            $item = PurchaseOrderItem::where('lpoId', $restock->lpoId)->where('productId', $restock->productID)->first();
            $item->decrement('delivered', $restock->amount);
        }
    }

    public function updating(Restock $restock)
    {
        InventoryWatcher::decreaseProductMagic($restock->productID, $restock->getOriginal('amount'), $restock->locationHash);
        InventoryWatcher::increaseProductMagic($restock->productID, $restock->amount, $restock->locationHash);
        if ($restock->lpoId != null) {
            $item = PurchaseOrderItem::where('lpoId', $restock->lpoId)->where('productId', $restock->productID)->first();
            $item->decrement('delivered', $restock->amount);
        }
    }


}