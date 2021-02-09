<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 4/13/2017
 * Time: 21:26
 */

$factory->define(App\Product::class, function (Faker\Generator $faker) {
    return [
        'productName' => 'Maize',
        'productSerial' => $faker->regexify('[A-Z0-9._%+-]+[A-Z0-9.-]+[A-Z]{2,4}'),
        'amount' => $faker->numberBetween($min = 0, $max = 20),
        'location' => "Store",
        'unitCost' => $faker->numberBetween($min = 100, $max = 2000),
        'reorderAmount' => $faker->numberBetween($min = 1, $max = 15),
        'expiryDate' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'companyId' => 1,
        'productSpecification' => $faker->paragraph(1),
        'productWeight' => $faker->numberBetween($min = 4, $max = 100),
        'productTaxRate' => 16,
        'productManufacturer' => $faker->company,

    ];
});