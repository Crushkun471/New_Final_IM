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
        Schema::create('outpatients', function (Blueprint $table) {
            $table->id('outpatientID'); // Surrogate Primary Key
            $table->unsignedBigInteger('patientID'); // FK to patients
            $table->date('appointmentDate');
            $table->time('appointmentTime');
            $table->timestamps();

            $table->foreign('patientID')->references('patientID')->on('patients')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outpatients');
    }
};
