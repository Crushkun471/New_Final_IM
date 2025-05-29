<?php
namespace App\Http\Controllers;

use App\Models\PharmaSupply;
use Illuminate\Http\Request;

class PharmaSupplyController extends Controller
{
    public function index()
    {
        $supplies = PharmaSupply::all();
        return view('pharma-supplies.index', compact('supplies'));
    }

    public function create()
    {
        return view('supplies.create'); // Unified view
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'drugName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dosage' => 'nullable|string',
            'administrationMethod' => 'nullable|string',
            'quantityStock' => 'required|integer',
            'reorderLevel' => 'required|integer',
            'costPerUnit' => 'required|numeric',
        ]);

        PharmaSupply::create($validated);
        return redirect()->route('supplies.index')->with('success', 'Pharmaceutical supply added.');
    }

    public function edit($id)
    {
        $supply = PharmaSupply::findOrFail($id);
        return view('pharma-supplies.edit', compact('supply'));
    }

    public function update(Request $request, $id)
    {
        $supply = PharmaSupply::findOrFail($id);

        $validated = $request->validate([
            'drugName' => 'required|string|max:255',
            'description' => 'nullable|string',
            'dosage' => 'nullable|string',
            'administrationMethod' => 'nullable|string',
            'quantityStock' => 'required|integer',
            'reorderLevel' => 'required|integer',
            'costPerUnit' => 'required|numeric',
        ]);

        $supply->update($validated);
        return redirect()->route('supplies.index')->with('success', 'Pharmaceutical supply updated.');
    }

    public function destroy($id)
    {
        $supply = PharmaSupply::findOrFail($id);
        $supply->delete();
        return redirect()->route('supplies.index')->with('success', 'Pharmaceutical supply deleted.');
    }
}
