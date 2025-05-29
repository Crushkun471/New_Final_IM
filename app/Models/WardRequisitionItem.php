<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WardRequisitionItem extends Model
{
    protected $primaryKey = 'requisitionItemID';
    protected $fillable = ['requisitionID', 'itemID', 'drugID', 'quantityRequired', 'costPerUnit'];

    public function requisition() {
        return $this->belongsTo(WardRequisition::class, 'requisitionID');
    }

    public function item() {
        return $this->belongsTo(SurgNonSurgSupply::class, 'itemID');
    }

    public function drug() {
        return $this->belongsTo(PharmaSupply::class, 'drugID');
    }
}
