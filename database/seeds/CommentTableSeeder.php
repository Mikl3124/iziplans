<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('articles_comments')->insert([
          [
            'id' => 1,
                    'title' => 'Commentaire 1',
                    'user_id' => '2',
                    'article_id' => '1',
                    'text' => 'blablabla',
                    'created_at' => '2013-02-01 00:00:00',
                    'updated_at' => '2013-02-01 00:00:00'
          ],
          [
                                'id' => 2,
                    'title' => 'Commentaire 2',
                    'user_id' => '2',
                    'article_id' => '1',
                    'text' => 'blablabla',
                    'created_at' => '2013-02-01 00:00:00',
                    'updated_at' => '2013-02-01 00:00:00'
          ],
          [
                                'id' => 3,
                    'title' => 'Commentaire 3',
                    'user_id' => '3',
                    'article_id' => '3',
                    'text' => 'blablabla',
                    'created_at' => '2013-02-01 00:00:00',
                    'updated_at' => '2013-02-01 00:00:00'
          ],
          [
             'id' => 4,
                    'title' => 'Commentaire 4',
                    'user_id' => '2',
                    'article_id' => '4',
                    'text' => 'blablabla',
                    'created_at' => '2013-02-01 00:00:00',
                    'updated_at' => '2013-02-01 00:00:00'
          ],
          [
             'id' => 5,
                    'title' => 'Commentaire 5',
                    'user_id' => '3',
                    'article_id' => '4',
                    'text' => 'blablabla',
                    'created_at' => '2013-02-01 00:00:00',
                    'updated_at' => '2013-02-01 00:00:00'
          ],
          [
             'id' => 6,
                    'title' => 'Commentaire 6',
                    'user_id' => '3',
                    'article_id' => '5',
                    'text' => 'blablabla',
                    'created_at' => '2013-02-01 00:00:00',
                    'updated_at' => '2013-02-01 00:00:00'
          ],
          [
            'id' => 7,
                    'title' => 'Commentaire 7',
                    'user_id' => '2',
                    'article_id' => '1',
                    'text' => 'blablabla',
                    'created_at' => '2013-02-01 00:00:00',
                    'updated_at' => '2013-02-01 00:00:00'
          ]
        ]);
    }
}
