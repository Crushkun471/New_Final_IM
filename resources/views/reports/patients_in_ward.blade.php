<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center justify-between">
            Patients in Ward Report

            @if ($selectedWard)
                <a href="{{ route('reports.patientsInWard.pdf', ['wardID' => $selectedWard->wardID]) }}"
                   class="ml-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                   📄 Download PDF
                </a>
            @endif
        </h2>
    </x-slot>

    <div class="py-6 px-8">
        {{-- Select Ward --}}
        <div class="mb-6 bg-white p-4 rounded-lg shadow border" style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">
            <form method="GET" action="{{ route('reports.patientsInWard') }}">
                <label for="wardID" class="font-semibold mr-2">Select Ward:</label>
                <select name="wardID" id="wardID" onchange="this.form.submit()" class="border p-3 rounded text-gray-700">
                    @foreach ($wards as $ward)
                        <option value="{{ $ward->wardID }}" {{ $selectedWard->wardID === $ward->wardID ? 'selected' : '' }}>
                            {{ $ward->wardName }} ({{ $ward->location }})
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Ward Info --}}
        @if ($selectedWard)
        <div class="mb-6 bg-white p-4 rounded-lg shadow border">
            <h3 class="text-lg font-semibold text-blue-700 mb-2">Ward Information</h3>
            <p><strong>Name:</strong> {{ $selectedWard->wardName }}</p>
            <p><strong>Location:</strong> {{ $selectedWard->location }}</p>
            <p><strong>Charge Nurse:</strong> {{ $selectedWard->chargeNurse->name ?? 'N/A' }}</p>
        </div>
        @endif

        {{-- Admitted Patients Table --}}
        <div class="bg-white p-4 rounded-lg shadow border">
            <h3 class="text-lg font-semibold text-blue-700 mb-4">Admitted Patients</h3>

            @if ($admittedPatients->isEmpty())
                <p class="text-red-500 italic">No admitted patients in this ward.</p>
            @else
                <div class="overflow-auto max-h-[500px]">
                    <table class="min-w-full border text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2 border">Patient Name</th>
                                <th class="px-3 py-2 border">Sex</th>
                                <th class="px-3 py-2 border">Date of Birth</th>
                                <th class="px-3 py-2 border">Address</th>
                                <th class="px-3 py-2 border">Bed Number</th>
                                <th class="px-3 py-2 border">Date Admitted</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admittedPatients as $inpatient)
                                <tr class="even:bg-gray-50">
                                    <td class="px-3 py-2 border">{{ $inpatient->patient->full_name ?? 'N/A' }}</td>
                                    <td class="px-3 py-2 border">{{ $inpatient->patient->sex ?? 'N/A' }}</td>
                                    <td class="px-3 py-2 border">{{ \Carbon\Carbon::parse($inpatient->patient->dateofbirth)->format('Y-m-d') }}</td>
                                    <td class="px-3 py-2 border">{{ $inpatient->patient->address ?? 'N/A' }}</td>
                                    <td class="px-3 py-2 border">{{ $inpatient->bed->bedNumber ?? 'N/A' }}</td>
                                    <td class="px-3 py-2 border">{{ \Carbon\Carbon::parse($inpatient->dateAdmittedInWard)->format('Y-m-d') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
