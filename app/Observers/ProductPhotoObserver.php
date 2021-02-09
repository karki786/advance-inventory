<?php
/**
 * Created by PhpStorm.
 * User: dwanyoike
 * Date: 20/May/2017
 * Time: 6:01 PM
 */

namespace App\Observers;

use App\Product;
use App\ProductPhotos;
use App\SalesOrder;
use App\SalesOrderItem;
use Facades\CodedCell\Classes\InventoryWatcher;
use Hashids\Hashids;

class ProductPhotoObserver
{


    /**
     * Listen to the SalesOrderItem created event.
     *
     * @param  SalesOrderItem $salesOrderItem
     * @return void
     */
    public function created(ProductPhotos $photo)
    {
        $hashids = new Hashids('', 8);
        $photo->photoHash = $hashids->encode($photo->id, rand(1, 2000));
        $photo->save();
    }
}