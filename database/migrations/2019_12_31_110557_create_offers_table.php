<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('projet_id');    
            $table->unsignedInteger('user_id');
/*             $table->foreign('projet_id')->references('id')->on('projets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); */
            $table->integer('offre');
            $table->text('commentaire');
            $table->integer('duree');
            $table->string('unite_duree');
            $table->timestamps();

             $table->index(['user_id', 'projet_id']);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offers');
    }
}
