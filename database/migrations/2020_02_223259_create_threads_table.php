<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThreadsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('threads', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('title');
      $table->unsignedBigInteger('from_id')->index();
      $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
      $table->unsignedBigInteger('to_id')->index();
      $table->foreign('to_id')->references('id')->on('users')->onDelete('cascade');
      $table->unsignedBigInteger('projet_id')->index();
      $table->foreign('projet_id')->references('id')->on('projets')->onDelete('cascade');
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
    Schema::dropIfExists('topics');
    DB::statement('SET FOREIGN_KEY_CHECKS = 1');
  }
}
