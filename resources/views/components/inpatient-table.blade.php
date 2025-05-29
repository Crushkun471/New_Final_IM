@props(['inpatients'])

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-700">
        <thead class="bg-gray-700 text-gray-300">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Patient</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Ward</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Bed</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Placed On</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Admitted On</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Expected Leave</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider">Actual Leave</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900 divide-y divide-gray-700 text-gray-200">
            @forelse($inpatients as $inpatient)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $inpatient->patient->full_name ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $inpatient->ward->wardName ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $inpatient->bed->bedID ?? 'N/A' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ optional($inpatient->datePlacedOnWaitlist)->format('Y-m-d') ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ optional($inpatient->dateAdmittedInWard)->format('Y-m-d') ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ optional($inpatient->expectedLeave)->format('Y-m-d') ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ optional($inpatient->actualLeave)->format('Y-m-d') ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
