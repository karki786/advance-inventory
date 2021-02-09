<?php

use App\Product;
use App\ProductLocation;
use App\Restock;
use Illuminate\Database\Seeder;
use Facades\CodedCell\Classes\InventoryWatcher;
use App\StorageLocation;
class RestockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $itemCost = $faker->numberBetween($min = 100, $max = 2000);
            $productId = $faker->numberBetween($min = 1, $max = 108);
            $prod = Product::find($productId);
            $amount = $faker->numberBetween($min = 1, $max = 2);
            $unitCost = $itemCost / $amount;
            $product = array(
                'productID' => $productId,
                'supplierID' => $faker->numberBetween($min = 1, $max = 40),
                'itemCost' => $itemCost,
                'amount' => $amount,
                'unitCost' => $unitCost,
                'remarks' => $faker->sentence($nbWords = 5),
                'receivedBy' => 1,
                'companyId' => 1,
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now')
            );
            if ($prod->usesMultipleStorage) {
                $loc = StorageLocation::find($faker->numberBetween($min = 1, $max = 20));
                $product['binLocationId'] = $loc->id;
                $product['warehouseId'] = $loc->whsId;
                $loc = ProductLocation::create(array(
                    'productId' => $product['productID'],
                    'productLocation' => $loc->id,
                    'productLocationName' => $loc->warehouse->whsName,
                    'binLocation' => $loc->id,
                    'binLocationName' => $loc->binCode,
                    'productBarcode' => $prod->barcode,
                    'unitCost' => $prod->unitCost,
                    'sellingPrice' => $prod->sellingPrice,
                    'amount' => $product['amount']
                ));
                $product['locationHash'] = $loc->hash;
            }
            $restock = Restock::create($product);
            Auth::loginUsingId(1);
            //InventoryWatcher::decreaseInWarehouseByHash($location->hash, $realAmount-$amount);
            Product::find($restock->productID)->update(array('unitCost' => $restock->unitCost));
        }
    }
}
