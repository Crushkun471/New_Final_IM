<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Manage Supplies</h2>
    </x-slot>

    <div class="px-6 py-4 space-y-10">
        {{-- Pharma Supplies Table --}}
        <div>
            <h3 style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Pharmaceutical Supplies</h3>
            <table class="w-full table-auto border">
                <thead class="bg-blue-200">
                    <tr>
                        <th class="p-2 border">Drug Name</th>
                        <th class="p-2 border">Dosage</th>
                        <th class="p-2 border">Quantity</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pharma as $drug)
                        <tr>
                            <td class="border p-2">{{ $drug->drugName }}</td>
                            <td class="border p-2">{{ $drug->dosage }}</td>
                            <td class="border p-2">{{ $drug->quantityStock }}</td>
                            <td class="border p-2">
                                <a href="{{ route('pharma-supplies.edit', $drug->drugID) }}" class="text-blue-600">Edit</a>
                                <form action="{{ route('pharma-supplies.destroy', $drug->drugID) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Delete this item?')" class="text-red-600 ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-gray-500 p-4">No pharma supplies found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Surgical Supplies Table --}}
        <div>
            <h3 style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Surgical/Non-Surgical Supplies</h3>
            <table class="w-full table-auto border">
                <thead class="bg-green-200">
                    <tr>
                        <th class="p-2 border">Supply Name</th>
                        <th class="p-2 border">Quantity</th>
                        <th class="p-2 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($surg as $item)
                        <tr>
                            <td class="border p-2">{{ $item->supplyName }}</td>
                            <td class="border p-2">{{ $item->quantityStock }}</td>
                            <td class="border p-2">
                                <a href="{{ route('surg-supplies.edit', $item->itemID) }}" class="text-blue-600">Edit</a>
                                <form action="{{ route('surg-supplies.destroy', $item->itemID) }}" method="POST" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button onclick="return confirm('Delete this item?')" class="text-red-600 ml-2">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-gray-500 p-4">No surgical supplies found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
