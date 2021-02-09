<?php

use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $user = User::create(array(
            'name' => 'Dennis Wanyoike',
            'email' => 'dwanyoike@codedcell.com',
            'password' => Hash::make('test123'),
            'jobTitle' => 'Root Account',
            'role_id' => 1,
            'companyId' => 1
        ));
        $user = User::create(array(
            'name' => 'example',
            'email' => 'example@example.com',
            'password' => Hash::make('test123'),
            'jobTitle' => 'Root Account',
            'role_id' => 1,
            'companyId' => 1
        ));
        $user = User::create(array(
            'name' => 'dispatcher',
            'email' => 'dispatcher@codedcell.com',
            'password' => Hash::make('test123'),
            'role_id' => 3,
            'companyId' => 1
        ));
        $user = User::create(array(
            'name' => 'administrator',
            'email' => 'administrator@codedcell.com',
            'password' => Hash::make('test123'),
            'role_id' => 2,
            'companyId' => 1
        ));
        for ($i = 0; $i < 40; $i++) {
            $user = User::create(array(
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => $faker->text(),
                'salutation' => $faker->title,
                'departmentId' => $faker->numberBetween($min = 1, $max = 15),
                'role_id' => 5,
                'companyId' => 1

            ));
        }
    }
}
