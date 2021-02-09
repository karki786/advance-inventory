<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 4/13/2017
 * Time: 21:26
 */

$factory->define(App\SalesOrder::class, function (Faker\Generator $faker) {
    $customer = App\Customer::with('contacts')->whereId($faker->numberBetween($min = 1, $max = 10))->get()[0];
    $currency = App\Country::find($faker->numberBetween($min = 1, $max = 20));
    return [
        'orderNo' => $faker->numerify('QT-###'),
        'customerId' => $customer->id,
        'contactId' => $customer->contacts->first()->id,
        'customerText' => $customer->companyName,
        'salesPersonId' => 1,
        'salesPersonText' => "Dennis Wanyoike",
        'currencyTypeId' => $currency->id,
        'currencyTypeText' => $currency->currency,
        'paymentMethod'=>'Cash',
        'paymentTerms'=>'30 Days After Delivery',
        'companyId' => 1,
        'onHold' => $faker->boolean(30)

    ];
});

$factory->define(App\SalesOrderItem::class, function (Faker\Generator $faker) {
    $product = App\Product::has('locations', '>', 1)->with('locations')->inRandomOrder()->firstOrFail();
    $binLocation = '';
    if (count($product->locations) > 0) {
        $binLocation = $product->locations->first()->binLocation;
    }
    return [
        'productId' => $product->id,
        'binLocation' => $binLocation,
        'productDescription' => $product->productName,
        'quantity' => 1,
        'sellingPrice' => $product->sellingPrice,
        'convertedPrice' => $product->sellingPrice,
        'convertedRate' => 0,
        'tax' => ($product->taxRate / 100) * $product->sellingPrice,
        'taxRate' => $product->productTaxRate,
        'total' => $product->sellingPrice,
        'discount' => 0,
        'taxable' => 1,
        'companyId' => 1,
        'locationHash' => $product->locations->random()->hash

    ];
});