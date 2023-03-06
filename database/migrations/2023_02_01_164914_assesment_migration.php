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
        Schema::create('assessments', function (Blueprint $table) {
            $table->increments('asId');
            $table->integer('outlineId');
            $table->string('assessmentType');
            $table->string('assFileName');
            $table->string('senttoHod');
            $table->integer('ass_added_by');
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

        Schema::dropIfExists('assessments');
    }
};
