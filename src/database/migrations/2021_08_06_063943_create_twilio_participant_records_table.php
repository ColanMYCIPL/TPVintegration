<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwilioParticipantRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twilio_participant_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('student_id')->nullable();
            $table->string('class_id')->nullable();
            $table->string('room_name')->nullable();
            $table->string('room_sid')->nullable();
            $table->string('participant_sid')->nullable();
            $table->string('participant_identity')->nullable();
            $table->string('comp_sid')->nullable();
            $table->string('comp_status')->nullable();
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
        Schema::dropIfExists('twilio_participant_records');
    }
}
