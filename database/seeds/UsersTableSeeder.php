<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('users')->insert([
            'firstname' => 'Mickael',
            'lastname'  => 'Delpech',
            'email' => 'mickael.delpech@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => '2020-01-17 10:21:11',
            'role' =>'admin',
            'cgv' => 1,
        ]);
    }
}
