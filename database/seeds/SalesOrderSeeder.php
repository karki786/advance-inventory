<?php

use Illuminate\Database\Seeder;

class SalesOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\SalesOrder::class, 20)->create()->each(function ($u) {
            $u->items()->saveMany(factory(App\SalesOrderItem::class, 10)->make());
        });
    }
}
