<?php

use Illuminate\Database\Seeder;

class A002_StoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stores = array(
            array('id' => 1, 'user_id' => 1, 'name' => 'Toko A','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03')
        );
        
        DB::table('stores')->insert($stores);
    }
}
