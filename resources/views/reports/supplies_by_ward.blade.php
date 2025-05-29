<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Supplies Provided to Ward Report') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 text-black space-y-6">
        {{-- Ward Selection --}}
        <form method="GET" action="{{ route('reports.suppliesByWard') }}" class="bg-white p-4 rounded shadow border" style="background-color: #e3342f; color: white; font-weight: bold; padding: 10px;">
            <label for="wardID" class="font-bold mr-2">Select Ward:</label>
            <select name="wardID" id="wardID" onchange="this.form.submit()" class="border p-3 rounded text-gray-700">
                @foreach ($wards as $w)
                    <option value="{{ $w->wardID }}" {{ $ward->wardID === $w->wardID ? 'selected' : '' }}>
                        {{ $w->wardName }} ({{ $w->location }})
                    </option>
                @endforeach
            </select>
        </form>

        {{-- Ward Information --}}
        <div class="bg-white p-4 rounded shadow border">
            <h3 class="text-lg font-semibold mb-2">Ward Details</h3>
            <p><strong>Ward:</strong> {{ $ward->wardName }} ({{ $ward->location }})</p>
            <p><strong>Charge Nurse:</strong> {{ $ward->chargeNurse->name ?? 'N/A' }}</p>
            <p><strong>Medical Director:</strong> {{ $ward->staff->first()->name ?? 'N/A' }}</p>

            <a href="{{ route('reports.suppliesByWardPdf', ['wardID' => $ward->wardID]) }}"
               class="inline-block mt-4 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                📄 Export as PDF
            </a>
        </div>

        {{-- Requisition Table --}}
        <div class="bg-white p-4 rounded shadow border">
            <h3 class="text-lg font-semibold mb-4">Supplies Provided</h3>
            @forelse ($requisitions as $req)
                <div class="mb-6 border-b pb-4">
                    <h4 class="font-bold text-md mb-2">📦 Requisition #{{ $req->requisitionID }}</h4>
                    <p><strong>Ordered:</strong> {{ $req->dateOrdered }}</p>
                    <p><strong>Placed By:</strong> {{ $req->staff->name ?? 'N/A' }}</p>
                    <p><strong>Received By:</strong> {{ $req->receivedByNurse->staff->name ?? 'N/A' }} (on {{ $req->dateReceived }})</p>

                    <table class="w-full mt-2 text-sm border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-1 border">Item</th>
                                <th class="px-2 py-1 border">Type</th>
                                <th class="px-2 py-1 border">Quantity</th>
                                <th class="px-2 py-1 border">Unit Cost</th>
                                <th class="px-2 py-1 border">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($req->wardRequisitionItems as $item)
                                <tr class="even:bg-gray-100">
                                    <td class="px-2 py-1 border">
                                        {{ $item->item->supplyName ?? $item->drug->drugName ?? 'Unknown' }}
                                    </td>
                                    <td class="px-2 py-1 border">
                                        {{ $item->item ? 'Surgical/Non-Surgical' : 'Pharmaceutical' }}
                                    </td>
                                    <td class="px-2 py-1 border">{{ $item->quantityRequired }}</td>
                                    <td class="px-2 py-1 border">${{ number_format($item->costPerUnit, 2) }}</td>
                                    <td class="px-2 py-1 border">
                                        ${{ number_format($item->quantityRequired * $item->costPerUnit, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @empty
                <p class="italic">No supplies provided to this ward yet.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
