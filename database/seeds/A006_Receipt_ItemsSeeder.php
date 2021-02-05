<?php

use Illuminate\Database\Seeder;

class A006_Receipt_ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $receipt_items = array(
            array('id' => 1, 'receipts_id' => 1, 'products_id' => 1, 'unit_total' => 1, 'unit_price' => 2000.21, 'created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 2, 'receipts_id' => 1, 'products_id' => 2, 'unit_total' => 2, 'unit_price' => 1500.21, 'created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 3, 'receipts_id' => 2, 'products_id' => 1, 'unit_total' => 2, 'unit_price' => 2000.21, 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 4, 'receipts_id' => 2, 'products_id' => 2, 'unit_total' => 1, 'unit_price' => 1500.21, 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04')
        );
        
        DB::table('receipt_items')->insert($receipt_items);
    }
}
