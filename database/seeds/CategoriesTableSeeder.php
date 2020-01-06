<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $categories = [ 
            "Aéronautique",
            "Architecture",
            "Batiment",
            "Cartographie",
            "Construction durable",
            "Transport",
            "Voirie",
            "Permis de construire"
        ];
        
        foreach($categories as $categorie){
            DB::table('categories')->insert([
                    'name' => $categorie
            ]);
        }
    }
}