<?php

namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\PharmaSupply;
use App\Models\Patient;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index()
    {
        $medications = Medication::with(['patient', 'drug'])->latest()->get();
        return view('medications.index', compact('medications'));
    }

    public function create()
    {
        $patients = Patient::all();
        $drugs = PharmaSupply::all();
        return view('medications.create', compact('patients', 'drugs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patientID' => 'required',
            'drugID' => 'required',
            'unitsPerDay' => 'required|integer|min:1',
            'administrationMethod' => 'required',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date|after_or_equal:startDate',
        ]);

        Medication::create($request->all());

        return redirect()->route('medications.index')->with('success', 'Medication created successfully.');
    }

    public function administer()
    {
        $medications = Medication::with(['patient', 'drug'])->get();
        return view('medications.administer', compact('medications'));
    }
    
    public function storeAdministration(Request $request)
    {
        $request->validate([
            'medicationID' => 'required|exists:medications,medicationID',
            'administrationTime' => 'required|date',
            'notes' => 'nullable|string',
        ]);
    
        MedicationAdministration::create([
            'medicationID' => $request->medicationID,
            'administrationTime' => $request->administrationTime,
            'administeredBy' => auth()->user()->staffID ?? null, // optional
            'notes' => $request->notes,
        ]);
    
        return redirect()->route('medications.index')->with('success', 'Medication administered.');
    }

    public function show(Medication $medication)
    {
        $med = $medication->load(['patient', 'drug']);
        $history = \DB::table('medication_administrations')
                      ->where('medicationID', $med->medicationID)
                      ->orderBy('administrationTime', 'desc')
                      ->get();
    
        return view('medications.show', compact('med', 'history'));
    }
    
}
