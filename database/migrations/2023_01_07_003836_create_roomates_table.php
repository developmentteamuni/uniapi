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
        Schema::create('roomates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->string('location');
            $table->string('description');
            $table->string('clean');
            $table->string('sleep_schdeule');
            $table->string('noise_level');
            $table->string('lots_of_time_in_room');
            $table->string('company');
            $table->string('social');
            $table->string('study_location');
            $table->string('requirements');
            $table->string('campus');
            $table->string('time_to_campus');
            $table->string('sublease');



            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('roomates');
    }
};
