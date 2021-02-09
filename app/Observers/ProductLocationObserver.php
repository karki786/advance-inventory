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
use Hashids\Hashids;
use Facades\CodedCell\Classes\InventoryWatcher;
use App\Helper;

class ProductLocationObserver
{

    public function saved(ProductLocation $location)
    {

        $hashids = new Hashids('', 8);

        $temp = $location;
        if($location->hash == null){
            $count = $location->amount;
            $location->amount = 1;
            $location->hash = $hashids->encode(rand(200000000, 800000000), rand(1, 200000000));
            for ($x = 1; $x < $count; $x++) {
                $newLocation = $location->replicate();
                $newLocation->hash = $location->hash;
                $newLocation->amount = 1;
                $newLocation->save();
            }
            Helper::labelDetailsHelper(Product::withoutGlobalScopes()->find($location->productId),$location);
            $location->save();
        }
        return $temp;
    }

}