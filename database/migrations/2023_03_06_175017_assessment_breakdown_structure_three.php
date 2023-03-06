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
        Schema::create('assessment_breakdown_structure', function (Blueprint $table) {
            $table->increments('asBreaId');
            $table->integer('ploId');
            $table->string('objective');
            $table->string('assessmenttype');
            $table->string('btLevel');
            $table->string('Qno');
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
        Schema::dropIfExists('assessment_breakdown_structure');

    }
};
