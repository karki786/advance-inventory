<?php

use App\Dispatch;
use App\Product;
use App\User;
use Illuminate\Database\Seeder;
use App\ProductLocation;
use Facades\CodedCell\Classes\InventoryWatcher;

class DispatchTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        DB::table('dispatches')->truncate();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 200; $i++) {
            $dispatchedItem = Product::has('locations', '>=', 4)->inRandomOrder()->first();
            $dispatchedTo = User::inRandomOrder()->first();
            $amount = 1;
            $location = $dispatchedItem->locations->random();
            $products = ProductLocation::where('hash', $location->hash)->get();
            $realAmount = $products->sum('amount');
            $totalCost = floatval($location->unitCost) * floatval($amount);
            $date = $faker->dateTimeBetween($startDate = '-30 days', $endDate = 'now');
            Dispatch::create(array(
                'dispatchedItem' => $dispatchedItem->id,
                'dispatchedTo' => $dispatchedTo->id,
                'departmentId' => '',
                'userId' => $faker->numberBetween($min = 1, $max = 5),
                'amount' => $faker->numberBetween($min = 1, $max = 3),
                'remarks' => $faker->sentence($nbWords = 5),
                'totalCost' => $totalCost,
                'created_at' => $date,
                'updated_at' => $date,
                'companyId' => 1,
                'warehouseId' => $location->productLocation,
                'binLocationId' => $location->binLocation,
                'productLocationHash' => $location->hash
            ));

            InventoryWatcher::decreaseProductMagic($dispatchedItem->id, $amount, $location->hash);
        }
    }
}
