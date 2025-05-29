<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medication_administrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medicationID');
            $table->timestamp('administrationTime');
            $table->unsignedBigInteger('administeredBy')->nullable(); // Optional: track staff
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('medicationID')->references('medicationID')->on('medications')->cascadeOnDelete();
            $table->foreign('administeredBy')->references('staffID')->on('staff')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medication_administrations');
    }
};
