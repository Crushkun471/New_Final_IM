<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Add Supplies</h2>
    </x-slot>

    <div class="py-6 px-6 space-y-10">
        {{-- Pharma Supply Form --}}
        <div class="border p-4 rounded shadow">
            <h3 style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">➕ Add Pharmaceutical Supply</h3>
            <form method="POST" action="{{ route('pharma-supplies.store') }}" class="space-y-3 mt-3">
                @csrf
                <input name="drugName" placeholder="Drug Name" class="w-full border p-2" required>
                <input name="description" placeholder="Description" class="w-full border p-2">
                <input name="dosage" placeholder="Dosage" class="w-full border p-2">
                <input name="administrationMethod" placeholder="Administration Method" class="w-full border p-2">
                <input type="number" name="quantityStock" placeholder="Quantity in Stock" class="w-full border p-2" required>
                <input type="number" name="reorderLevel" placeholder="Reorder Level" class="w-full border p-2" required>
                <input type="number" step="0.01" name="costPerUnit" placeholder="Cost per Unit" class="w-full border p-2" required>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add Pharma Supply</button>
            </form>
        </div>

        {{-- Surgical/Non-Surgical Supply Form --}}
        <div class="border p-4 rounded shadow">
            <h3 style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">➕ Add Surgical/Non-Surgical Supply</h3>
            <form method="POST" action="{{ route('surg-supplies.store') }}" class="space-y-3 mt-3">
                @csrf
                <input name="supplyName" placeholder="Supply Name" class="w-full border p-2" required>
                <input name="description" placeholder="Description" class="w-full border p-2">
                <input type="number" name="quantityStock" placeholder="Quantity in Stock" class="w-full border p-2" required>
                <input type="number" name="reorderLevel" placeholder="Reorder Level" class="w-full border p-2" required>
                <input type="number" step="0.01" name="costPerUnit" placeholder="Cost per Unit" class="w-full border p-2" required>

                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add Surg/Non-Surg Supply</button>
            </form>
        </div>
    </div>
</x-app-layout>
