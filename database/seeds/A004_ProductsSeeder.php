<?php

use Illuminate\Database\Seeder;

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
            array('id' => 1, 'categorie_id' => 1, 'name' => 'Es Teh', 'created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 2, 'categorie_id' => 2, 'name' => 'Lemper', 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04')
        );
        
        DB::table('products')->insert($products);
    }
}
