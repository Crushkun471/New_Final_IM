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
        <h2 style="font-size: 24px; font-weight: bold; color: #f7fafc;">Edit Inpatient Record</h2>
    </x-slot>

    <div style="padding: 20px; max-width: 600px; margin: 0 auto;">

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('inpatients.update', $inpatient->inpatientID) }}">
            @csrf
            @method('PUT')

            <label style="color: #cbd5e0;">Patient Name:</label><br>
            <input type="text" value="{{ $inpatient->patient->full_name ?? 'N/A' }}" disabled
                   style="width: 100%; padding: 8px; margin-bottom: 10px; background-color: #374151; border: 1px solid #4b5563; color: #e5e7eb; border-radius: 0.375rem;"><br>

            <label style="color: #cbd5e0;">Date Placed on Waitlist:</label><br>
            <input type="date" name="datePlacedOnWaitlist" value="{{ old('datePlacedOnWaitlist', Carbon::parse($inpatient->datePlacedOnWaitlist)->format('Y-m-d')) }}" required
                   style="width: 100%; padding: 8px; margin-bottom: 10px; background-color: #374151; border: 1px solid #4b5563; color: #e5e7eb; border-radius: 0.375rem;"><br>
            <x-input-error :messages="$errors->get('datePlacedOnWaitlist')" class="mt-1" /><br>

            <label style="color: #cbd5e0;">Ward Required:</label><br>
            <input type="text" name="wardRequired" value="{{ old('wardRequired', $inpatient->wardRequired) }}" required
                   style="width: 100%; padding: 8px; margin-bottom: 10px; background-color: #374151; border: 1px solid #4b5563; color: #e5e7eb; border-radius: 0.375rem;"><br>
            <x-input-error :messages="$errors->get('wardRequired')" class="mt-1" /><br>

            <label style="color: #cbd5e0;">Ward (if admitted):</label><br>
            <select name="wardID" style="width: 100%; padding: 8px; margin-bottom: 10px; background-color: #374151; border: 1px solid #4b5563; color: #e5e7eb; border-radius: 0.375rem;">
                <option value="">-- Select Ward --</option>
                @foreach ($wards as $ward)
                    <option value="{{ $ward->wardID }}" {{ old('wardID', $inpatient->wardID) == $ward->wardID ? 'selected' : '' }}>
                        {{ $ward->wardName }}
                    </option>
                @endforeach
            </select><br>
            <x-input-error :messages="$errors->get('wardID')" class="mt-1" /><br>

            <label style="color: #cbd5e0;">Bed Number (if admitted):</label><br>
            <select name="bedID" style="width: 100%; padding: 8px; margin-bottom: 10px; background-color: #374151; border: 1px solid #4b5563; color: #e5e7eb; border-radius: 0.375rem;">
                <option value="">None</option>
                @foreach ($beds as $bed)
                    <option value="{{ $bed->bedID }}" {{ old('bedID', $inpatient->bedID) == $bed->bedID ? 'selected' : '' }}>
                        {{ $bed->bedID }} ({{ $bed->ward->wardName ?? 'Unknown Ward' }})
                    </option>
                @endforeach
            </select><br>
            <x-input-error :messages="$errors->get('bedID')" class="mt-1" /><br>


            <label style="color: #cbd5e0;">Date Admitted (optional):</label><br>
            <input type="date" name="dateAdmittedInWard" value="{{ old('dateAdmittedInWard', $admittedDate) }}"
                   style="width: 100%; padding: 8px; margin-bottom: 10px; background-color: #374151; border: 1px solid #4b5563; color: #e5e7eb; border-radius: 0.375rem;"><br>
            <x-input-error :messages="$errors->get('dateAdmittedInWard')" class="mt-1" /><br>

            <label style="color: #cbd5e0;">Expected Days to Stay (if admitted):</label><br>
            <input type="number" name="expectedDaysToStay" value="{{ old('expectedDaysToStay', $inpatient->expectedDaysToStay) }}" min="1"
                   style="width: 100%; padding: 8px; margin-bottom: 20px; background-color: #374151; border: 1px solid #4b5563; color: #e5e7eb; border-radius: 0.375rem;"><br>
            <x-input-error :messages="$errors->get('expectedDaysToStay')" class="mt-1" /><br>

            <label style="color: #cbd5e0;">Expected Leave Date (optional):</label><br>
            <input type="date" name="expectedLeave" value="{{ old('expectedLeave', $expectedLeaveDate) }}"
                   style="width: 100%; padding: 8px; margin-bottom: 20px; background-color: #374151; border: 1px solid #4b5563; color: #e5e7eb; border-radius: 0.375rem;"><br>
            <x-input-error :messages="$errors->get('expectedLeave')" class="mt-1" /><br>

            <label style="color: #cbd5e0;">Actual Leave Date (optional):</label><br>
            <input type="date" name="actualLeave" value="{{ old('actualLeave', $actualLeaveDate) }}"
                   style="width: 100%; padding: 8px; margin-bottom: 20px; background-color: #374151; border: 1px solid #4b5563; color: #e5e7eb; border-radius: 0.375rem;"><br>
            <x-input-error :messages="$errors->get('actualLeave')" class="mt-1" /><br>


            <button type="submit" style="padding: 10px 20px; background-color: #22c55e; color: white; border: none; border-radius: 0.375rem; cursor: pointer;">Update Record</button>
        </form>
    </div>
</x-app-layout>