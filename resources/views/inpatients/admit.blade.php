@php
    use Carbon\Carbon;
    $admittedDate = old('dateAdmittedInWard') ?? now()->toDateString();
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-dark-800 leading-tight">
            Admit Patient: {{ $inpatient->patient->full_name ?? 'N/A' }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-xl mx-auto">
        @if ($errors->any())
            <div class="text-red-600 mb-4 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('inpatients.admit', $inpatient->inpatientID) }}">
            @csrf
            @method('PUT')

            <p class="text-gray-500 mb-4">
                Patient on Waitlist since: {{ \Carbon\Carbon::parse($inpatient->datePlacedOnWaitlist)->format('Y-m-d') }}
            </p>

            {{-- Ward --}}
            <label class="block font-medium mb-1">Ward</label>
            <select name="wardID" required class="w-full px-3 py-2 mb-4 border bg-white text-black rounded">
                <option value="">-- Select Ward --</option>
                @foreach ($wards as $ward)
                    <option value="{{ $ward->wardID }}" {{ old('wardID', $inpatient->wardID) == $ward->wardID ? 'selected' : '' }}>
                        {{ $ward->wardName }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('wardID')" class="mt-1" />

            {{-- Bed Number --}}
            <label class="block font-medium mb-1">Bed Number (optional)</label>
            <select name="bedID" class="w-full px-3 py-2 mb-4 border bg-white text-black rounded">
                <option value="">None</option>
                @foreach ($beds as $bed)
                    <option value="{{ $bed->bedID }}" {{ old('bedID', $inpatient->bedID) == $bed->bedID ? 'selected' : '' }}>
                        {{ $bed->bedID }} ({{ $bed->ward->wardName ?? 'Unknown Ward' }})
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('bedID')" class="mt-1" />

            {{-- Date Admitted --}}
            <label class="block font-medium mb-1">Date Admitted In Ward</label>
            <input type="date" name="dateAdmittedInWard" value="{{ $admittedDate }}" required
                   class="w-full px-3 py-2 mb-4 border bg-white text-black rounded">
            <x-input-error :messages="$errors->get('dateAdmittedInWard')" class="mt-1" />

            {{-- Expected Stay --}}
            <label class="block font-medium mb-1">Expected Days to Stay</label>
            <input type="number" name="expectedDaysToStay" value="{{ old('expectedDaysToStay', $inpatient->expectedDaysToStay) }}" min="1" required
                   class="w-full px-3 py-2 mb-6 border bg-white text-black rounded">
            <x-input-error :messages="$errors->get('expectedDaysToStay')" class="mt-1" />

            {{-- Submit --}}
            <div class="flex justify-center">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Admit Patient
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
