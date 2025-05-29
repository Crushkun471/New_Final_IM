<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Staff Experience</h2>
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

        <form method="POST" action="{{ route('experience.update', $experience->experienceID) }}" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Experience Info --}}
            <button type="button" onclick="toggleSection('expEdit')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">Experience Information</button>
            <div id="expEdit" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <label>Staff Member</label>
                        <select name="staffID" class="w-full border" required>
                            <option value="">-- Select Staff --</option>
                            @foreach ($staff as $s)
                                <option value="{{ $s->staffID }}" {{ old('staffID', $experience->staffID) == $s->staffID ? 'selected' : '' }}>
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div><label>Organization</label><input name="organization" class="w-full border" required value="{{ old('organization', $experience->organization) }}"></div>
                    <div><label>Position</label><input name="position" class="w-full border" required value="{{ old('position', $experience->position) }}"></div>
                    <div><label>Start Date</label><input type="date" name="startDate" class="w-full border" required value="{{ old('startDate', $experience->startDate) }}"></div>
                    <div><label>End Date (optional)</label><input type="date" name="endDate" class="w-full border" value="{{ old('endDate', $experience->endDate) }}"></div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex justify-center space-x-6 pt-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Update</button>
                <a href="{{ route('experience.index') }}" class="bg-gray-300 px-6 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        function toggleSection(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>
</x-app-layout>
