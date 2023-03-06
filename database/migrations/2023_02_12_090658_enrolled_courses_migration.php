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
        Schema::create('enrolledstudents', function (Blueprint $table) {
            $table->increments('eId');
            $table->integer('userId');
            $table->string('courseId');
            $table->string('session');
            $table->timestamp('startDate')->nullable();
            $table->timestamp('completionDate')->nullable();

            $table->integer('enrolled_by');
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
        Schema::dropIfExists('assessments');
        //
    }
};
