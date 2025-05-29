<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewInpatient extends Model
{
    protected $table = 'view_inpatients'; // Name of the SQL view
    protected $primaryKey = 'inpatientID';
    public $timestamps = false;

    // Optionally cast date fields if you plan to use them as Carbon instances
    protected $casts = [
        'datePlacedOnWaitlist' => 'date',
        'dateAdmittedInWard' => 'date',
        'expectedLeave' => 'date',
        'actualLeave' => 'date',
    ];
}