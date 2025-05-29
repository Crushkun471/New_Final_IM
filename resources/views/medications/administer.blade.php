<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">🩺 Administer Medication</h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ route('medications.administer.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-medium"></label>
                <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Select Medication</div>
                <select name="medicationID" required class="w-full border rounded p-2">
                    <option value="">-- Select --</option>
                    @foreach($medications as $med)
                        <option value="{{ $med->medicationID }}">
                            {{ $med->patient->name }} - {{ $med->drug->drugName }}
                        </option>
                    @endforeach
                </select>
            </div>
            <br>

            <div>
                <label class="block font-medium"></label>
                <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Administration Time</div>
                <input type="datetime-local" name="administrationTime" required class="w-full border rounded p-2">
            </div>
            <br>

            <div>
                <label class="block font-medium"></label>
                <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Notes (optional)</div>
                <textarea name="notes" rows="3" class="w-full border rounded p-2"></textarea>
            </div>

            <br>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Submit</button>
        </form>
    </div>
</x-app-layout>
