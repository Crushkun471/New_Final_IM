<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">💊 Prescribe New Medication</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('medications.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Select Patient</div>
                <select name="patientID" required class="w-full border rounded p-2">
                    <option value="">-- Select Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->patientID }}">{{ $patient->name }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <div>
                <label class="block font-medium"></label>
                <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Select Drug</div>
                <select name="drugID" required class="w-full border rounded p-2">
                    <option value="">-- Select Drug --</option>
                    @foreach($drugs as $drug)
                        <option value="{{ $drug->drugID }}">{{ $drug->drugName }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium"></label>
                    <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Units Per Day</div>
                    <input type="number" name="unitsPerDay" class="w-full border rounded p-2" min="1" required>
                </div>
                <br>
                <div>
                    <label class="block font-medium"></label>
                    <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Method</div>
                    <input type="text" name="administrationMethod" class="w-full border rounded p-2" placeholder="e.g., Oral, IV" required>
                </div>
            </div>
            <br>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium"></label>
                    <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Start Date</div>
                    <input type="date" name="startDate" class="w-full border rounded p-2" required>
                </div>
                <div>
                    <label class="block font-medium"></label>
                    <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">End Date (optional)</div>
                    <input type="date" name="endDate" class="w-full border rounded p-2">
                </div>
            </div>
            <br>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Create Medication</button>
        </form>
    </div>
</x-app-layout>
