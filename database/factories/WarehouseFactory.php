<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 4/13/2017
 * Time: 21:28
 */
$factory->define(App\Warehouse::class, function (Faker\Generator $faker) {
    return [
        'whsName' => $faker->cityPrefix,
        'whsStreet' => $faker->streetName,
        'whsZipCode' => $faker->postcode,
        'whsCity' => $faker->city,
        'whsCountry' => $faker->country,
        'whsState' => $faker->state,
        'whsBuilding' => $faker->buildingNumber,
        'isActive' => $faker->boolean($chanceOfGettingTrue = 80)
    ];
});


$factory->define(App\StorageLocation::class, function (Faker\Generator $faker) {
    return [
        'binCode' => $faker->numerify('BN-###'),
        'binDescription' => $faker->sentence($nbWords = 6, $variableNbWords = true),
        'binDisabled' => $faker->boolean($chanceOfGettingTrue = 20),
        'binBarcode' => $faker->ean13,
        'binMaxLevel' => $faker->randomDigit,
        'binMaxWeight' => $faker->randomNumber($nbDigits = 3),
    ];
});