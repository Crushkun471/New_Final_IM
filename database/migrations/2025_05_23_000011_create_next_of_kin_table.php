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
        Schema::create('next_of_kin', function (Blueprint $table) {
            $table->id('nextOfKinID');
            $table->unsignedBigInteger('patientID');
            $table->string('name');
            $table->string('relationship');
            $table->string('address');
            $table->string('phone');
            $table->timestamps();

            $table->foreign('patientID')->references('patientID')->on('patients')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('next_of_kin');
    }
};
