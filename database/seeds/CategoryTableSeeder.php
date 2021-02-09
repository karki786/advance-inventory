<?php

use App\ProductCategory;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Auth::loginUsingId(1);
        DB::table('product_categories')->truncate();
        $categories = array('Stationery', 'Consumables', 'Electronics', 'Foods', 'Vegetables', 'Cool Stuff');
        foreach ($categories as $category) {
            $category = ProductCategory::create(array(
                'CategoryName' => $category,
                'CategoryDescription' => 'CoolDescription'
            ));
        }
    }
}
