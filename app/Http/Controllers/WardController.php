<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;
use App\Models\Staff; // Make sure this is imported

class WardController extends Controller
{
    /**
     * Display a listing of the wards.
     */
    public function index(Request $request) // Inject Request for search/sort parameters
    {
        $query = Ward::query(); // Start a query builder instance

        // Eager load the 'staff' relationship (hasMany) to get all staff for each ward
        // Also eager load 'chargeNurse' (belongsTo) if you're using it in the view
        $query->with('staff', 'chargeNurse'); //

        // Apply search logic if a 'search' parameter is present and not empty
        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                // Search by ward's own columns
                $q->where('wardName', 'like', '%' . $search . '%')
                  ->orWhere('location', 'like', '%' . $search . '%');

                // Search by staff names associated with the ward (via the hasMany 'staff' relationship)
                $q->orWhereHas('staff', function ($staffQuery) use ($search) {
                    $staffQuery->where('name', 'like', '%' . $search . '%');
                });

                // Search by the charge nurse's name (via the belongsTo 'chargeNurse' relationship)
                $q->orWhereHas('chargeNurse', function ($chargeNurseQuery) use ($search) {
                    $chargeNurseQuery->where('name', 'like', '%' . $search. '%');
                });
            });
        }

        // Apply sort logic if a 'sort' parameter is present and not empty
        if ($request->has('sort') && $request->input('sort') != '') {
            $query->orderBy($request->input('sort'));
        } else {
            // Default sort if no sort parameter is provided (e.g., by ward name)
            $query->orderBy('wardName');
        }

        // Paginate the results after applying all filters and eager loads
        $wards = $query->paginate(10); //

        return view('wards.index', compact('wards'));
    }

    /**
     * Show the form for creating a new ward.
     */
    public function create()
    {
        // Fetch all staff to populate the dropdown for assigning a charge nurse
        $staff = Staff::all(); // Uses the imported Staff model

        return view('wards.create', compact('staff'));
    }

    /**
     * Store a newly created ward in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'wardName' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'totalBeds' => 'required|integer|min:1',
            'telExtension' => 'required|string|max:20',
            // Validate that staffID exists in the 'staff' table using its 'staffID' column
            'staffID' => 'nullable|exists:staff,staffID',
        ]);

        Ward::create($request->all());

        return redirect()->route('wards.index')->with('success', 'Ward created successfully.');
    }

    /**
     * Show the form for editing the specified ward.
     */
    public function edit($id)
    {
        // Find the ward by its custom primary key 'wardID'
        $ward = Ward::findOrFail($id);
        // Fetch all staff for the dropdown in the edit form
        $staff = Staff::all();

        return view('wards.edit', compact('ward', 'staff'));
    }

    /**
     * Update the specified ward in storage.
     */
    public function update(Request $request, Ward $ward)
    {
        $request->validate([
            'wardName' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'totalBeds' => 'required|integer|min:1',
            'telExtension' => 'required|string|max:20',
            // Validate that staffID exists in the 'staff' table using its 'staffID' column
            'staffID' => 'nullable|exists:staff,staffID',
        ]);

        $ward->update($request->all());

        return redirect()->route('wards.index')->with('success', 'Ward updated successfully.');
    }

    /**
     * Remove the specified ward from storage.
     */
    public function destroy(Ward $ward)
    {
        $ward->delete();

        return redirect()->route('wards.index')->with('success', 'Ward deleted successfully.');
    }
}