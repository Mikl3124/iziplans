<?php

use Illuminate\Database\Seeder;

class CompetencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $competences = [ "Actualiser des plans",
                        "Appel d'offres",
                        "Architecture",
                        "BIM",
                        "BTP",
                    ];
        
        foreach($competences as $competence){
            DB::table('competences')->insert([
                    'name' => $competence
            ]);
        }
    }
}
