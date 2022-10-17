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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hoster_id');
            $table->string('event_title');
            $table->string('location');
            $table->string('date');
            $table->string('time');
            $table->string('description');
            $table->integer('ticket_count');
            $table->string('recommended_donation_box');
            $table->integer('ticket_price');
            $table->string('image');
            $table->json('user_id');
            $table->boolean('qr_codes')->default(0);
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
        Schema::dropIfExists('events');
    }
};
