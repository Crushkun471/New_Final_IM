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
        Schema::create('charge_nurses', function (Blueprint $table) {
            $table->unsignedBigInteger('staffID')->primary();
            $table->unsignedBigInteger('wardID');
            $table->decimal('budgetAllocated', 10, 2);
            $table->timestamps();

            $table->foreign('staffID')->references('staffID')->on('staff')->cascadeOnDelete();
            $table->foreign('wardID')->references('wardID')->on('wards')->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charge_nurses');
    }
};
