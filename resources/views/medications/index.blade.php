<x-app-layout>
    <x-slot name="header">📋 Medication History</x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
        @endif

        <a href="{{ route('medications.create') }}" class="block">
            <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">
                ➕ Prescribe Medication
            </div>
        </a>

        <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
            <thead class="bg-gray-100">
                <tr style="background-color: #444; color: white;">
                    <th style="padding: 8px; border: 1px solid #ccc;">Patient</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Drug</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Units/Day</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Method</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Start</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">End</th>
                    <th style="padding: 8px; border: 1px solid #ccc;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medications as $med)
                <tr class="border-t">
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $med->patient->name }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $med->drug->drugName }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $med->unitsPerDay }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $med->administrationMethod }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $med->startDate }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">{{ $med->endDate ?? 'Ongoing' }}</td>
                    <td style="padding: 8px; border: 1px solid #ccc;">
                        <a href="{{ route('medications.show', $med->medicationID) }}">Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
