<?php

use Illuminate\Database\Seeder;

class ArticlesCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('blogcategories')->insert([
          [
            'id' => 1,
                    'title' => 'Catégorie 1',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
          ],
          [
            'id' => 2,
                    'title' => 'Catégorie 2',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
          ],
          [
             'id' => 3,
                    'title' => 'Catégorie 3',
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime
            ]
         ]

         );

    }
}
