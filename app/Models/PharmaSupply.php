<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PharmaSupply extends Model
{
    protected $primaryKey = 'drugID';
    protected $fillable = ['drugName', 'description', 'dosage', 'administrationMethod', 'quantityStock', 'reorderLevel', 'costPerUnit'];

    public function medications() {
        return $this->hasMany(Medication::class, 'drugID');
    }
}
