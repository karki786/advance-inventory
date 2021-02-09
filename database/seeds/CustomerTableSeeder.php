<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory(App\Customer::class, 50)->create();
        factory(App\Customer::class)->create(array('email' => 'example@example.com', 'password' => bcrypt('test123')))->each(function ($u) {
            $u->contacts()->save(factory(App\CustomerContact::class)->make());
        });
        factory(App\Customer::class)->create(array('email' => 'dwanyoike@codedcell.com', 'password' => bcrypt('test123')))->each(function ($u) {
            $u->contacts()->save(factory(App\CustomerContact::class)->make());
        });
        factory(App\Customer::class, 20)->create()->each(function ($u) {
            $u->contacts()->saveMany(factory(App\CustomerContact::class, 10)->make());
        });
    }
}
