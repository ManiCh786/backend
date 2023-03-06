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

        // Schema::create('course_outcomes', function (Blueprint $table) {
        //     $table->increments('outcomeId');
        //     $table->string('outcomeTitle');
        //     $table->text('outcomeDesc');
        //     $table->integer('objId');
        //     $table->integer('outcome_added_by');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        // Schema::dropIfExists('course_outcomes');
    }
};
