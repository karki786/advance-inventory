<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 20/May/2017
 * Time: 6:01 PM
 */

namespace App\Observers;

use App\Product;
use App\SalesOrder;
use App\SalesOrderItem;
use Facades\CodedCell\Classes\InventoryWatcher;
use Hashids\Hashids;

class SalesOrderItemObserver
{



    /**
     * Listen to the SalesOrderItem created event.
     *
     * @param  SalesOrderItem $salesOrderItem
     * @return void
     */
    public function created(SalesOrderItem $salesOrderItem)
    {
        $hashids = new Hashids('', 8);
        $salesOrderItem->hash = $hashids->encode($salesOrderItem->id, rand(1, 2000));
        $salesOrderItem->save();
        if (SalesOrder::find($salesOrderItem->salesOrderId)->onHold == 1) {
            if (Product::find($salesOrderItem->productId)->usesMultipleStorage == true) {
                InventoryWatcher::markAsOnHold($salesOrderItem->locationHash, $salesOrderItem->quantity, $salesOrderItem->hash);
            }
        }
    }

    /**
     * Listen to the SalesOrderItem deleting event.
     *
     * @param  SalesOrderItem $salesOrderItem
     * @return void
     */
    public function deleting(SalesOrderItem $salesOrderItem)
    {
        //
    }

    /**
     * Listen to the SalesOrderItem deleting event.
     *
     * @param  SalesOrderItem $salesOrderItem
     * @return void
     */
    public function saving(SalesOrderItem $item)
    {
        $item->tax = 0;
        if ($item->taxable == 1) {
            $item->tax = ($item->taxRate / 100) * $item->total;
        }
        $item->total = (($item->quantity * $item->convertedPrice) + $item->tax) - $item->discount;
    }

    /**
     * Listen to the SalesOrderItem deleting event.
     *
     * @param  SalesOrderItem $salesOrderItem
     * @return void
     */
    public function updating(SalesOrderItem $salesOrderItem)
    {
        //dd($salesOrderItem->getDirty());
    }

    /**
     * Listen to the SalesOrderItem deleting event.
     *
     * @param  SalesOrderItem $salesOrderItem
     * @return void
     */
    public function updated(SalesOrderItem $salesOrderItem)
    {
        //
    }
}