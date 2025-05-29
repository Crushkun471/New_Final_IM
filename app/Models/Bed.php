<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Ward;
use App\Models\Patient;

class Bed extends Model
{
    use HasFactory;

    protected $primaryKey = 'bedID';
    protected $fillable = ['wardID', 'bedNumber', 'status', 'patientID'];

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'wardID');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patientID');
    }
}
