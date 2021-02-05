<?php

use Illuminate\Database\Seeder;

class A005_ReceiptsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $receipts = array(
            array('id' => 1, 'stores_id' => 1, 'receipts_time' => '2021-02-06 15:09:02', 'customer_name' => 'ADSean', 'customer_phone' => '+6281548697898', 'payment_method' => 'cash', 'created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 2, 'stores_id' => 1, 'receipts_time' => '2021-02-06 15:09:02', 'customer_name' => 'Existt', 'customer_phone' => '+6281458697898', 'payment_method' => 'ovo', 'created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03')
        );
        
        DB::table('receipts')->insert($receipts);
    }
}
