<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);

        $this->call([
            A001_UsersSeeder::class,
            A002_StoresSeeder::class,
            A003_CategoriesSeeder::class,
            A004_ProductsSeeder::class,
            A005_ReceiptsSeeder::class,
            A006_Receipt_ItemsSeeder::class
        ]);
    }
}
