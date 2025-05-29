<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $primaryKey = 'patientID';
    protected $fillable = [
        'fname', 'lname', 'patienttype', 'address', 'phone', 'dateofbirth',
        'sex', 'maritalstatus', 'dateregistered', 'clinicID'
    ];

    public function doctor() {
        return $this->belongsTo(LocalDoctor::class, 'clinicID');
    }

    // Add alias for backward compatibility
    public function localDoctor() {
        return $this->doctor();
    }

    public function kin() {
        return $this->hasMany(NextOfKin::class, 'patientID');
    }

    public function medications() {
        return $this->hasMany(Medication::class, 'patientID');
    }

    public function inpatient() {
        return $this->hasOne(Inpatient::class, 'patientID');
    }

    public function outpatient() {
        return $this->hasOne(Outpatient::class, 'patientID');
    }

    public function outpatientAppointments() {
        return $this->hasMany(Outpatient::class, 'patientID');
    }

    public function appointments() {
        return $this->hasMany(PatientAppointment::class, 'patientID');
    }

    public function patientAppointments() {
        return $this->hasMany(PatientAppointment::class, 'patientID');
    }

    public function latestAppointment()
    {
        return $this->hasOne(\App\Models\PatientAppointment::class, 'patientID', 'patientID')->latestOfMany('appointmentDate');
    }

    public function getFullNameAttribute()
    {
        return trim($this->fname . ' ' . $this->lname);
    }
}