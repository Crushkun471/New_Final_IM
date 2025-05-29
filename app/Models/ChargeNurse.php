<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChargeNurse extends Model
{
    protected $table = 'charge_nurses';
    protected $primaryKey = 'staffID';
    public $incrementing = false;

    protected $fillable = ['staffID', 'wardID', 'budgetAllocated'];

    public function staff() {
        return $this->belongsTo(Staff::class, 'staffID');
    }

    public function ward() {
        return $this->belongsTo(Ward::class, 'wardID');
    }
}
