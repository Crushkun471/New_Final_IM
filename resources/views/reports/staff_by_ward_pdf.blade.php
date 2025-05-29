<!DOCTYPE html>
<html>
<head>
    <title>Staff Allocated to Each Ward</title>
</head>
<body>
    <h2>Staff Allocated to Each Ward</h2>

    @foreach ($wards as $ward)
        <h3>{{ $ward->wardName }} ({{ $ward->location }})</h3>
        <p>Total Beds: {{ $ward->totalBeds }} | Tel: {{ $ward->telExtension }}</p>

        @if ($ward->staff->count() > 0)
            <table border="1" cellpadding="5" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Telephone</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ward->staff as $staff)
                        <tr>
                            <td>{{ $staff->name }}</td>
                            <td>{{ $staff->position }}</td>
                            <td>{{ $staff->telephone }}</td>
                            <td>${{ number_format($staff->currentSalary, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No staff assigned to this ward.</p>
        @endif
        <br>
    @endforeach
</body>
</html>
