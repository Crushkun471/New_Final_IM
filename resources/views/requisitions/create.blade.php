<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">➕ Create Requisition</h2>
    </x-slot>

    <div class="p-6 bg-white shadow rounded">
        <form action="{{ route('requisitions.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Ward</div>
                    <select name="wardID" required class="w-full border rounded p-2">
                        <option value="">-- Select Ward --</option>
                        @foreach($wards as $ward)
                            <option value="{{ $ward->wardID }}">{{ $ward->wardName }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Placed By</div>
                    <select name="staffIDPlacingReq" required class="w-full border rounded p-2">
                        <option value="">-- Select Staff --</option>
                        @foreach($staff as $member)
                            <option value="{{ $member->staffID }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <div style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">Date Ordered</div>
                    <input type="date" name="dateOrdered" required class="w-full border rounded p-2">
                </div>
            </div>

            <hr class="my-4">

            <div>
                <h2 class="text-lg font-semibold mb-2" style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">🧾 Requisition Items</h2>
                <div id="itemsContainer"></div>

                <button type="button" onclick="addItemRow()" class="bg-blue-500 text-gray-1000 px-3 py-1 rounded mt-2">➕ Add Item</button>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Submit Requisition</button>
            </div>
        </form>
    </div>

    <script>
        const supplies = @json($supplies);
        const drugs = @json($drugs);
        let itemCount = 0;

        function addItemRow() {
            const container = document.getElementById('itemsContainer');
            const index = itemCount++;
            const row = document.createElement('div');
            row.classList.add('grid', 'grid-cols-1', 'md:grid-cols-5', 'gap-2', 'mb-2', 'items-center');

            row.innerHTML = `
                <select name="items[${index}][itemID]" class="border p-2 rounded">
                    <option value="">-- Surgical/Non-Surgical --</option>
                    ${supplies.map(item => `<option value="${item.itemID}">${item.supplyName}</option>`).join('')}
                </select>

                <select name="items[${index}][drugID]" class="border p-2 rounded">
                    <option value="">-- Pharma Supply --</option>
                    ${drugs.map(drug => `<option value="${drug.drugID}">${drug.drugName}</option>`).join('')}
                </select>

                <input type="number" name="items[${index}][quantityRequired]" placeholder="Quantity" class="border p-2 rounded" min="1" required>

                <input type="number" name="items[${index}][costPerUnit]" placeholder="Cost/Unit" class="border p-2 rounded" step="0.01" min="0" required>

                <button type="button" onclick="this.parentElement.remove()" class="bg-red-500 text-white px-2 py-1 rounded">✖</button>
            `;
            container.appendChild(row);
        }
    </script>
</x-app-layout>
