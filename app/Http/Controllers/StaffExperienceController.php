<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffExperience;
use Illuminate\Http\Request;

class StaffExperienceController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffExperience::with('staff');

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('organization', 'like', '%' . $search . '%')
                ->orWhere('position', 'like', '%' . $search . '%')
                ->orWhereHas('staff', function ($qs) use ($search) {
                    $qs->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        // Sort support
        if ($request->filled('sort') && in_array($request->sort, ['startDate', 'endDate', 'organization'])) {
            $query->orderBy($request->sort);
        }

        $experiences = $query->paginate(10)->appends($request->query());

        return view('experience.index', compact('experiences'));
    }



    public function create()
    {
        $staff = Staff::all();
        return view('experience.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staffID' => 'required|exists:staff,staffID',
            'organization' => 'required|string',
            'position' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
        ]);

        StaffExperience::create($validated);
        return redirect()->route('experience.index')->with('success', 'Experience added.');
    }

    public function edit(StaffExperience $experience)
    {
        $staff = Staff::all();
        return view('experience.edit', compact('experience', 'staff'));
    }

    public function update(Request $request, StaffExperience $experience)
    {
        $validated = $request->validate([
            'staffID' => 'required|exists:staff,staffID',
            'organization' => 'required|string',
            'position' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
        ]);

        $experience->update($validated);
        return redirect()->route('experience.index')->with('success', 'Experience updated.');
    }

    public function destroy(StaffExperience $experience)
    {
        $experience->delete();
        return redirect()->route('experience.index')->with('success', 'Experience deleted.');
    }
}
