<?php

use Illuminate\Database\Seeder;

class A001_UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // insert data ke table users

        $users = array(
            array('id' => 1,'username' => 'User A','email' => 'user1@simplepos.me','password' => Hash::make('password1'),'created_at' => '2021-02-05 15:09:02','updated_at' => '2021-02-05 15:09:03'),
            array('id' => 2,'username' => 'User B','email' => 'user2@simplepos.me','password' => Hash::make('password2'),'created_at' => '2021-02-05 15:09:04','updated_at' => '2021-02-05 15:09:04')
        );
        
        DB::table('users')->insert($users);
    }
}
