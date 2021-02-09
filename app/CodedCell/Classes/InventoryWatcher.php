<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 2/18/2017
 * Time: 14:02
 */

namespace CodedCell\Classes;

use App\Product;
use App\ProductLocation;

class InventoryWatcher
{

    public function markAsOnHold($hash, $count, $onHoldBy)
    {
        $products = ProductLocation::where('hash', $hash)->limit($count)->get();
        foreach ($products as $product) {
            $product->onHold = true;
            $product->onHoldBy = $onHoldBy;
            $product->save();
        }
    }

    public function releaseHold($hash, $count, $onHoldBy)
    {

    }

    public function validate($hash, $count)
    {
        $product = Product::find($hash);
        if (count($product) < 1) {
            $product = Product::where('hash','=', $hash)->first();
        }
        $amount = $product->amount;
        if ($count <= $amount) {
            return array('enough' => true, 'amount' => $amount, 'hash' => $hash);
        } else {
            return array('enough' => false, 'amount' => $amount);
        }
    }

    public function validateMultipleLocation($hash, $count)
    {
        $amount = ProductLocation::where('hash', $hash)->sum('amount');
        if ($count <= $amount) {
            return array('enough' => true, 'amount' => $amount, 'hash' => $hash);
        } else {
            return array('enough' => false, 'amount' => $amount);
        }
    }

    public function increaseProductAmount($hash, $count)
    {
        $products = ProductLocation::where('hash', $hash)->get();
        $amount = $products->sum('amount');
        return $amount + $count;
    }

    //Auto Decide Increase based on Product pass productId.
    public function increaseProduct($hash, $count, $productId)
    {
        $product = Product::find($productId);
        //Check if multiple Location

        if ($product->usesMultipleStorage == 1) {
            $this->increaseInWarehouseByHash($hash, $count);
        } else {
            $product->increment('amount', $count);
        }

        return $product;
    }


    public function increaseInWarehouseByHash($hash, $count)
    {
        $product = ProductLocation::where('hash', $hash)->first();
        $amount = ProductLocation::where('hash', $hash)->sum('amount');
        $limit = $count - $amount;
        //Check where ProductLocation is zero
        $zeroLocations = ProductLocation::where('hash', $hash)->where('amount', 0)->get();
        if (count($zeroLocations) >= $limit) {
            foreach ($zeroLocations->take($limit) as $location) {
                $location->update(array(
                    'productId' => $product->productId,
                    'productLocation' => $product->productLocation,
                    'productLocationName' => $product->productLocationName,
                    'binLocation' => $product->binLocation,
                    'binLocationName' => $product->binLocationName,
                    'amount' => 1,
                    'hash' => $product->hash));
            }
        } else {
            $remainder = $limit - count($zeroLocations);
            foreach ($zeroLocations->take(count($zeroLocations)) as $location) {
                $location->update(array(
                    'productId' => $product->productId,
                    'productLocation' => $product->productLocation,
                    'productLocationName' => $product->productLocationName,
                    'binLocation' => $product->binLocation,
                    'binLocationName' => $product->binLocationName,
                    'amount' => 1,
                    'hash' => $product->hash));
            }
            for ($x = 1; $x <= $remainder; $x++) {
                ProductLocation::create(array(
                    'productId' => $product->productId,
                    'productLocation' => $product->productLocation,
                    'productLocationName' => $product->productLocationName,
                    'binLocation' => $product->binLocation,
                    'binLocationName' => $product->binLocationName,
                    'amount' => 1,
                    'hash' => $product->hash
                ));
            }
        }

    }

    public function decreaseProductAmount($hash, $count)
    {
        $products = ProductLocation::where('hash', $hash)->get();
        $amount = $products->sum('amount');
        return $amount - $count;
    }

    public function decreaseProductMagic($productId, $count, $hash)
    {
        $product = Product::find($productId);
        //Check if multiple Location
        if ($product->usesMultipleStorage == 1) {
            $amount = $this->decreaseProductAmount($hash, $count);
            if ($amount < 0) {
                return $product;
            }
            $this->decreaseInWarehouseByHash($hash, $amount);
        }
        if ($product->amount == 0 or $product->amount < 1) {
            return $product;
        }
        $product->decrement('amount', $count);
        return $product;
    }

    public function IncreaseProductMagic($productId, $count, $hash)
    {
        $product = Product::find($productId);
        //Check if multiple Location
        if ($product->usesMultipleStorage == 1) {
            $amount = $this->increaseProductAmount($hash, $count);
            $this->increaseInWarehouseByHash($hash, $amount);
        }
        $product->increment('amount', $count);
        return $product;
    }

//Used By Delete
    public function decreaseProduct($productId, $count, $binId = null)
    {
        $product = Product::find($productId);
        //Check if multiple Location
        if ($product->usesMultipleStorage == 1) {
            $this->decreaseProductInWarehouse($productId, $count, $binId);
        }
        $product->decrement('amount', $count);
        return $product;
    }

    public function decreaseInWarehouseByHash($hash, $count)
    {
        $products = ProductLocation::where('hash', $hash)->get();
        $amount = $products->sum('amount');
        $limit = $amount - $count;
        $products = ProductLocation::where('hash', $hash)->limit($limit)->get();
        foreach ($products as $product) {
            $product->decrement('amount', 1);
        }

    }

    //Used to return amounts to a certain level
    public function adjustLevels($hash, $count)
    {
        $products = ProductLocation::where('hash', $hash)->get();
        $amount = $products->sum('amount');
        if ($count < $amount) {
            $this->decreaseInWarehouseByHash($hash, $count);
        } elseif ($count > $amount) {
            $this->increaseInWarehouseByHash($hash, $count);
        }
    }
}
