<?php

namespace App\Http\Controllers;

use App\Models\LocalDoctor;
use Illuminate\Http\Request;

class LocalDoctorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $doctors = LocalDoctor::query()
            ->when($search, fn($query) => $query->where('name', 'like', "%$search%")->orWhere('address', 'like', "%$search%")->orWhere('phone', 'like', "%$search%"))
            ->paginate(10);

        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        LocalDoctor::create($request->only('name', 'address', 'phone'));

        return redirect()->route('doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function edit(LocalDoctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, LocalDoctor $doctor)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $doctor->update($request->only('name', 'address', 'phone'));

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(LocalDoctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted.');
    }
}
