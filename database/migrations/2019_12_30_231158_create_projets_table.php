<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->unsignedBigInteger('user_id')->index()->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->unsignedBigInteger('budget_id')->index()->references('id')->on('budgets')->onDelete('cascade');
            $table->string('status');
            $table->string('file_projet')->nullable();
            $table->unsignedBigInteger('departement_id')->index()->references('id')->on('departements')->onDelete('cascade');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('projets');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}

