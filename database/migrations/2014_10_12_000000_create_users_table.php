<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('userId');
            $table->integer('regId');
            $table->string('fName');
            $table->string('lName');
            $table->string('email');
            $table->string('phone');
            $table->string('password');
            $table->integer('roleId');
            $table->string('added_by');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->dateTime('registered_at');
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
};