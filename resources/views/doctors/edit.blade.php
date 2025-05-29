<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Local Doctor</h2>
    </x-slot>

    <div class="py-4 px-6">
        @if ($errors->any())
            <div class="text-red-600 mb-4 text-sm">
                <ul>@foreach ($errors->all() as $error)<li>- {{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('doctors.update', $doctor->clinicID) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <button type="button" onclick="toggleSection('doctorEdit')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">Doctor Information</button>
            <div id="doctorEdit" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><label>Name</label><input name="name" class="w-full border" value="{{ old('name', $doctor->name) }}" required></div>
                    <div><label>Phone</label><input name="phone" class="w-full border" value="{{ old('phone', $doctor->phone) }}" required></div>
                    <div class="col-span-2"><label>Address</label><input name="address" class="w-full border" value="{{ old('address', $doctor->address) }}" required></div>
                </div>
            </div>

            <div class="flex justify-center space-x-6 pt-4">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Update</button>
                <a href="{{ route('doctors.index') }}" class="bg-gray-300 px-6 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>

    <script>function toggleSection(id) { document.getElementById(id).classList.toggle('hidden'); }</script>
</x-app-layout>
