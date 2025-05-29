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
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staffID');
            $table->string('name');
            $table->string('address');
            $table->string('telephone');
            $table->date('dateOfBirth');
            $table->enum('sex', ['M', 'F']);
            $table->string('nationalInsuranceNumber')->unique();
            $table->string('position');
            $table->decimal('currentSalary', 10, 2);
            $table->string('salaryScale');
            $table->string('contractType');
            $table->integer('hoursPerWeek');
            $table->string('paymentType');
            $table->unsignedBigInteger('wardID')->nullable();
            $table->timestamps();

            $table->foreign('wardID')->references('wardID')->on('wards')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
