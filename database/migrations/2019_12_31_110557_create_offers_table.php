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
            $table->integer('offer_price');
            $table->text('offer_message');
            $table->integer('offer_days');
            $table->string('filename');
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
