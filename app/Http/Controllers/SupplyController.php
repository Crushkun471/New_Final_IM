<?php

namespace App\Http\Controllers;

use App\Models\PharmaSupply;
use App\Models\SurgNonSurgSupply;

class SupplyController extends Controller
{
    public function index()
    {
        $pharma = PharmaSupply::all();
        $surg = SurgNonSurgSupply::all();

        return view('supplies.index', compact('pharma', 'surg'));
    }
}
