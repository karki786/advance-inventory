<?php

use App\Staff;
use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // DB::table('staff')->truncate();
        Auth::loginUsingId(1);
        $faker = Faker\Factory::create();
        Staff::create(array(
            'name' => 'Dennis Wanyoike',
            'email' => 'support@codedcell.com',
            'password' => 'test123',
            'departmentId' => $faker->numberBetween($min = 2, $max = 8),
            'companyId' => 1
        ));
        for ($i = 0; $i < 40; $i++) {
            $staff = Staff::create(array(
                'name' => $faker->name,
                'email' => $faker->email,
                'salutation' => $faker->title,
                'departmentId' => $faker->numberBetween($min = 1, $max = 15),
                'companyId' => 1
            ));
        }

    }
}
