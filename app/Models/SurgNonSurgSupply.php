<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurgNonSurgSupply extends Model
{
    protected $primaryKey = 'itemID';
    protected $fillable = ['supplyName', 'description', 'quantityStock', 'reorderLevel', 'costPerUnit'];
}
