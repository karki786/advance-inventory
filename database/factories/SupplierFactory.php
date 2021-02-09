<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 4/13/2017
 * Time: 21:26
 */
$factory->define(App\Supplier::class, function (Faker\Generator $faker) {
    return [
        'supplierName' => $faker->company,
        'address' => $faker->streetAddress,
        'location' => $faker->buildingNumber,
        'website' => $faker->domainName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'companyId' => 1

    ];
});