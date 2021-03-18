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
            array('id' => 1, 'store_id' => 1, 'name' => 'Minuman', 'color' => '#ffdada','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 2, 'store_id' => 1, 'name' => 'Bahan Makanan Pokok', 'color' => '#ff0005','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 3, 'store_id' => 1, 'name' => 'Keperluan Peralatan Dapur', 'color' => '#a27172','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 4, 'store_id' => 1, 'name' => 'Keperluan Peralatan Rumah Tangga', 'color' => '#b5da62','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 5, 'store_id' => 1, 'name' => 'Pembersih Rumah', 'color' => '#4b8bfc','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 6, 'store_id' => 1, 'name' => 'Keperluan Bayi', 'color' => '#851313','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 7, 'store_id' => 1, 'name' => 'Perlengkapan Toilet', 'color' => '#310a67','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 8, 'store_id' => 1, 'name' => 'Kosmetik', 'color' => '#37b5a5','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 9, 'store_id' => 1, 'name' => 'Obat-Obatan', 'color' => '#706435','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 10, 'store_id' => 1, 'name' => 'Keperluan Memasak', 'color' => '#a31894','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 11, 'store_id' => 1, 'name' => 'Daging & Ikan', 'color' => '#edda05','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 12, 'store_id' => 1, 'name' => 'Alat Tulis & Kantor', 'color' => '#719105','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 13, 'store_id' => 1, 'name' => 'Bahan & Peralatan Cuci', 'color' => '#a7a1d9','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 14, 'store_id' => 1, 'name' => 'Roti Kering & Basah', 'color' => '#b5dd22','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 15, 'store_id' => 1, 'name' => 'Snack', 'color' => '#7a281c','created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03')
        );
        
        DB::table('categories')->insert($categories);
    }
}
