<?php

use Illuminate\Database\Seeder;

class PurchaseOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        factory(App\PurchaseOrder::class, 20)->create()->each(function ($u) {
            $u->orders()->saveMany(factory(App\PurchaseOrderItem::class, 10)->make());
        });
        for ($i = 1; $i < 20; $i++) {
            $lpo = \App\PurchaseOrder::with('orders')->find($i);
            foreach ($lpo->orders as $order) {
                $totalLinePrice = $order->amount * $order->unitCost;
                $tax = 0;
                if ($order->taxable == "T") {
                    $tax = ($lpo->vatTaxAmount / 100) * $totalLinePrice;
                }
                $multiple = \App\Product::find($order->productId)->usesMultipleStorage;
                \App\PurchaseOrderItem::find($order->id)->update(
                    array(
                        'total' => $totalLinePrice,
                        'tax' => $tax,
                        'usesMultipleStorage' => $multiple
                    )
                );
            }
        }
    }
}
