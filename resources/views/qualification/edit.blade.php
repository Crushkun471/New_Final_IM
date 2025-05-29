<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Staff Qualification</h2>
    </x-slot>

    <div class="py-4 px-6">
        @if ($errors->any())
            <div class="text-red-600 mb-4 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('qualification.update', $qualification->qualificationID) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <button type="button" onclick="toggleSection('qualEdit')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">Qualification Information</button>
            <div id="qualEdit" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <label>Staff Member</label>
                        <select name="staffID" class="w-full border" required>
                            <option value="">-- Select Staff --</option>
                            @foreach ($staff as $s)
                                <option value="{{ $s->staffID }}" {{ old('staffID', $qualification->staffID) == $s->staffID ? 'selected' : '' }}>
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div><label>Qualification Type</label><input name="qualificationType" class="w-full border" required value="{{ old('qualificationType', $qualification->qualificationType) }}"></div>
                    <div><label>Institution</label><input name="institution" class="w-full border" required value="{{ old('institution', $qualification->institution) }}"></div>
                    <div><label>Date of Qualification</label><input type="date" name="dateOfQualification" class="w-full border" required value="{{ old('dateOfQualification', $qualification->dateOfQualification) }}"></div>
                </div>
            </div>

            <div class="flex justify-center space-x-6 pt-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Update</button>
                <a href="{{ route('qualification.manage') }}" class="bg-gray-300 px-6 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function toggleSection(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>
</x-app-layout>
