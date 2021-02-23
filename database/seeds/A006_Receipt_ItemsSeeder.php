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
            array('id' => 1, 'receipt_id' => 1, 'product_history_id' => 1, 'unit_total' => 1, 'created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 2, 'receipt_id' => 1, 'product_history_id' => 2, 'unit_total' => 2, 'created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 3, 'receipt_id' => 2, 'product_history_id' => 1, 'unit_total' => 2, 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04'),
            array('id' => 4, 'receipt_id' => 2, 'product_history_id' => 2, 'unit_total' => 1, 'created_at' => '2021-02-05 15:09:03','updated_at' => '2021-02-05 15:09:04')
        );

        DB::table('receipt_items')->insert($receipt_items);
    }
}
