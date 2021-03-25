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
            array('id' => 1, 'category_id' => 1, 'name' => 'Es Teh', 'total' => 5, 'selling_price' => 1000, 'cost_price' => 750, 'created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 2, 'category_id' => 14, 'name' => 'Lemper', 'total' => 3, 'selling_price' => 1500, 'cost_price' => 500, 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 3, 'category_id' => 2, 'name' => 'Beras', 'total' => 7, 'selling_price' => 10000, 'cost_price' => 9000, 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 4, 'category_id' => 3, 'name' => 'Wajan', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 5, 'category_id' => 4, 'name' => 'Jam Dinding', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 6, 'category_id' => 5, 'name' => 'Sapu Lidi', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 7, 'category_id' => 6, 'name' => 'Minyak Telon', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 8, 'category_id' => 7, 'name' => 'Sikat WC', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 9, 'category_id' => 8, 'name' => 'Minyak Rambut', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 10, 'category_id' => 9, 'name' => 'Obat Flu', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 11, 'category_id' => 10, 'name' => 'Minyak Goreng', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 12, 'category_id' => 11, 'name' => 'Daging Ayam', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 13, 'category_id' => 12, 'name' => 'Penggaris', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 14, 'category_id' => 13, 'name' => 'Detergen', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 15, 'category_id' => 15, 'name' => 'Snack A', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 16, 'category_id' => 15, 'name' => 'Snack B', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04')
        );

        foreach($products as $product)
            Product::create($product);
    }
}
