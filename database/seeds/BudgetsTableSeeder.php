<?php

use Illuminate\Database\Seeder;

class BudgetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $budgets = ["1" => "Moins de 500€",
                 "2" => "500€ à 1000€",
                 "3" => "1000€ à 2000€",
                 "4" => "2000€ à 3000€",
                 "5" => "Plus de 3000€",
            ];

        foreach($budgets as $budget){
        DB::table('budgets')->insert([
                'name' => $budget
        ]);
        }
    }
}
