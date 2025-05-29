<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outpatient extends Model
{
    protected $primaryKey = 'outpatientID';
    protected $fillable = ['patientID', 'appointmentDate', 'appointmentTime'];

    public function patient() {
        return $this->belongsTo(Patient::class, 'patientID');
    }
}
