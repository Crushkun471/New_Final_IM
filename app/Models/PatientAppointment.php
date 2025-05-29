<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientAppointment extends Model
{
    protected $primaryKey = 'appointmentID';
    protected $fillable = ['patientID', 'staffID', 'appointmentDate', 'appointmentTime', 'examinationRoom', 'appointmentOutcome'];

    public function patient() {
        return $this->belongsTo(Patient::class, 'patientID');
    }

    public function staff() {
        return $this->belongsTo(Staff::class, 'staffID');
    }
}
