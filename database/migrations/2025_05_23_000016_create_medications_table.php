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
        Schema::create('medications', function (Blueprint $table) {
            $table->id('medicationID');
            $table->unsignedBigInteger('patientID');
            $table->unsignedBigInteger('drugID');
            $table->integer('unitsPerDay');
            $table->string('administrationMethod');
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->timestamps();

            $table->foreign('patientID')->references('patientID')->on('patients')->cascadeOnDelete();
            $table->foreign('drugID')->references('drugID')->on('pharma_supplies')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
