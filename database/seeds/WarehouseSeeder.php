<?php

use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        DB::table('warehouses')->delete();
        DB::table('storage_locations')->delete();
        factory(App\Warehouse::class, 10)->create()->each(function ($u) {
            $u->binLocations()->saveMany(factory(App\StorageLocation::class, 20)->make());
        });
    }
}
