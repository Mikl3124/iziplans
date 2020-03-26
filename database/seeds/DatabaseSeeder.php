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
        // $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(DepartementsTableSeeder::class);
        $this->call(BudgetsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
