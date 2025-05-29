<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\StaffQualification;
use Illuminate\Http\Request;

class StaffQualificationController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffQualification::with('staff');

        // Search by qualification, institution, or staff name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('qualificationType', 'like', '%' . $search . '%')
                  ->orWhere('institution', 'like', '%' . $search . '%')
                  ->orWhereHas('staff', function ($qs) use ($search) {
                      $qs->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        // Sort
        if ($request->filled('sort') && in_array($request->sort, ['qualificationType', 'institution', 'dateOfQualification'])) {
            $query->orderBy($request->sort);
        }

        $qualifications = $query->paginate(10)->appends($request->query());

        return view('qualification.index', compact('qualifications'));
    }

    public function create()
    {
        $staff = Staff::all();
        return view('qualification.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staffID' => 'required|exists:staff,staffID',
            'qualificationType' => 'required|string',
            'institution' => 'required|string',
            'dateOfQualification' => 'required|date',
        ]);

        StaffQualification::create($validated);
        return redirect()->route('qualification.index')->with('success', 'Qualification added.');
    }

    public function edit(StaffQualification $qualification)
    {
        $staff = Staff::all();
        return view('qualification.edit', compact('qualification', 'staff'));
    }

    public function update(Request $request, StaffQualification $qualification)
    {
        $validated = $request->validate([
            'staffID' => 'required|exists:staff,staffID',
            'qualificationType' => 'required|string',
            'institution' => 'required|string',
            'dateOfQualification' => 'required|date',
        ]);

        $qualification->update($validated);
        return redirect()->route('qualification.index')->with('success', 'Qualification updated.');
    }

    public function destroy(StaffQualification $qualification)
    {
        $qualification->delete();
        return redirect()->route('qualification.index')->with('success', 'Qualification deleted.');
    }
}
