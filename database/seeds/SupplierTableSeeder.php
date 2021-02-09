<?php

use App\Supplier;
use Illuminate\Database\Seeder;

class SupplierTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        DB::table('suppliers')->truncate();
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 40; $i++) {
            $supplier = Supplier::create(array(
                'supplierName' => $faker->company,
                'address' => $faker->streetAddress,
                'location' => $faker->buildingNumber,
                'website' => $faker->domainName,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'companyId' => 1

            ));
        }
    }
}
