<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwilioConnectedParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twilio_connected_participants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('room_name')->nullable();
            $table->string('room_sid')->nullable();
            $table->string('participant_sid')->nullable();
            $table->string('participant_identity')->nullable();
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
        Schema::dropIfExists('twilio_connected_participants');
    }
}
