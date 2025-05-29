<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WardRequisition extends Model
{
    protected $primaryKey = 'requisitionID';
    protected $fillable = ['wardID', 'staffIDPlacingReq', 'receivedBy', 'dateOrdered', 'dateReceived'];

    public function ward() {
        return $this->belongsTo(Ward::class, 'wardID');
    }

    public function staff() {
        return $this->belongsTo(Staff::class, 'staffIDPlacingReq');
    }

    public function receivedByNurse() {
        return $this->belongsTo(ChargeNurse::class, 'receivedBy', 'staffID');
    }

    public function wardRequisitionItems() {
        return $this->hasMany(WardRequisitionItem::class, 'requisitionItemID');
    }
}
