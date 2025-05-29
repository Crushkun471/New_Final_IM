<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierSupply extends Model
{
    protected $primaryKey = 'supplyID';
    protected $fillable = ['supplierID', 'itemID', 'drugID'];

    public function supplier() {
        return $this->belongsTo(Supplier::class, 'supplierID');
    }

    public function item() {
        return $this->belongsTo(SurgNonSurgSupply::class, 'itemID');
    }

    public function drug() {
        return $this->belongsTo(PharmaSupply::class, 'drugID');
    }
}
