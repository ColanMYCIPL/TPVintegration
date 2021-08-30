<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwilioConnectedRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twilio_connected_rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('room_name')->nullable();
            $table->string('room_sid')->nullable();
            $table->integer('class_id');
            $table->longText('access_token');
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
        Schema::dropIfExists('twilio_connected_rooms');
    }
}
