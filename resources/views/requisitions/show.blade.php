<x-app-layout>
    <x-slot name="header">📄 Requisition #{{ $requisition->requisitionID }}</x-slot>

    <div class="p-6 bg-white rounded shadow">
        <p><strong>Ward:</strong> {{ $requisition->ward->wardName ?? 'N/A' }}</p>
        <p><strong>Placed By:</strong> {{ $requisition->staff->name ?? 'N/A' }}</p>
        <p><strong>Date Ordered:</strong> {{ $requisition->dateOrdered }}</p>
        <p><strong>Status:</strong>
            @if($requisition->dateReceived)
                ✅ Received by {{ $requisition->receivedByNurse->staff->name ?? 'N/A' }} on {{ $requisition->dateReceived }}
            @else
                ⏳ Pending
            @endif
        </p>

        <hr class="my-4">

        <h2 class="text-lg font-semibold mb-2">Requisition Items</h2>
        <table class="w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th>Item</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Cost/Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="border-t">
                    <td>{{ $item->item->supplyName ?? $item->drug->drugName ?? 'Unknown' }}</td>
                    <td>{{ $item->item ? 'Surgical/Non-Surgical' : 'Pharmaceutical' }}</td>
                    <td>{{ $item->quantityRequired }}</td>
                    <td>${{ number_format($item->costPerUnit, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
