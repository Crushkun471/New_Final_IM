<?php

namespace App\Http\Controllers;

use App\Models\Inpatient;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Ward;
use App\Models\Bed;
use Illuminate\Validation\Rule;
use Carbon\Carbon; // Make sure Carbon is imported

class InpatientController extends Controller
{
    public function index()
    {
        // Waiting list: inpatients with datePlacedOnWaitlist not null and dateAdmittedInWard null
        $waitingList = Inpatient::with(['patient', 'ward', 'bed'])
            ->whereNotNull('datePlacedOnWaitlist')
            ->whereNull('dateAdmittedInWard')
            ->orderBy('datePlacedOnWaitlist', 'desc')
            ->get();

        // Admitted patients: dateAdmittedInWard not null AND actualLeave null (currently admitted)
        // This is the crucial part. If actualLeave is set, they are no longer "admitted".
        $admittedPatients = Inpatient::with(['patient', 'ward', 'bed'])
            ->whereNotNull('dateAdmittedInWard')
            ->whereNull('actualLeave') // ONLY currently admitted patients
            // The expectedLeave condition helps for cases where expectedLeave is in the past
            // but actualLeave is not yet recorded (they are still considered admitted).
            ->where(function ($query) {
                $query->where('expectedLeave', '>', now())
                      ->orWhereNull('expectedLeave'); // If expectedLeave is not set, assume ongoing
            })
            ->orderBy('dateAdmittedInWard', 'desc')
            ->get();

        // Discharged patients: dateAdmittedInWard not null AND actualLeave not null
        $dischargedPatients = Inpatient::with(['patient', 'ward', 'bed'])
            ->whereNotNull('dateAdmittedInWard')
            ->whereNotNull('actualLeave')
            ->orderBy('actualLeave', 'desc') // Order by actual discharge date
            ->get();

        return view('inpatients.index', compact('waitingList', 'admittedPatients', 'dischargedPatients'));
    }

    public function create()
    {
        $patients = Patient::all();
        $wards = Ward::all();
        $beds = Bed::all();
        return view('inpatients.create', compact('patients', 'wards', 'beds'));
    }

    public function store(Request $request)
    {
        // This method is now ONLY for placing patients on the waitlist.
        // dateAdmittedInWard, expectedLeave, and actualLeave must be NULL initially.
        $data = $request->validate([
            'patientID' => ['required', Rule::exists('patients', 'patientID')],
            'datePlacedOnWaitlist' => ['required', 'date'],
            'wardRequired' => ['required', 'string', 'max:255'],
            'expectedDaysToStay' => ['required', 'integer', 'min:1'],
            // wardID, bedID, dateAdmittedInWard, expectedLeave, actualLeave will be null on creation
            'wardID' => ['nullable'], // Added nullable for consistency
            'bedID' => ['nullable'], // Added nullable for consistency
            'dateAdmittedInWard' => ['nullable', 'date'],
            'expectedLeave' => ['nullable', 'date'],
            'actualLeave' => ['nullable', 'date'],
        ]);

        // Ensure these are null when creating a waitlist entry
        $data['wardID'] = null;
        $data['bedID'] = null;
        $data['dateAdmittedInWard'] = null;
        $data['expectedLeave'] = null;
        $data['actualLeave'] = null;

        Inpatient::create($data);

        return redirect()->route('inpatients.index')->with('success', 'Patient added to waitlist successfully.');
    }

    public function edit(Inpatient $inpatient)
    {
        // This is for general editing of an inpatient record (including waitlist entries)
        // If the patient is already admitted, consider using editAdmitted instead.
        $patients = Patient::all(); // For reference, even if disabled in UI
        $wards = Ward::all();
        $beds = Bed::all();
        return view('inpatients.edit', compact('inpatient', 'patients', 'wards', 'beds'));
    }

