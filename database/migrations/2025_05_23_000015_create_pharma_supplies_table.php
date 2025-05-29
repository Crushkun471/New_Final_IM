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
        Schema::create('pharma_supplies', function (Blueprint $table) {
            $table->id('drugID');
            $table->string('drugName');
            $table->text('description')->nullable();
            $table->string('dosage');
            $table->string('administrationMethod');
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
        Schema::dropIfExists('pharma_supplies');
    }
};
