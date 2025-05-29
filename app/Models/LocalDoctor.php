<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalDoctor extends Model
{
    protected $primaryKey = 'clinicID';
    protected $fillable = ['name', 'address', 'phone'];

    public function patients() {
        return $this->hasMany(Patient::class, 'clinicID');
    }
}
