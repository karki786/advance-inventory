<?php

use Illuminate\Database\Seeder;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\Invoice::class, 20)->create(array('customerId' => 1, 'contactId' => 1))->each(function ($u) {
            $u->items()->saveMany(factory(App\InvoiceItem::class, 10)->make());
        });

        factory(App\Invoice::class, 50)->create()->each(function ($u) {
            $u->items()->saveMany(factory(App\InvoiceItem::class, 10)->make());
        });

    }
}
