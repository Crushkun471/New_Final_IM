<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffExperience extends Model
{
    protected $primaryKey = 'experienceID';
    protected $fillable = ['staffID', 'organization', 'position', 'startDate', 'endDate'];

    public function staff() {
        return $this->belongsTo(Staff::class, 'staffID');
    }
}

