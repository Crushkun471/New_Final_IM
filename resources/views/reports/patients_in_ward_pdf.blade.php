<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Patients in Ward: {{ $selectedWard->wardName }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #000; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { margin-bottom: 0; }
        h4 { margin: 4px 0; }
    </style>
</head>
<body>
    <h2>Patients in Ward: {{ $selectedWard->wardName }}</h2>
    <h4>Location: {{ $selectedWard->location }}</h4>
    <h4>Charge Nurse: {{ $selectedWard->chargeNurse->name ?? 'N/A' }}</h4>

    <table>
        <thead>
            <tr>
                <th>Patient Name</th>
                <th>Sex</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Bed Number</th>
                <th>Date Admitted</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($admittedPatients as $inpatient)
                <tr>
                    <td>{{ $inpatient->patient->full_name ?? 'N/A' }}</td>
                    <td>{{ $inpatient->patient->sex ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($inpatient->patient->dateofbirth)->format('Y-m-d') }}</td>
                    <td>{{ $inpatient->patient->address ?? 'N/A' }}</td>
                    <td>{{ $inpatient->bed->bedNumber ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($inpatient->dateAdmittedInWard)->format('Y-m-d') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No admitted patients in this ward.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
