<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Pharmaceutical Supply') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow rounded-lg p-6">

            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pharma-supplies.update', $pharma->drugID) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-medium text-sm">Drug Name</label>
                    <input type="text" name="drugName" value="{{ old('drugName', $pharma->drugName) }}" required class="w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block font-medium text-sm">Description</label>
                    <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description', $pharma->description) }}</textarea>
                </div>

                <div>
                    <label class="block font-medium text-sm">Dosage</label>
                    <input type="text" name="dosage" value="{{ old('dosage', $pharma->dosage) }}" class="w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block font-medium text-sm">Administration Method</label>
                    <input type="text" name="administrationMethod" value="{{ old('administrationMethod', $pharma->administrationMethod) }}" class="w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block font-medium text-sm">Quantity in Stock</label>
                    <input type="number" name="quantityStock" value="{{ old('quantityStock', $pharma->quantityStock) }}" class="w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block font-medium text-sm">Reorder Level</label>
                    <input type="number" name="reorderLevel" value="{{ old('reorderLevel', $pharma->reorderLevel) }}" class="w-full border rounded p-2" />
                </div>

                <div>
                    <label class="block font-medium text-sm">Cost per Unit</label>
                    <input type="number" step="0.01" name="costPerUnit" value="{{ old('costPerUnit', $pharma->costPerUnit) }}" class="w-full border rounded p-2" />
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('supplies.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancel</a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update Supply</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
