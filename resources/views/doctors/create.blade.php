<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Local Doctor</h2>
    </x-slot>

    <div class="py-4 px-6">
        @if ($errors->any())
            <div class="text-red-600 mb-4 text-sm">
                <ul>@foreach ($errors->all() as $error)<li>- {{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('doctors.store') }}" class="space-y-6">
            @csrf

            <button type="button" onclick="toggleSection('doctorInfo')" class="w-full bg-red-600 text-white font-semibold py-2 px-4">Doctor Information</button>
            <div id="doctorInfo" class="border p-4 space-y-3">
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><label>Name</label><input name="name" class="w-full border" required></div>
                    <div><label>Phone</label><input name="phone" class="w-full border" required></div>
                    <div class="col-span-2"><label>Address</label><input name="address" class="w-full border" required></div>
                </div>
            </div>

            <div class="flex justify-center space-x-6 pt-4">
                <button type="submit" class="bg-gray-800 text-white px-6 py-2 rounded">Add Doctor</button>
                <button type="reset" class="bg-white border border-gray-400 px-6 py-2 rounded">Clear</button>
            </div>
        </form>
    </div>

    <script>function toggleSection(id) { document.getElementById(id).classList.toggle('hidden'); }</script>
</x-app-layout>
