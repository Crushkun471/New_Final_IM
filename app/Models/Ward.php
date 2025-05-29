<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    use HasFactory;
    protected $primaryKey = 'wardID';
    protected $fillable = ['wardName', 'location', 'totalBeds', 'telExtension', 'staffID'];

    public function staff()
    {
        // This defines the hasMany relationship to staff
        // 'wardID' in staff table points to 'wardID' in wards table
        return $this->hasMany(Staff::class, 'wardID', 'wardID');
    }

    public function beds() {
        return $this->hasMany(Bed::class, 'wardID');
    }

    public function chargeNurse() {
        // This defines the belongsTo relationship for a single charge nurse
        // 'staffID' in wards table points to 'staffID' in staff table
        return $this->belongsTo(Staff::class, 'staffID', 'staffID');
    }
}