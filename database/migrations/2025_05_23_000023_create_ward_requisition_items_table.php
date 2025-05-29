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
        Schema::create('ward_requisition_items', function (Blueprint $table) {
            $table->id('requisitionItemID');
            $table->unsignedBigInteger('requisitionID');
            $table->unsignedBigInteger('itemID')->nullable();
            $table->unsignedBigInteger('drugID')->nullable();
            $table->integer('quantityRequired');
            $table->decimal('costPerUnit', 10, 2);
            $table->timestamps();

            $table->foreign('requisitionID')->references('requisitionID')->on('ward_requisitions')->cascadeOnDelete();
            $table->foreign('itemID')->references('itemID')->on('surg_non_surg_supplies')->nullOnDelete();
            $table->foreign('drugID')->references('drugID')->on('pharma_supplies')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ward_requisition_items');
    }
};
