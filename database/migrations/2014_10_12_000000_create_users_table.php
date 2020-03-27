<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('avatar')->nullable()->default('https://iziplans.s3.eu-west-3.amazonaws.com/images/default-avatar.png');
            $table->string('filename')->nullable();
            $table->string('password');
            $table->string('provider')->nullable();
            $table->string('role');
            $table->boolean('alert_categories')->default(1)->nullable();
            $table->boolean('alert_departements')->default(1)->nullable();
            $table->boolean('cgv');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
