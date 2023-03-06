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
        //
        Schema::create('course_instructors', function (Blueprint $table) {
            $table->increments('ciId');
            $table->integer('courseId');
            $table->integer('instructor_userId');
            $table->integer('assigned_by');
            $table->integer('semester');
            $table->string('department');
            $table->string('session');
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
        //
        Schema::dropIfExists('course_instructors');
    }
};
