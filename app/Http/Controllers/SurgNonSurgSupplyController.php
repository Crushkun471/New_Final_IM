<?php

namespace App\Http\Controllers;

use App\Models\SurgNonSurgSupply;
use Illuminate\Http\Request;

class SurgNonSurgSupplyController extends Controller
{
    public function index()
    {
        $supplies = SurgNonSurgSupply::all();
        return view('surg-supplies.index', compact('supplies'));
    }

    public function create()
    {
        return view('supplies.create'); // Shared view
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'supplyName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantityStock' => 'required|integer',
            'reorderLevel' => 'required|integer',
            'costPerUnit' => 'required|numeric',
        ]);

        SurgNonSurgSupply::create($validated);
        return redirect()->route('supplies.index')->with('success', 'Surgical/Non-Surgical supply added.');
    }

    public function edit($id)
    {
        $supply = SurgNonSurgSupply::findOrFail($id);
        return view('surg-supplies.edit', compact('supply'));
    }

    public function update(Request $request, $id)
    {
        $supply = SurgNonSurgSupply::findOrFail($id);

        $validated = $request->validate([
            'supplyName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantityStock' => 'required|integer',
            'reorderLevel' => 'required|integer',
            'costPerUnit' => 'required|numeric',
        ]);

        $supply->update($validated);
        return redirect()->route('supplies.index')->with('success', 'Surgical/Non-Surgical supply updated.');
    }

    public function destroy($id)
    {
        $supply = SurgNonSurgSupply::findOrFail($id);
        $supply->delete();
        return redirect()->route('supplies.index')->with('success', 'Surgical/Non-Surgical supply deleted.');
    }
}
