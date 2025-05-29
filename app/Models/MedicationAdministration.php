<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicationAdministration extends Model
{
    protected $fillable = ['medicationID', 'administrationTime', 'administeredBy', 'notes'];

    public function medication()
    {
        return $this->belongsTo(Medication::class, 'medicationID');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'administeredBy');
    }
}
