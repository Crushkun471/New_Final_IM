<?php

namespace App\Http\Controllers;

use App\Models\Inpatient;
use App\Models\Patient;
use App\Models\Ward;
use App\Models\Bed;
use Illuminate\Http\Request;

class WaitingListController extends Controller
{
    // List all patients currently on the waiting list
    public function index()
    {
        $waitingPatients = Inpatient::waitingList()->with('patient', 'ward')->get();
        // Adjusted view path
        return view('wards.waitinglist', compact('waitingPatients'));
    }

    // Show form to add patient to waiting list
    public function create()
    {
        $patients = Patient::all();
        $wards = Ward::all();
        // Adjusted view path
        return view('wards.waitinglist-create', compact('patients', 'wards'));
    }

    // Store new waiting list patient (create inpatient record with waitlist date)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patientID' => 'required|exists:patients,patientID',
            'wardRequired' => 'required|exists:wards,wardID',
            'datePlacedOnWaitlist' => 'required|date',
            'expectedDaysToStay' => 'nullable|integer',
        ]);

        Inpatient::create([
            'patientID' => $validated['patientID'],
            'wardRequired' => $validated['wardRequired'],
            'datePlacedOnWaitlist' => $validated['datePlacedOnWaitlist'],
            'expectedDaysToStay' => $validated['expectedDaysToStay'] ?? null,
        ]);

        return redirect()->route('waitinglist.index')->with('success', 'Patient added to waiting list.');
    }

    // Show form to admit patient (assign bed and admission date)
    public function admitForm($inpatientID)
    {
        $inpatient = Inpatient::findOrFail($inpatientID);
        $wards = Ward::all();
        $beds = Bed::where('wardID', $inpatient->wardRequired)->get();

        // Adjusted view path
        return view('wards.waitinglist-admit', compact('inpatient', 'wards', 'beds'));
    }

    // Admit patient: update inpatient record with bed and admission date
    public function admit(Request $request, $inpatientID)
    {
        $inpatient = Inpatient::findOrFail($inpatientID);

        $validated = $request->validate([
            'bedID' => 'required|exists:beds,bedID',
            'dateAdmittedInWard' => 'required|date',
            'expectedLeave' => 'nullable|date|after_or_equal:dateAdmittedInWard',
        ]);

        $inpatient->update([
            'bedID' => $validated['bedID'],
            'dateAdmittedInWard' => $validated['dateAdmittedInWard'],
            'expectedLeave' => $validated['expectedLeave'] ?? null,
        ]);

        return redirect()->route('waitinglist.index')->with('success', 'Patient admitted successfully.');
    }

    // Cancel waiting list entry or delete
    public function destroy($inpatientID)
    {
        $inpatient = Inpatient::findOrFail($inpatientID);
        $inpatient->delete();

        return redirect()->route('waitinglist.index')->with('success', 'Waiting list entry removed.');
    }
}
