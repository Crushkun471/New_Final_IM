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
        Schema::create('staff_experiences', function (Blueprint $table) {
            $table->id('experienceID');
            $table->unsignedBigInteger('staffID');
            $table->string('organization');
            $table->string('position');
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->timestamps();

            $table->foreign('staffID')->references('staffID')->on('staff')->cascadeOnDelete();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_experiences');
    }
};
