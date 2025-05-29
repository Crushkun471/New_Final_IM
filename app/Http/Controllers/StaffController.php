<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Ward;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    // List staff with search and sort
    public function index(Request $request)
    {
        $query = Staff::with('ward');

        // Search by name or position
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('fname', 'like', '%' . $request->search . '%')
                  ->orWhere('lname', 'like', '%' . $request->search . '%')
                  ->orWhere('position', 'like', '%' . $request->search . '%');
            });
        }

        // Sort
        if ($request->filled('sort') && in_array($request->sort, ['fname', 'position'])) {
            $query->orderBy($request->sort);
        }

        $staff = $query->paginate(10)->appends($request->query());

        return view('staff.index', compact('staff'));
    }

    // Show form to create staff
    public function create()
    {
        $wards = Ward::all();
        return view('staff.create', compact('wards'));
    }

    // Store new staff
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required|string',
            'lname' => 'required|string',
            'address' => 'required|string',
            'telephone' => 'required|string',
            'dateOfBirth' => 'required|date',
            'sex' => 'required|in:M,F',
            'nationalInsuranceNumber' => 'required|unique:staff',
            'position' => 'required|string',
            'currentSalary' => 'required|numeric',
            'salaryScale' => 'required|string',
            'contractType' => 'required|string',
            'hoursPerWeek' => 'required|integer',
            'paymentType' => 'required|string',
            'wardID' => 'nullable|exists:wards,wardID',
        ]);

        // 👇 Add this to combine fname + lname into 'name'
        $validated['name'] = $validated['fname'] . ' ' . $validated['lname'];

        Staff::create($validated);

        return redirect()->route('dashboard')->with('success', 'Staff member created.');
    }


    // Show form to edit staff
    public function edit(Staff $staff)
    {
        $wards = Ward::all();
        return view('staff.edit', compact('staff', 'wards'));
    }

    // Update staff info
    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'telephone' => 'required|string',
            'dateOfBirth' => 'required|date',
            'sex' => 'required|in:M,F',
            'nationalInsuranceNumber' => 'required|unique:staff,nationalInsuranceNumber,' . $staff->staffID . ',staffID',
            'position' => 'required|string',
            'currentSalary' => 'required|numeric',
            'salaryScale' => 'required|string',
            'contractType' => 'required|string',
            'hoursPerWeek' => 'required|integer',
            'paymentType' => 'required|string',
            'wardID' => 'nullable|exists:wards,wardID',
        ]);

        $staff->update($validated);

        return redirect()->route('staff.index')->with('success', 'Staff member updated.');
    }


    // Delete staff
    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff member deleted.');
    }

    // Advanced search for qualifications or experiences
    public function search(Request $request)
    {
        $query = Staff::query();

        if ($request->filled('qualification')) {
            $query->whereHas('qualifications', function ($q) use ($request) {
                $q->where('qualificationType', 'like', '%' . $request->qualification . '%');
            });
        }

        if ($request->filled('experience')) {
            $query->whereHas('experiences', function ($q) use ($request) {
                $q->where('organization', 'like', '%' . $request->experience . '%')
                  ->orWhere('position', 'like', '%' . $request->experience . '%');
            });
        }

        $staff = $query->with('ward')->paginate(10)->appends($request->query());

        return view('staff.search', compact('staff'));
    }

    // Report: Staff grouped by ward
    public function wardReport()
    {
        $wards = Ward::with('staff')->get();
        return view('staff.ward-report', compact('wards'));
    }
}
