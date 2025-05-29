<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Add New Patient to Waitlist') }}
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 px-6 sm:px-0">
        <form method="POST" action="{{ route('inpatients.store') }}" class="space-y-6 bg-gray-800 p-6 rounded-lg shadow-md">
            @csrf

            <div>
                <x-label for="patientID" :value="__('Patient')" />
                <select id="patientID" name="patientID" required
                    class="block mt-1 w-full rounded-md bg-gray-900 border-gray-700 text-gray-200 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="" disabled selected>Select a patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->patientID }}" {{ old('patientID') == $patient->patientID ? 'selected' : '' }}>
                            {{ $patient->full_name ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('patientID')" class="mt-1" />
            </div>

            <div>
                <x-label for="datePlacedOnWaitlist" :value="__('Date Placed on Waitlist')" />
                <x-input id="datePlacedOnWaitlist" class="block mt-1 w-full" type="date" name="datePlacedOnWaitlist"
                    value="{{ old('datePlacedOnWaitlist') ?? now()->toDateString() }}" required />
                <x-input-error :messages="$errors->get('datePlacedOnWaitlist')" class="mt-1" />
            </div>

            <div>
                <x-label for="wardRequired" :value="__('Ward Required')" />
                <x-input id="wardRequired" class="block mt-1 w-full" type="text" name="wardRequired"
                    value="{{ old('wardRequired') }}" required autocomplete="off" />
                <x-input-error :messages="$errors->get('wardRequired')" class="mt-1" />
            </div>

            <div>
                <x-label for="expectedDaysToStay" :value="__('Expected Days to Stay on Waitlist')" />
                <x-input id="expectedDaysToStay" class="block mt-1 w-full" type="number" name="expectedDaysToStay"
                    value="{{ old('expectedDaysToStay') }}" min="1" required />
                <x-input-error :messages="$errors->get('expectedDaysToStay')" class="mt-1" />
            </div>

            {{-- These fields are REMOVED as they are set during actual admission --}}
            {{-- <input type="hidden" name="wardID" value=""> --}}
            {{-- <input type="hidden" name="bedID" value=""> --}}
            {{-- <input type="hidden" name="dateAdmittedInWard" value=""> --}}
            {{-- <input type="hidden" name="expectedLeave" value=""> --}}
            {{-- <input type="hidden" name="actualLeave" value=""> --}}

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Add to Waitlist') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>