<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 4/13/2017
 * Time: 21:27
 */
$factory->define(App\Customer::class, function (Faker\Generator $faker) {
    return [
        'companyName' => $faker->company,
        'customerType' => $faker->boolean($chanceOfGettingTrue = 50),
        'companyEmail' => $faker->companyEmail,
        'email' => $faker->email,
        'active' => $faker->boolean(),
        'password' => bcrypt('test123')
    ];
});

$factory->define(App\CustomerContact::class, function (Faker\Generator $faker) {
    return [
        'customerName' => $faker->name,
        'telephoneNumber' => $faker->phoneNumber,
        'mobileNumber' => $faker->phoneNumber,
        'address1' => $faker->streetAddress,
        'address2' => $faker->streetAddress,
        'email' => $faker->email,

    ];
});