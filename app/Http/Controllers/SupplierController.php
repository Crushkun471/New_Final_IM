<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        // Simple search by name or address
        if ($search = $request->input('search')) {
            $query->where('supplierName', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%");
        }

        // Sort by name or telephone (default by name)
        if ($sort = $request->input('sort')) {
            if (in_array($sort, ['supplierName', 'telephone'])) {
                $query->orderBy($sort);
            }
        } else {
            $query->orderBy('supplierName');
        }

        $suppliers = $query->paginate(10);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplierName' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
        ]);

        Supplier::create($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'supplierName' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
        ]);

        $supplier->update($request->all());

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
