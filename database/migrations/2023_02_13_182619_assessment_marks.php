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
        Schema::create('assessment_marks', function (Blueprint $table) {
            $table->increments('as_marks_id');
            $table->integer('assessment_id');
            $table->integer('qno');
            $table->integer('obtmarks');


            $table->integer('total_marks');
            $table->integer('student_id');
            $table->string('objName');


            $table->integer('added_by');
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
        Schema::dropIfExists('assessment_marks');

    }
};
