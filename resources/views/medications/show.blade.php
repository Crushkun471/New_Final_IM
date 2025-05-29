<x-app-layout>
    <x-slot name="header">📄 Medication Details</x-slot>

    <div class="p-6 space-y-4">
        <div class="bg-gray-100 p-4 rounded">
            <p><strong>Patient:</strong> {{ $med->patient->name }}</p>
            <p><strong>Drug:</strong> {{ $med->drug->drugName }}</p>
            <p><strong>Units Per Day:</strong> {{ $med->unitsPerDay }}</p>
            <p><strong>Method:</strong> {{ $med->administrationMethod }}</p>
            <p><strong>Start Date:</strong> {{ $med->startDate }}</p>
            <p><strong>End Date:</strong> {{ $med->endDate ?? 'Ongoing' }}</p>
        </div>

        <h2 class="text-lg font-semibold">💉 Administration History</h2>

        <table class="w-full border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">Time</th>
                    <th class="border px-2 py-1">Administered By</th>
                    <th class="border px-2 py-1">Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $record)
                <tr class="border-t">
                    <td class="border px-2 py-1">{{ \Carbon\Carbon::parse($record->administrationTime)->format('Y-m-d H:i') }}</td>
                    <td class="border px-2 py-1">
                        @php
                            $staff = \App\Models\Staff::find($record->administeredBy);
                        @endphp
                        {{ $staff->name ?? 'N/A' }}
                    </td>
                    <td class="border px-2 py-1">{{ $record->notes ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4">No administration records yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
