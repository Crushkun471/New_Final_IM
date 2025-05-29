<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientAppointment;
use App\Models\Inpatient;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InitialAppointmentController extends Controller
{
    public function index()
    {
        $patients = Patient::with('appointments')->get();
        return view('initial_appointments.index', compact('patients'));
    }

    public function getAppointmentInfo($patientID)
    {
        $appointments = PatientAppointment::with('staff')
            ->where('patientID', $patientID)
            ->get();

        return response()->json($appointments);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,patientID',
        ]);

        $patient = Patient::findOrFail($request->patient_id);

        if ($patient->patienttype === 'outpatient') {
            return redirect()->route('outpatients.index');
        } else {
            // Place inpatient on waiting list
            DB::statement('CALL place_patient_on_waitlist(?)', [
                $request->patient_id
            ]);

            return redirect()->route('inpatients.index')
                ->with('success', 'Patient placed on inpatient waiting list.');
        }
    }
}
