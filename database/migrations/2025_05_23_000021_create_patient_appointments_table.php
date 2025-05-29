<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patient_appointments', function (Blueprint $table) {
            $table->id('appointmentID');
            $table->unsignedBigInteger('patientID');
            $table->unsignedBigInteger('staffID');
            $table->date('appointmentDate');
            $table->time('appointmentTime');
            $table->string('examinationRoom');
            $table->text('appointmentOutcome')->nullable();
            $table->timestamps();

            $table->foreign('patientID')->references('patientID')->on('patients')->cascadeOnDelete();
            $table->foreign('staffID')->references('staffID')->on('staff')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_appointments');
    }
};
