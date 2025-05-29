@php
    use Carbon\Carbon;
    $admittedDate = $inpatient->dateAdmittedInWard
        ? Carbon::parse($inpatient->dateAdmittedInWard)->format('Y-m-d')
        : '';
    $expectedLeaveDate = $inpatient->expectedLeave
        ? Carbon::parse($inpatient->expectedLeave)->format('Y-m-d')
        : '';
    $actualLeaveDate = $inpatient->actualLeave
        ? Carbon::parse($inpatient->actualLeave)->format('Y-m-d')
        : '';
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-black leading-tight">
            Edit Admitted Patient: {{ $inpatient->patient->full_name ?? 'N/A' }}
        </h2>
    </x-slot>

    <div class="py-6 px-6 max-w-xl mx-auto">
        @if ($errors->any())
            <div class="text-red-600 mb-4 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('inpatients.updateAdmitted', $inpatient->inpatientID) }}">
            @csrf
            @method('PUT')

            {{-- Ward --}}
            <label class="block font-medium mb-1 text-black">Ward:</label>
            <select name="wardID" required
                class="w-full px-3 py-2 mb-4 border border-gray-300 bg-white text-black rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">-- Select Ward --</option>
                @foreach ($wards as $ward)
                    <option value="{{ $ward->wardID }}" {{ old('wardID', $inpatient->wardID) == $ward->wardID ? 'selected' : '' }}>
                        {{ $ward->wardName }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('wardID')" class="mt-1" />

            {{-- Bed Number --}}
            <label class="block font-medium mb-1 text-black">Bed Number (optional):</label>
            <select name="bedID"
                class="w-full px-3 py-2 mb-4 border border-gray-300 bg-white text-black rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                <option value="">None</option>
                @foreach ($beds as $bed)
                    <option value="{{ $bed->bedID }}" {{ old('bedID', $inpatient->bedID) == $bed->bedID ? 'selected' : '' }}>
                        {{ $bed->bedID }} ({{ $bed->ward->wardName ?? 'Unknown Ward' }})
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('bedID')" class="mt-1" />

            {{-- Date Admitted --}}
            <label class="block font-medium mb-1 text-black">Date Admitted:</label>
            <input type="date" name="dateAdmittedInWard" value="{{ old('dateAdmittedInWard', $admittedDate) }}" required readonly
                class="w-full px-3 py-2 mb-4 border border-gray-300 bg-white text-black rounded cursor-not-allowed" />
            <x-input-error :messages="$errors->get('dateAdmittedInWard')" class="mt-1" />

            {{-- Expected Days to Stay --}}
            <label class="block font-medium mb-1 text-black">Expected Days to Stay:</label>
            <input type="number" name="expectedDaysToStay" value="{{ old('expectedDaysToStay', $inpatient->expectedDaysToStay) }}" min="1" required
                class="w-full px-3 py-2 mb-6 border border-gray-300 bg-white text-black rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            <x-input-error :messages="$errors->get('expectedDaysToStay')" class="mt-1" />

            {{-- Expected Leave Date --}}
            <label class="block font-medium mb-1 text-black">Expected Leave Date:</label>
            <input type="date" name="expectedLeave" value="{{ old('expectedLeave', $expectedLeaveDate) }}"
                class="w-full px-3 py-2 mb-6 border border-gray-300 bg-white text-black rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            <x-input-error :messages="$errors->get('expectedLeave')" class="mt-1" />

            {{-- Actual Leave Date --}}
            <label class="block font-medium mb-1 text-black">Actual Leave Date (set to discharge):</label>
            <input type="date" name="actualLeave" value="{{ old('actualLeave', $actualLeaveDate) }}"
                class="w-full px-3 py-2 mb-6 border border-gray-300 bg-white text-black rounded focus:outline-none focus:ring-2 focus:ring-green-500" />
            <x-input-error :messages="$errors->get('actualLeave')" class="mt-1" />

            {{-- Submit Button --}}
            <div class="flex justify-center">
                <button type="submit"
                    class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-600">
                    Update Admitted Record
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
