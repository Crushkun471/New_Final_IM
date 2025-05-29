<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Supplier</h2>
    </x-slot>

    <div class="py-4 px-6 max-w-lg mx-auto">
        @if ($errors->any())
            <div class="text-red-600 mb-4 text-sm">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('suppliers.update', $supplier->supplierID) }}">
            @csrf
            @method('PUT')

            <div class="space-y-3">
                <label class="block font-semibold">Supplier Name</label>
                <input name="supplierName" value="{{ old('supplierName', $supplier->supplierName) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="space-y-3">
                <label class="block font-semibold">Address</label>
                <input name="address" value="{{ old('address', $supplier->address) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="space-y-3">
                <label class="block font-semibold">Telephone</label>
                <input name="telephone" value="{{ old('telephone', $supplier->telephone) }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="space-y-3">
                <label class="block font-semibold">Fax</label>
                <input name="fax" value="{{ old('fax', $supplier->fax) }}" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-center space-x-6 pt-4">
                <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded">Update Supplier</button>
                <a href="{{ route('suppliers.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>
