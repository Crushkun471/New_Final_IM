<x-app-layout>
    <x-slot name="header">
        <h2 style="font-size: 24px; font-weight: bold; color: #2d3748;">Edit Ward Information</h2>
    </x-slot>

    <div style="padding: 20px;">

        @if ($errors->any())
            <div style="color: red; margin-bottom: 15px; font-size: 14px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('wards.update', $ward->wardID) }}">
            @csrf
            @method('PUT')

            {{-- Accordion Header --}}
            <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">
                Ward Information
            </div>

            <div style="border: 1px solid #ccc; padding: 20px; border-top: none; font-size: 14px;">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">

                    <div>
                        <label for="wardID" style="font-weight: 500;">Ward ID</label>
                        <input id="wardID" name="wardID" type="text" value="{{ old('wardID', $ward->wardID) }}" class="w-full border px-2 py-1" readonly>
                    </div>

                    <div>
                        <label for="wardName" style="font-weight: 500;">Ward Name</label>
                        <input id="wardName" name="wardName" type="text" value="{{ old('wardName', $ward->wardName) }}" class="w-full border px-2 py-1" required>
                    </div>

                    <div>
                        <label for="location" style="font-weight: 500;">Location</label>
                        <input id="location" name="location" type="text" value="{{ old('location', $ward->location) }}" class="w-full border px-2 py-1" required>
                    </div>

                    <div>
                        <label for="totalBeds" style="font-weight: 500;">Total Beds</label>
                        <input id="totalBeds" name="totalBeds" type="number" min="1" value="{{ old('totalBeds', $ward->totalBeds) }}" class="w-full border px-2 py-1" required>
                    </div>

                    <div>
                        <label for="telExtension" style="font-weight: 500;">Telephone Extension</label>
                        <input id="telExtension" name="telExtension" type="text" value="{{ old('telExtension', $ward->telExtension) }}" class="w-full border px-2 py-1" required>
                    </div>

                    <div>
                        <label for="staffID" style="font-weight: 500;">Staff in Charge</label>
                        <select id="staffID" name="staffID" class="w-full border px-2 py-1" required>
                            <option value="">-- Select Staff --</option>
                            @foreach ($staff as $s)
                                <option value="{{ $s->staffID }}" {{ old('staffID', $ward->staffID) == $s->staffID ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Buttons --}}
            <div style="display: flex; justify-content: center; gap: 20px; margin-top: 20px;">
                <button type="submit" style="background-color: #2d3748; color: white; padding: 8px 20px; border: none; border-radius: 4px;">Update Ward</button>
                <a href="{{ route('wards.index') }}" style="padding: 8px 20px; border: 1px solid #ccc; background-color: white; border-radius: 4px; text-decoration: none; text-align: center;">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
