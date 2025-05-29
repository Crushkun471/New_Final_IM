<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Manage Outpatient Records</h2>
    </x-slot>

    <div style="padding: 20px;">
        {{-- Accordion Header --}}
        <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px; display: flex; justify-content: space-between; align-items: center;">
            <span>Outpatient List</span>
            <a href="{{ route('outpatients.report.form') }}"
                style="background-color: #444; color: white; padding: 5px 10px; text-decoration: none; font-size: 12px; border-radius: 3px;">
                📋 Generate Report
            </a>
        </div>

        {{-- Search and Sort --}}
        <div style="border: 1px solid #ccc; padding: 10px; border-top: none; display: flex; justify-content: space-between; align-items: center;">
            <form method="GET" action="{{ route('outpatients.index') }}" style="display: flex; gap: 10px; width: 100%;">
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                    style="padding: 5px; width: 30%; border: 1px solid #ccc;">
                <button type="submit" style="padding: 5px 10px; background-color: #444; color: white; border: none;">Search</button>

                <select name="sort" onchange="this.form.submit()" style="margin-left: auto; padding: 5px; border: 1px solid #ccc;">
                    <option value="">Sort</option>
                    <option value="fname" {{ request('sort') == 'fname' ? 'selected' : '' }}>First Name</option>
                    <option value="lname" {{ request('sort') == 'lname' ? 'selected' : '' }}>Last Name</option>
                </select>
            </form>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto; border: 1px solid #ccc; border-top: none;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead style="background-color: #444; color: white;">
                    <tr>
                        <th style="padding: 8px; border: 1px solid #ccc;">Patient #</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Full Name</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Address</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Telephone</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Date of Birth</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Sex</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Appointment Date & Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($outpatients as $op)
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ccc;">{{ $op->patientID }}</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">{{ $op->fname }} {{ $op->lname }}</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">{{ $op->address }}</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">{{ $op->phone }}</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">
                            {{ $op->dateofbirth ? \Carbon\Carbon::parse($op->dateofbirth)->format('Y-m-d') : 'N/A' }}
                        </td>
                        <td style="padding: 8px; border: 1px solid #ccc;">
                            @if ($op->sex === 'M') Male
                            @elseif ($op->sex === 'F') Female
                            @else {{ $op->sex }}
                            @endif
                        </td>
                        <td style="padding: 8px; border: 1px solid #ccc;">
                            @if ($op->latest_appointment_date)
                                {{ \Carbon\Carbon::parse($op->latest_appointment_date)->format('Y-m-d') }}
                                {{ \Carbon\Carbon::parse($op->latest_appointment_time)->format('H:i') }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 12px; color: gray;">No outpatients found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div style="margin-top: 20px;">
            {{ $outpatients->links() }}
        </div>
    </div>
</x-app-layout>