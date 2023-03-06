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
        Schema::create('lecturesOutline', function (Blueprint $table) {
            $table->increments('outlineId');
            $table->integer('lecNo');
            $table->integer('weekNo');
            $table->integer('session');
            $table->string('subject');
            $table->string('fileName');
            $table->string('fileName1');
            $table->string('fileName2');
            $table->string('fileName3');
            $table->string('fileName4');
            $table->string('relatedTopic');
            $table->string('btLevel');
            $table->string('objectivesIds');
            $table->string('approved');

            $table->integer('approved_by');

            $table->integer('outline_added_by');
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
        Schema::dropIfExists('lecturesOutline');
    }
};
