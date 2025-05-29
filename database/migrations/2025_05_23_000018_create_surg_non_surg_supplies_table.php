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
        Schema::create('surg_non_surg_supplies', function (Blueprint $table) {
            $table->id('itemID');
            $table->string('supplyName');
            $table->text('description')->nullable();
            $table->integer('quantityStock');
            $table->integer('reorderLevel');
            $table->decimal('costPerUnit', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surg_non_surg_supplies');
    }
};
