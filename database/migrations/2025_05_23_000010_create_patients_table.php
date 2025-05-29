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
        Schema::create('patients', function (Blueprint $table) {
            $table->id('patientID');
            $table->string('fname');
            $table->string('lname');
            $table->enum('patienttype', ['inpatient', 'outpatient']);
            $table->string('address');
            $table->string('phone')->nullable();
            $table->date('dateofbirth');
            $table->enum('sex', ['M', 'F']);
            $table->string('maritalstatus');
            $table->date('dateregistered');
            
            $table->unsignedBigInteger('clinicID')->nullable(); // Local doctor ID

            $table->timestamps();

            $table->foreign('clinicID')->references('clinicID')->on('local_doctors')->nullOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
