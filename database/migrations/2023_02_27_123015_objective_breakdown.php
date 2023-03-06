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
        Schema::create('objectives_breakdown', function (Blueprint $table) {
            $table->increments('obId');
            $table->string('objId');
            $table->integer('quiz')->nullable();
            $table->integer('assignment')->nullable();
            $table->integer('presentation')->nullable();
            $table->integer('project')->nullable();
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
        Schema::dropIfExists('objectives_breakdown');

    }
};
