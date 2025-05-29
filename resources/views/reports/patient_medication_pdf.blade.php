<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Medication Report - {{ $patient->full_name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f0f0f0; }
        h2, h4 { margin-bottom: 0; }
    </style>
</head>
<body>
    <h2>Medication Report</h2>
    <h4>Patient: {{ $patient->full_name }}</h4>
    <h4>Date of Birth: {{ \Carbon\Carbon::parse($patient->dateofbirth)->format('Y-m-d') }}</h4>
    <h4>Address: {{ $patient->address }}</h4>

    <table>
        <thead>
            <tr>
                <th>Drug Name</th>
                <th>Dosage</th>
                <th>Units/Day</th>
                <th>Method</th>
                <th>Start Date</th>
                <th>End Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($patient->medications as $med)
                <tr>
                    <td>{{ $med->drug->drugName ?? 'N/A' }}</td>
                    <td>{{ $med->drug->dosage ?? 'N/A' }}</td>
                    <td>{{ $med->unitsPerDay }}</td>
                    <td>{{ $med->administrationMethod }}</td>
                    <td>{{ \Carbon\Carbon::parse($med->startDate)->format('Y-m-d') }}</td>
                    <td>{{ \Carbon\Carbon::parse($med->endDate)->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No medication records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
