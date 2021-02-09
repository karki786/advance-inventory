<?php

use App\Product;
use App\ProductCategory;
use App\ProductLocation;
use App\Warehouse;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        DB::table('products')->delete();
        $path = storage_path() . '/stock.csv';
        Excel::load($path, function ($reader) {
            $faker = Faker\Factory::create();
            $results = $reader->get();
            $amount = $faker->numberBetween($min = 20, $max = 50);

            foreach ($results as $result) {
                $id = $faker->numberBetween($min = 1, $max = 6);
                $category = ProductCategory::find($id);
                $price = $faker->numberBetween($min = 100, $max = 300);
                $number = $faker->numberBetween($min = 10000000000, $max = 100000000000);
                $digit = \App\Helper::UPC_checkdigit((string) $number);
                $number = $number.$digit;
                $product = Product::create(array(
                    'productName' => $result->product,
                    'productSerial' => $faker->regexify('[A-Z0-9._%+-]+[A-Z0-9.-]+[A-Z]{2,4}'),
                    'amount' => $amount,
                    'location' => "Store",
                    'unitCost' => $price,
                    'sellingPrice' => $price + $faker->numberBetween($min = 5, $max = 20),
                    'reorderAmount' => $faker->numberBetween($min = 1, $max = 15),
                    'expiryDate' => $faker->date($format = 'Y-m-d', $max = 'now'),
                    'companyId' => 1,
                    'productSpecification' => $faker->paragraph(1),
                    'productCurrency' => 'USD',
                    'productWeight' => $faker->numberBetween($min = 4, $max = 100),
                    'productTaxRate' => 16,
                    'productManufacturer' => $faker->company,
                    'categoryName' => $category->categoryName,
                    'categoryId' => $category->id,
                    'usesMultipleStorage' => $faker->boolean(60),
                    'productMeasurementUnit'=>'KG',
                    'barcode' => $number
                ));
                if ($product->usesMultipleStorage == 1) {
                    $dist = array();
                    $positions = $faker->numberBetween($min = 4, $max = 6);
                    for ($i = 0; $i < $positions; $i++) {
                        $dist[$i] = floor($amount / $positions);
                    }
                    while ($amount - array_sum($dist) > 0) {
                        $locs = Warehouse::with('binLocations')->inRandomOrder()->first();
                        $price = $faker->numberBetween($min = 1000, $max = 20000);
                        $binLocation = $locs->binLocations->random(1)->first();
                        $number = $faker->numberBetween($min = 10000000000, $max = 100000000000);
                        $digit = \App\Helper::UPC_checkdigit((string) $number);
                        $number = $number.$digit;
                        ProductLocation::create(
                            array(
                                'productId' => $product->id,
                                'productLocation' => $locs->id,
                                'productLocationName' => $locs->whsName,
                                'binLocation' => $binLocation->id,
                                'binLocationName' => $binLocation->binCode,
                                'unitCost' => $price,
                                'productBarcode' => $number,
                                'sellingPrice' => $price + $faker->numberBetween($min = 100, $max = 900),
                                'amount' => $dist[array_rand($dist)]++
                            )
                        );
                    }


                }
            }
        });
    }
}
