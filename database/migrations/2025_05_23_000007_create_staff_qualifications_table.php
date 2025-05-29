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
        Schema::create('staff_qualifications', function (Blueprint $table) {
            $table->id('qualificationID');
            $table->unsignedBigInteger('staffID');
            $table->string('qualificationType');
            $table->string('institution'); // ✅ Added institution
            $table->date('dateOfQualification');
            $table->timestamps();

            $table->foreign('staffID')->references('staffID')->on('staff')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_qualifications');
    }
};
