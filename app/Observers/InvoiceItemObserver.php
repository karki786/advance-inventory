<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 3/26/2017
 * Time: 13:55
 */

namespace App\Observers;

use App\InvoiceItem;
use App\Invoice;
use App\Product;
use App\ProductLocation;
use Facades\CodedCell\Classes\InventoryWatcher;
use Hashids\Hashids;

class InvoiceItemObserver
{


    public function created(InvoiceItem $invoiceItem)
    {
        $hashids = new Hashids('', 8);
        $invoiceItem->hash = $hashids->encode($invoiceItem->id, rand(1, 2000));
        $invoiceItem->save();
        if (Invoice::find($invoiceItem->invoiceId)->onHold == 1) {
            InventoryWatcher::decreaseProductMagic($invoiceItem->productId, $invoiceItem->quantity, $invoiceItem->hash);
        }
    }

    public function updated()
    {

    }


    public function saving(InvoiceItem $item)
    {
        $item->tax = 0;
        if ($item->taxable == 1) {
            $item->tax = ($item->taxRate / 100) * $item->total;
        }
        $item->total = (($item->quantity * $item->convertedPrice) + $item->tax) - $item->discount;

    }

    public function saved(InvoiceItem $item)
    {
        /*
        InventoryWatcher::decreaseProduct($item->productId, $item->quantity, $item->binLocation);
        */
    }
}