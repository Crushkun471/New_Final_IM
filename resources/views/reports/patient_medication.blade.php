<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Medication Report by Patient') }}
        </h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6 sm:px-6 lg:px-8 text-black space-y-6">
        {{-- Patient Selection --}}
        <div class="bg-white p-4 shadow rounded border" style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">
            <form method="GET" action="{{ route('reports.patientMedication') }}">
                <label for="patientID" class="font-bold mr-2" >Select Patient:</label>
                <select name="patientID" id="patientID" onchange="this.form.submit()" class="border p-3 rounded text-gray-700">
                    <option value="">-- Select --</option>
                    @foreach ($patients as $patient)
                        <option value="{{ $patient->patientID }}" {{ request('patientID') == $patient->patientID ? 'selected' : '' }}>
                            {{ $patient->full_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- Medication Report --}}
        @if ($selectedPatient)
            <div class="bg-white p-4 shadow rounded border">
                <h3 class="text-lg font-semibold mb-2">Medication Details for {{ $selectedPatient->full_name }}</h3>

                {{-- Export PDF Button --}}
                <a href="{{ route('reports.patientMedication.pdf', ['patientID' => $selectedPatient->patientID]) }}"
                   class="inline-block mb-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    📄 Export as PDF
                </a>

                @if ($selectedPatient->medications->isEmpty())
                    <p class="italic">No medication records found for this patient.</p>
                @else
                    <div class="overflow-auto max-h-[500px]">
                        <table class="min-w-full divide-y divide-gray-300 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-3 py-2 text-left font-semibold uppercase">Drug Name</th>
                                    <th class="px-3 py-2 text-left font-semibold uppercase">Dosage</th>
                                    <th class="px-3 py-2 text-left font-semibold uppercase">Units/Day</th>
                                    <th class="px-3 py-2 text-left font-semibold uppercase">Method</th>
                                    <th class="px-3 py-2 text-left font-semibold uppercase">Start Date</th>
                                    <th class="px-3 py-2 text-left font-semibold uppercase">End Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($selectedPatient->medications as $med)
                                    <tr class="even:bg-gray-100">
                                        <td class="px-3 py-2">{{ $med->drug->drugName ?? 'N/A' }}</td>
                                        <td class="px-3 py-2">{{ $med->drug->dosage ?? 'N/A' }}</td>
                                        <td class="px-3 py-2">{{ $med->unitsPerDay }}</td>
                                        <td class="px-3 py-2">{{ $med->administrationMethod }}</td>
                                        <td class="px-3 py-2">{{ \Carbon\Carbon::parse($med->startDate)->format('Y-m-d') }}</td>
                                        <td class="px-3 py-2">{{ \Carbon\Carbon::parse($med->endDate)->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>
