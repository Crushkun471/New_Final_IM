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
        Schema::create('inpatients', function (Blueprint $table) {
            $table->id('inpatientID');
            $table->unsignedBigInteger('patientID');
            $table->unsignedBigInteger('wardID')->nullable();
            $table->unsignedBigInteger('bedID')->nullable();
            $table->date('datePlacedOnWaitlist');
            $table->string('wardRequired')->nullable();
            $table->integer('expectedDaysToStay')->nullable();
            $table->date('dateAdmittedInWard')->nullable();
            $table->date('expectedLeave')->nullable();
            $table->date('actualLeave')->nullable();
            $table->timestamps();

            $table->foreign('patientID')->references('patientID')->on('patients')->cascadeOnDelete();
            $table->foreign('wardID')->references('wardID')->on('wards')->cascadeOnDelete();
            $table->foreign('bedID')->references('bedID')->on('beds')->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inpatients');
    }
};
