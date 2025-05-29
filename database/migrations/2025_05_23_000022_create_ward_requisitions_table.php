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
        Schema::create('ward_requisitions', function (Blueprint $table) {
            $table->id('requisitionID');
            $table->unsignedBigInteger('wardID');
            $table->unsignedBigInteger('staffIDPlacingReq');
            $table->unsignedBigInteger('receivedBy')->nullable();
            $table->date('dateOrdered');
            $table->date('dateReceived')->nullable();
            $table->timestamps();

            $table->foreign('wardID')->references('wardID')->on('wards')->cascadeOnDelete();
            $table->foreign('staffIDPlacingReq')->references('staffID')->on('staff')->cascadeOnDelete();
            $table->foreign('receivedBy')->references('staffID')->on('charge_nurses')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ward_requisitions');
    }
};
