<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Outpatient;
use Illuminate\Http\Request;
use App\Models\ViewOutpatient;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class OutpatientController extends Controller
{
    public function index(Request $request)
    {
        $query = ViewOutpatient::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('fname', 'ilike', "%$search%")
                ->orWhere('lname', 'ilike', "%$search%")
                ->orWhere('phone', 'ilike', "%$search%");
            });
        }

        // Sort
        if ($sort = $request->input('sort')) {
            $query->orderBy($sort);
        } else {
            $query->orderBy('dateregistered', 'desc');
        }

        $outpatients = $query->paginate(10)->withQueryString();

        return view('outpatients.index', compact('outpatients'));
    }

    /**
     * Generate PDF report for outpatient clinic referrals
     */
    public function generateReport(Request $request)
    {
        // Query outpatients with their appointments and local doctor info
        $query = Patient::where('patienttype', 'outpatient')
            ->with([
                'doctor', // Changed from 'localDoctor' to 'doctor'
                'outpatientAppointments' => function($q) {
                    $q->orderBy('appointmentDate', 'desc');
                },
                'patientAppointments' => function($q) {
                    $q->with('staff')->orderBy('appointmentDate', 'desc');
                }
            ]);

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('dateregistered', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('dateregistered', '<=', $request->date_to);
        }

        // Search filter
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('fname', 'like', '%' . $search . '%')
                    ->orWhere('lname', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }

        $outpatients = $query->orderBy('dateregistered', 'desc')->get();

        // Generate report data
        $reportData = [
            'outpatients' => $outpatients,
            'total_patients' => $outpatients->count(),
            'generated_at' => Carbon::now(),
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'search_term' => $request->search
        ];

        // Generate PDF
        $pdf = Pdf::loadView('outpatients.report-pdf', $reportData);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'outpatient-clinic-report-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Show report generation form
     */
    public function reportForm()
    {
        return view('outpatients.report-form');
    }

    /**
     * Get statistics for outpatients (for AJAX call in report form)
     */
    public function getStats()
    {
        $outpatients = Patient::where('patienttype', 'outpatient')
            ->with(['patientAppointments', 'doctor'])
            ->get(); 

        return response()->json([
            'total' => $outpatients->count(),
            'with_appointments' => $outpatients->filter(function ($patient) {
                return $patient->patientAppointments->count() > 0;
            })->count(),
            'with_referrals' => $outpatients->filter(function ($patient) {
                return $patient->doctor !== null;
            })->count()
        ]);
    }
}