<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NextOfKin extends Model
{
    protected $primaryKey = 'nextOfKinID';
    protected $fillable = ['patientID', 'name', 'relationship', 'address', 'phone'];

    public function patient() {
        return $this->belongsTo(Patient::class, 'patientID');
    }
}

