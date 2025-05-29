<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Ward;
use App\Models\Inpatient;
use App\Models\Patient;
use App\Models\WardRequisition;


class ReportController extends Controller
{
    public function staffByWard()
    {
        $wards = Ward::with('staff')->get(); // Eager load staff for each ward
        return view('reports.staff_by_ward', compact('wards'));
    }

    public function staffByWardPdf()
    {
        $wards = \App\Models\Ward::with(['staff' => function ($query) {
            $query->whereIn('position', ['Personnel Officer', 'Charge Nurse']);
        }])->get();

        $pdf = PDF::loadView('reports.staff_by_ward_pdf', compact('wards'));

        return $pdf->download('staff_allocated_by_ward.pdf');
    }

    public function patientsInWard(Request $request)
    {
        // Get ward ID from query or default to the first ward
        $wardID = $request->input('wardID');

        $wards = Ward::with('chargeNurse')->get();

        $selectedWard = $wardID
            ? Ward::with('chargeNurse')->find($wardID)
            : $wards->first();

        $admittedPatients = Inpatient::with(['patient', 'bed'])
            ->where('wardID', $selectedWard->wardID ?? null)
            ->whereNotNull('dateAdmittedInWard')
            ->whereNull('actualLeave')
            ->get();

        return view('reports.patients_in_ward', compact('wards', 'selectedWard', 'admittedPatients'));
    }

    public function patientsInWardPdf(Request $request)
    {
        $wardID = $request->input('wardID');

        $selectedWard = \App\Models\Ward::with('chargeNurse')->findOrFail($wardID);

        $admittedPatients = \App\Models\Inpatient::with(['patient', 'bed'])
            ->where('wardID', $wardID)
            ->whereNotNull('dateAdmittedInWard')
            ->whereNull('actualLeave')
            ->get();

        $pdf = PDF::loadView('reports.patients_in_ward_pdf', compact('selectedWard', 'admittedPatients'))
                ->setPaper('a4', 'portrait');

        return $pdf->download("patients_in_ward_{$selectedWard->wardName}.pdf");
    }

    public function patientMedication(Request $request)
    {
        $patients = Patient::with('medications.drug')->orderBy('lname')->get();
        $selectedPatientID = $request->input('patientID');
        $selectedPatient = $patients->where('patientID', $selectedPatientID)->first();

        return view('reports.patient_medication', compact('patients', 'selectedPatient'));
    }

    public function patientMedicationPdf(Request $request)
    {
        $patientID = $request->input('patientID');
        $patient = Patient::with('medications.drug')->findOrFail($patientID);

        $pdf = Pdf::loadView('reports.patient_medication_pdf', compact('patient'))
                ->setPaper('a4', 'portrait');

        return $pdf->download("medication_report_{$patient->full_name}.pdf");
    }

    public function suppliesByWard(Request $request)
    {
        $wards = Ward::all();
        $wardID = $request->input('wardID') ?? $wards->first()?->wardID;

        $ward = Ward::with(['staff' => function ($q) {
            $q->where('position', 'Medical Director');
        }, 'chargeNurse'])->findOrFail($wardID);

        $requisitions = WardRequisition::with(['staff', 'receivedByNurse.staff', 'wardRequisitionItems.item', 'wardRequisitionItems.drug'])
            ->where('wardID', $wardID)
            ->whereNotNull('dateReceived')
            ->orderByDesc('dateOrdered')
            ->get();

        return view('reports.supplies_by_ward', compact('wards', 'ward', 'requisitions'));
    }

    public function suppliesByWardPdf(Request $request)
    {
        $wardID = $request->input('wardID');
        $ward = Ward::with(['staff' => function ($q) {
            $q->where('position', 'Medical Director');
        }, 'chargeNurse'])->findOrFail($wardID);

        $requisitions = WardRequisition::with(['staff', 'receivedByNurse.staff', 'wardRequisitionItems.item', 'wardRequisitionItems.drug'])
            ->where('wardID', $wardID)
            ->whereNotNull('dateReceived')
            ->orderByDesc('dateOrdered')
            ->get();

        $pdf = Pdf::loadView('reports.supplies_by_ward_pdf', compact('ward', 'requisitions'))
                ->setPaper('a4', 'landscape');

        return $pdf->download("supplies_provided_to_{$ward->wardName}.pdf");
    }

}
