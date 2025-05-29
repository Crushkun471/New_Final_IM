<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $primaryKey = 'supplierID';
    protected $fillable = ['supplierName', 'address', 'telephone', 'fax'];
}
