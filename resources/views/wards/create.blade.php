<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-dark-800 leading-tight">
            Register New Ward
        </h2>
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

        <form method="POST" action="{{ route('wards.store') }}" class="space-y-6">
            @csrf

            {{-- Ward Information --}}
            <button type="button" onclick="toggleSection('wardInfo')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">
                Ward Information
            </button>

            <div id="wardInfo" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <label for="wardID" class="block font-medium">Ward ID</label>
                        <input id="wardID" name="wardID" type="text" class="w-full border bg-white text-black rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="wardName" class="block font-medium">Ward Name</label>
                        <input id="wardName" name="wardName" type="text" class="w-full border bg-white text-black rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="location" class="block font-medium">Location</label>
                        <input id="location" name="location" type="text" class="w-full border bg-white text-black rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="totalBeds" class="block font-medium">Total Beds</label>
                        <input id="totalBeds" name="totalBeds" type="number" min="1" class="w-full border bg-white text-black rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="telExtension" class="block font-medium">Telephone Extension</label>
                        <input id="telExtension" name="telExtension" type="text" class="w-full border bg-white text-black rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label for="staffID" class="block mb-2 font-semibold">Assign Staff</label>
                        <select id="staffID" name="staffID" class="w-full border bg-white text-black rounded px-2 py-2">
                            <option value="">-- Select Staff --</option>
                            @foreach ($staff as $member)
                                <option value="{{ $member->staffID }}" {{ old('staffID') == $member->staffID ? 'selected' : '' }}>
                                    {{ $member->staffName ?? $member->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="flex justify-center space-x-6 pt-4">
                <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded">Register Ward</button>
                <button type="reset" class="bg-white border border-gray-400 px-6 py-2 rounded">Clear</button>
            </div>
        </form>
    </div>

    <script>
        function toggleSection(id) {
            const section = document.getElementById(id);
            section.classList.toggle('hidden');
        }
    </script>
</x-app-layout>
