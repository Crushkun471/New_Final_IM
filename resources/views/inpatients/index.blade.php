<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Inpatients Management') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if (session('success'))
            <div class="bg-green-500 text-black p-4 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500 text-black p-4 rounded-md mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Waiting List Dropdown --}}
        <button type="button" onclick="toggleSection('waitingListSection')"
                class="w-full bg-red-600 text-white font-bold py-3 rounded-md cursor-pointer focus:outline-none">
            Waiting List ({{ $waitingList->count() }} patients)
        </button>
        <div id="waitingListSection" class="border border-red-300 rounded-md mt-2 p-4 bg-red-50 max-h-[500px] overflow-auto">
            <table class="min-w-full divide-y divide-gray-300 text-black">
                <thead>
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase">Patient No</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase">Full Name</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase">Sex</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase">Address</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase">Ward Required</th>
                        <th class="px-3 py-2 text-left text-xs font-semibold uppercase">Expected Stay (Days)</th>
                        <th class="px-3 py-2 text-right text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($waitingList as $inpatient)
                        <tr class="even:bg-red-100">
                            <td class="px-3 py-1">{{ $inpatient->patient->patientID ?? 'N/A' }}</td>
                            <td class="px-3 py-1">{{ $inpatient->patient->full_name ?? 'N/A' }}</td>
                            <td class="px-3 py-1">{{ $inpatient->patient->sex ?? 'N/A' }}</td>
                            <td class="px-3 py-1">{{ $inpatient->patient->address ?? 'N/A' }}</td>
                            <td class="px-3 py-1">{{ $inpatient->wardRequired ?? 'N/A' }}</td>
                            <td class="px-3 py-1">{{ $inpatient->expectedDaysToStay ?? 'N/A' }}</td>
                            <td class="px-3 py-1 text-right space-x-2">
                                <a href="{{ route('inpatients.admitPatientForm', $inpatient->inpatientID) }}" style="color: green;" class="text-green-700 hover:underline">Admit</a>
                                <form action="{{ route('inpatients.destroy', $inpatient->inpatientID) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: red;" class="text-red-700 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 py-1 text-center italic">No patients in the waiting list.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Admitted Patients Dropdown --}}
        <button type="button" onclick="toggleSection('admittedPatientsSection')"
                class="w-full bg-green-600 text-white font-bold py-3 rounded-md cursor-pointer focus:outline-none mt-6">
            Admitted Patients ({{ $admittedPatients->count() }} patients)
        </button>
        <div id="admittedPatientsSection" class="border border-green-300 rounded-md mt-2 p-4 bg-green-50 max-h-[500px] overflow-auto">
            <table class="min-w-full divide-y divide-gray-300 text-black">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Ward</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Bed</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Date Admitted</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Expected Stay (Days)</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Expected Leave</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admittedPatients as $inpatient)
                        <tr class="even:bg-green-100">
                            <td class="px-6 py-4">{{ $inpatient->patient->full_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $inpatient->ward->wardName ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $inpatient->bedID ?? 'None' }}</td>
                            <td class="px-6 py-4">
                                {{ $inpatient->dateAdmittedInWard ? \Carbon\Carbon::parse($inpatient->dateAdmittedInWard)->format('Y-m-d') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4">{{ $inpatient->expectedDaysToStay ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                {{ $inpatient->expectedLeave ? \Carbon\Carbon::parse($inpatient->expectedLeave)->format('Y-m-d') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('inpatients.editAdmitted', $inpatient->inpatientID) }}" style="color: blue;" class="text-blue-700 hover:underline">Edit Admitted</a>
                                <form method="POST" action="{{ route('inpatients.destroy', $inpatient->inpatientID) }}" style="color: red;" class="inline" onsubmit="return confirm('Are you sure you want to delete this inpatient?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: red;" class="text-red-700 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center italic">No admitted patients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Discharged Patients Dropdown --}}
        <button type="button" onclick="toggleSection('dischargedPatientsSection')"
                class="w-full bg-blue-600 text-white font-bold py-3 rounded-md cursor-pointer focus:outline-none mt-6">
            Discharged Patients ({{ $dischargedPatients->count() }} patients)
        </button>
        <div id="dischargedPatientsSection" class="border border-blue-300 rounded-md mt-2 p-4 bg-blue-50 max-h-[500px] overflow-auto">
            <table class="min-w-full divide-y divide-gray-300 text-black">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Patient</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Ward</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Bed</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Date Admitted</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold uppercase">Actual Leave</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($dischargedPatients as $inpatient)
                        <tr class="even:bg-blue-100">
                            <td class="px-6 py-4">{{ $inpatient->patient->full_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $inpatient->ward->wardName ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $inpatient->bedID ?? 'None' }}</td>
                            <td class="px-6 py-4">
                                {{ $inpatient->dateAdmittedInWard ? \Carbon\Carbon::parse($inpatient->dateAdmittedInWard)->format('Y-m-d') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $inpatient->actualLeave ? \Carbon\Carbon::parse($inpatient->actualLeave)->format('Y-m-d') : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <form method="POST" action="{{ route('inpatients.destroy', $inpatient->inpatientID) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this discharged inpatient record?');">
                                    @csrf
                                    @method('DELETE')
                                    <button  type="submit" style="color: red;" class="text-red-700 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center italic">No discharged patients found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function toggleSection(id) {
            const section = document.getElementById(id);
            if (!section) return;
            section.style.display = (section.style.display === 'none' || section.style.display === '') ? 'block' : 'none';
        }

        document.getElementById('waitingListSection').style.display = 'none';
        document.getElementById('admittedPatientsSection').style.display = 'none';
        document.getElementById('dischargedPatientsSection').style.display = 'none';
    </script>
</x-app-layout>
