<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class A004_ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = array(
            array('id' => 1, 'category_id' => 1, 'name' => 'Es Teh', 'created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 2, 'category_id' => 2, 'name' => 'Lemper', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04')
        );

        foreach($products as $product)
            Product::create($product);
    }
}
