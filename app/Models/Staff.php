<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;
    protected $primaryKey = 'staffID';
    protected $fillable = [
        'name', 'address', 'telephone', 'dateOfBirth', 'sex', 'nationalInsuranceNumber',
        'position', 'currentSalary', 'salaryScale', 'contractType', 'hoursPerWeek', 'paymentType', 'wardID'
    ];

    public function ward() {
        return $this->belongsTo(Ward::class, 'wardID', 'wardID');
    }

    public function qualifications() {
        return $this->hasMany(StaffQualification::class, 'staffID');
    }

    public function experiences() {
        return $this->hasMany(StaffExperience::class, 'staffID');
    }

    public function appointments() {
        return $this->hasMany(PatientAppointment::class, 'staffID');
    }

    public function chargeNurseRole() {
        return $this->hasOne(ChargeNurse::class, 'staffID');
    }
}
