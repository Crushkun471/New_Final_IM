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
        Schema::create('supplier_supplies', function (Blueprint $table) {
            $table->id('supplyID');
            $table->unsignedBigInteger('supplierID');
            $table->unsignedBigInteger('itemID')->nullable();
            $table->unsignedBigInteger('drugID')->nullable();
            $table->timestamps();

            $table->foreign('supplierID')->references('supplierID')->on('suppliers')->cascadeOnDelete();
            $table->foreign('itemID')->references('itemID')->on('surg_non_surg_supplies')->nullOnDelete();
            $table->foreign('drugID')->references('drugID')->on('pharma_supplies')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_supplies');
    }
};
