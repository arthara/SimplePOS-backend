<?php

use Illuminate\Database\Seeder;

class A003_CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array(
            array('id' => 1, 'stores_id' => 1, 'name' => 'Minuman', 'color' => '#ffffff','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 2, 'stores_id' => 1, 'name' => 'Makanan', 'color' => '#ff0000','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03')
        );
        
        DB::table('categories')->insert($categories);
    }
}