    public function update(Request $request, Inpatient $inpatient)
    {
        // This method handles general updates for any inpatient record.
        // It allows changing most fields.
        $data = $request->validate([
            'patientID' => ['required', Rule::exists('patients', 'patientID')], // Patient ID can be changed for general edit
            'wardID' => ['nullable', Rule::exists('wards', 'wardID')],
            'bedID' => ['nullable', Rule::exists('beds', 'bedID')],
            'datePlacedOnWaitlist' => ['required', 'date'],
            'wardRequired' => ['required', 'string', 'max:255'],
            'expectedDaysToStay' => ['required', 'integer', 'min:1'],
            'dateAdmittedInWard' => ['nullable', 'date'],
            'expectedLeave' => ['nullable', 'date', 'after_or_equal:dateAdmittedInWard'],
            'actualLeave' => ['nullable', 'date', 'after_or_equal:dateAdmittedInWard'],
        ]);

        $inpatient->update($data);

        return redirect()->route('inpatients.index')->with('success', 'Inpatient record updated successfully.');
    }

    public function admitPatientForm(Inpatient $inpatient)
    {
        // This method shows the form to admit a patient from the waitlist
        // Only show if the patient is actually on the waitlist
        if ($inpatient->dateAdmittedInWard !== null) {
            return redirect()->route('inpatients.index')->with('error', 'This patient is already admitted.');
        }

        $wards = Ward::all();
        $beds = Bed::all(); // You might want to filter beds by ward here
        return view('inpatients.admit', compact('inpatient', 'wards', 'beds'));
    }

    public function admitPatient(Request $request, Inpatient $inpatient)
    {
        $data = $request->validate([
            'wardID' => ['required', Rule::exists('wards', 'wardID')],
            'bedID' => ['nullable', Rule::exists('beds', 'bedID')],
            'dateAdmittedInWard' => ['required', 'date', 'before_or_equal:now'],
            'expectedDaysToStay' => ['required', 'integer', 'min:1'], // Validation is fine here
        ]);

        // Calculate expectedLeave based on dateAdmittedInWard and expectedDaysToStay
        $dateAdmitted = Carbon::parse($data['dateAdmittedInWard']);

        // --- FIX START ---
        $expectedDays = (int) $data['expectedDaysToStay']; // Explicitly cast to integer
        $expectedLeave = $dateAdmitted->addDays($expectedDays);
        // --- FIX END ---

        $inpatient->update([
            'wardID' => $data['wardID'],
            'bedID' => $data['bedID'],
            'dateAdmittedInWard' => $data['dateAdmittedInWard'],
            'expectedDaysToStay' => $expectedDays, // Use the casted value here too if storing it directly
            'expectedLeave' => $expectedLeave,
            'actualLeave' => null,
        ]);

        return redirect()->route('inpatients.index')->with('success', 'Patient admitted successfully.');
    }




    public function editAdmitted(Inpatient $inpatient)
    {
        // Only allow editing admitted patients for those with dateAdmittedInWard not null
        // and actualLeave null (currently admitted)
        if ($inpatient->dateAdmittedInWard === null || $inpatient->actualLeave !== null) {
            return redirect()->route('inpatients.index')->with('error', 'This patient is not currently admitted.');
        }

        $wards = Ward::all();
        $beds = Bed::all();
        return view('inpatients.edit-admitted', compact('inpatient', 'wards', 'beds'));
    }

    public function updateAdmitted(Request $request, Inpatient $inpatient)
    {
        // This method is for updating details of an *admitted* patient, including discharge.
        $data = $request->validate([
            'wardID' => ['required', Rule::exists('wards', 'wardID')],
            'bedID' => ['nullable', Rule::exists('beds', 'bedID')],
            'dateAdmittedInWard' => ['required', 'date'], // Admitted date shouldn't be changed after admission usually, but leaving it if needed
            'expectedDaysToStay' => ['required', 'integer', 'min:1'],
            'expectedLeave' => ['nullable', 'date', 'after_or_equal:dateAdmittedInWard'],
            'actualLeave' => ['nullable', 'date', 'after_or_equal:dateAdmittedInWard'],
        ]);

        // If actualLeave is set, it means the patient is discharged
        // Consider if you need additional logic here, e.g., marking bed as available.

        $inpatient->update($data);

        // Redirect based on whether they were discharged
        if ($inpatient->actualLeave !== null) {
            return redirect()->route('inpatients.index')->with('success', 'Patient discharged successfully.');
        } else {
            return redirect()->route('inpatients.index')->with('success', 'Admitted inpatient updated successfully.');
        }
    }

    public function destroy(Inpatient $inpatient)
    {
        $inpatient->delete();
        return redirect()->route('inpatients.index')->with('success', 'Inpatient record deleted successfully.');
    }
}