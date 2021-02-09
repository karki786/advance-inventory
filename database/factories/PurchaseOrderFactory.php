<?php
/**
 * Created by PhpStorm.
 * User: dwany
 * Date: 4/13/2017
 * Time: 21:27
 */
$factory->define(App\PurchaseOrder::class, function (Faker\Generator $faker) {
    $supplier = \App\Supplier::find($faker->numberBetween($min = 1, $max = 40));
    $status = array_rand(array("2" => "Awaiting Approval", "1" => "Approved", "2" => "Rejected"), 1);
    $currency = array_rand(array("USD" => "USD", "KES" => "KES", "EURO" => "EURO"), 1);
    return [
        'supplierId' => $supplier->id,
        'supplierName' => $supplier->supplierName,
        'deliverBy' => $faker->dateTimeThisYear($max = '+ 20 days', $min = '- 2 days'),
        'departmentId' => $faker->numberBetween($min = 1, $max = 10),
        'lpoStatus' => $status,
        'lpoDate' => $faker->dateTimeThisYear($max = '- 10 days'),
        'lpoApprovedOn' => $faker->dateTimeThisYear($max = '- 2 days', $min = '- 5 days'),
        'lpoCurrencyType' => $currency,
        'lpoNumber' => $faker->numerify('LPO-###'),
        'vatTaxAmount' => $faker->numberBetween($min = 16, $max = 20)
    ];
});

$factory->define(App\PurchaseOrderItem::class, function (Faker\Generator $faker) use ($factory) {
    $product = \App\Product::find($faker->numberBetween($min = 1, $max = 50));
    $taxable = array_rand(array("T" => "T", '' => "null"), 1);
    $quantity = $faker->numberBetween($min = 1, $max = 5);
    $price = $faker->numberBetween($min = 1, $max = 100);
    return [
        'productId' => $product->id,
        'productDescription' => $product->productName,
        'amount' => $quantity,
        'unitCost' => $price,
        'taxable' => $taxable,
        'total' => $price * $quantity,
        'tax' => 0,
    ];
});