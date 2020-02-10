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
            $table->unsignedBigInteger('projet_id')->index()->references('id')->on('projets')->onDelete('cascade');
            $table->unsignedInteger('user_id')->index()->references('id')->on('users')->onDelete('cascade');
            $table->integer('offer_price');
            $table->text('offer_message');
            $table->integer('offer_days');
            $table->string('filename')->nullable();;
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
        Schema::dropIfExists('offers');
    }
}
