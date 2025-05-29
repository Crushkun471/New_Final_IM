<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Out-Patients Clinic Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #e3342f;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .hospital-name {
            font-size: 24px;
            font-weight: bold;
            color: #e3342f;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 18px;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .report-info {
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
        }

        .summary-section {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            border-left: 4px solid #e3342f;
        }

        .summary-title {
            font-size: 14px;
            font-weight: bold;
            color: #2d3748;
            margin-bottom: 10px;
        }

        .summary-stats {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .stat-item {
            background: white;
            padding: 10px;
            border-radius: 3px;
            margin: 5px;
            border: 1px solid #e0e0e0;
            text-align: center;
            min-width: 120px;
        }

        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #e3342f;
        }

        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
        }

        .patients-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }

        .patients-table th {
            background-color: #444;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ccc;
        }

        .patients-table td {
            padding: 6px;
            border: 1px solid #ccc;
            vertical-align: top;
        }

        .patients-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .patients-table tr:hover {
            background-color: #f1f8ff;
        }

        .patient-name {
            font-weight: bold;
            color: #2d3748;
        }

        .appointment-info {
            font-size: 9px;
            color: #666;
            margin-top: 3px;
        }

        .status-badge {
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 40px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }

        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            border-top: 1px solid #333;
            padding-top: 10px;
            text-align: center;
            margin-top: 50px;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                margin: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="hospital-name">Hospital Management System</div>
        <div class="report-title">Out-Patients Clinic Referral Report</div>
        <div class="report-info">
            Generated on: {{ $generated_at->format('F d, Y \a\t g:i A') }}<br>
            @if($date_from || $date_to)
            Report Period:
            @if($date_from) From {{ \Carbon\Carbon::parse($date_from)->format('M d, Y') }} @endif
            @if($date_to) To {{ \Carbon\Carbon::parse($date_to)->format('M d, Y') }} @endif
            <br>
            @endif
            @if($search_term)
            Search Filter: "{{ $search_term }}"<br>
            @endif
            Report for: Charge Nurse & Medical Director
        </div>
    </div>

    <div class="summary-section">
        <div class="summary-title">Report Summary</div>
        <div class="summary-stats">
            <div class="stat-item">
                <div class="stat-number">{{ $total_patients }}</div>
                <div class="stat-label">Total Outpatients</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $outpatients->filter(function($p) { return $p->patientAppointments->count() > 0; })->count() }}</div>
                <div class="stat-label">With Appointments</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $outpatients->whereNotNull('clinicID')->count() }}</div>
                <div class="stat-label">With Referral Doctors</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $outpatients->where('sex', 'M')->count() }}</div>
                <div class="stat-label">Male Patients</div>
            </div>
            <div class="stat-item">
                <div class="stat-number">{{ $outpatients->where('sex', 'F')->count() }}</div>
                <div class="stat-label">Female Patients</div>
            </div>
        </div>
    </div>

    @if($outpatients->count() > 0)
    <table class="patients-table">
        <thead>
            <tr>
                <th style="width: 5%">#</th>
                <th style="width: 15%">Patient Name</th>
                <th style="width: 8%">Age/Sex</th>
                <th style="width: 12%">Contact</th>
                <th style="width: 15%">Nurse in Charge</th>
                <th style="width: 15%">Referral Doctor</th>
                <th style="width: 12%">Registration Date</th>
                <th style="width: 15%">Latest Appointment</th>
                <th style="width: 18%">Address</th>
            </tr>
        </thead>
        <tbody>
            @foreach($outpatients as $index => $patient)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <div class="patient-name">{{ $patient->fname }} {{ $patient->lname }}</div>
                    <div style="font-size: 9px; color: #666;">ID: {{ $patient->patientID }}</div>
                    <div style="font-size: 9px; color: #666;">{{ ucfirst($patient->maritalstatus ?? 'N/A') }}</div>
                </td>
                <td>
                    @if($patient->dateofbirth)
                    {{ \Carbon\Carbon::parse($patient->dateofbirth)->age }} yrs<br>
                    @else
                    N/A<br>
                    @endif
                    <strong>{{ $patient->sex == 'M' ? 'Male' : ($patient->sex == 'F' ? 'Female' : 'N/A') }}</strong>
                </td>
                <td>
                    @if($patient->phone)
                    {{ $patient->phone }}
                    @else
                    <em style="color: #999;">Not provided</em>
                    @endif
                </td>
                <td>
                    @if($patient->patientAppointments->count() > 0)
                    @php $latestAppointment = $patient->patientAppointments->first() @endphp
                    @if($latestAppointment->staff)
                    <strong>{{ $latestAppointment->staff->name }}</strong><br>
                    <div style="font-size: 9px;">{{ $latestAppointment->staff->telephone ?? 'No telephone' }}</div>
                    @else
                    <em style="color: #999;">No Nurse in Charge</em>
                    @endif
                    @else
                    <em style="color: #999;">No appointments</em>
                    @endif
                </td>
                <td>
                    @if($patient->doctor)
                    <strong>{{ $patient->doctor->name }}</strong><br>
                    <div style="font-size: 9px;">{{ $patient->doctor->phone ?? 'No phone' }}</div>
                    @else
                    <em style="color: #999;">No referral doctor</em>
                    @endif
                </td>
                <td>
                    @if($patient->dateregistered)
                    {{ \Carbon\Carbon::parse($patient->dateregistered)->format('M d, Y') }}
                    @else
                    N/A
                    @endif
                </td>
                <td>
                    @if($patient->patientAppointments->count() > 0)
                    @php $latestAppointment = $patient->patientAppointments->first() @endphp
                    <strong>{{ \Carbon\Carbon::parse($latestAppointment->appointmentDate)->format('M d, Y') }}</strong><br>
                    <div class="appointment-info">
                        {{ \Carbon\Carbon::parse($latestAppointment->appointmentTime)->format('g:i A') }}<br>
                        Room: {{ $latestAppointment->examinationRoom }}<br>
                        @if($latestAppointment->staff)
                        Dr. {{ $latestAppointment->staff->name }}
                        @endif
                    </div>
                    @elseif($patient->outpatientAppointments->count() > 0)
                    @php $outpatientAppt = $patient->outpatientAppointments->first() @endphp
                    <strong>{{ \Carbon\Carbon::parse($outpatientAppt->appointmentDate)->format('M d, Y') }}</strong><br>
                    <div class="appointment-info">
                        {{ \Carbon\Carbon::parse($outpatientAppt->appointmentTime)->format('g:i A') }}<br>
                        <span class="status-badge status-pending">Scheduled</span>
                    </div>
                    @else
                    <em style="color: #999;">No appointments</em>
                    @endif
                </td>
                <td style="font-size: 9px;">{{ $patient->address ?? 'No address provided' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <h3>No outpatient records found</h3>
        <p>No patients match the specified criteria for this report period.</p>
    </div>
    @endif

    <div class="signature-section">
        <div class="signature-box">
            <strong>Charge Nurse</strong><br>
            Signature & Date
        </div>
        <div class="signature-box">
            <strong>Medical Director</strong><br>
            Signature & Date
        </div>
    </div>

    <div class="footer">
        <strong>Report Details:</strong><br>
        • This report contains {{ $total_patients }} outpatient record(s)<br>
        • Generated from Hospital Management System<br>
        • Report includes patient demographics, referral information, and appointment history<br>
        • For official use by authorized personnel only<br><br>

        <em>This document is confidential and contains sensitive patient information. Handle according to hospital privacy policies.</em>
    </div>
</body>

</html>