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
        Schema::create('wards', function (Blueprint $table) {
            $table->id('wardID');
            $table->string('wardName');
            $table->string('location');
            $table->integer('totalBeds');
            $table->string('telExtension')->nullable(); // From ERD: "telExtn/ension"
            $table->unsignedBigInteger('staffID')->nullable(); // Charge nurse managing it
            $table->timestamps();

            //$table->foreign('staffID')->references('staffID')->on('staff')->nullOnDelete(); // Circular, may need to adjust later
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wards');
    }
};
