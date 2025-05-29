<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ViewOutpatient extends Model
{
    protected $table = 'view_outpatients';
    public $timestamps = false;
    protected $primaryKey = 'patientID';
}
