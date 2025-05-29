<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffQualification extends Model
{
    protected $primaryKey = 'qualificationID';
    protected $fillable = ['staffID', 'qualificationType', 'institution', 'dateOfQualification'];

    public function staff() {
        return $this->belongsTo(Staff::class, 'staffID');
    }
}
