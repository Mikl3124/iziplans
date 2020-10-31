<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles_comments', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('title', 128);
            $table->unsignedBigInteger('user_id')->index()->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('article_id')->index()->references('id')->on('article')->onDelete('cascade');
            $table->text('text');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles_comments');
    }
}
