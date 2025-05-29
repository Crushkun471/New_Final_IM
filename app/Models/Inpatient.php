<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inpatient extends Model
{
    protected $primaryKey = 'inpatientID';
    protected $fillable = [
        'patientID', 'wardID', 'bedID', 'datePlacedOnWaitlist', 'wardRequired',
        'expectedDaysToStay', 'dateAdmittedInWard', 'expectedLeave', 'actualLeave'
    ];


    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientID'); // adjust FK if different
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'wardID');
    }

    public function bed() {
        return $this->belongsTo(Bed::class, 'bedID');
    }


    public function scopeWaitingList($query)
    {
        return $query->whereNotNull('datePlacedOnWaitlist')->whereNull('dateAdmittedInWard');
    }

    public function scopeAdmitted($query)
    {
        return $query->whereNotNull('dateAdmittedInWard')->whereNull('actualLeave');
    }

    public function scopeDischarged($query)
    {
        return $query->whereNotNull('actualLeave');
    }


}
