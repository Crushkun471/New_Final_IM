<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">📦 Requisitions</h2>
    </x-slot>

    <div class="p-4">
        <a href="{{ route('requisitions.create') }}" class="block">
            <div class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow">
                ➕ Create Requisition
            </div>
        </a>
        <div style="overflow-x: auto; border: 1px solid #ccc;">
            <table style="width: 100%; border-collapse: collapse; font-size: 14px;">
                <thead>
                    <tr style="background-color: #444; color: white;">
                        <th style="padding: 8px; border: 1px solid #ccc;">Requisition ID</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Ward</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Placed By</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Ordered</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Status</th>
                        <th style="padding: 8px; border: 1px solid #ccc;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requisitions as $req)
                    <tr class="border-t">
                        <td style="padding: 8px; border: 1px solid #ccc;">{{ $req->requisitionID }}</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">{{ $req->ward->wardName ?? '' }}</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">{{ $req->staff->name ?? '' }}</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">{{ $req->dateOrdered }}</td>
                        <td style="padding: 8px; border: 1px solid #ccc;">
                            @if($req->dateReceived)
                                ✅ Received by {{ $req->receivedByNurse->staff->name ?? 'N/A' }}
                            @else
                                ⏳ Pending
                            @endif
                        </td>
                        <td style="padding: 8px; border: 1px solid #ccc;">
                            <a href="{{ route('requisitions.show', $req->requisitionID) }}" class="text-blue-600">View</a>
                            @if(!$req->dateReceived)
                                <form action="{{ route('requisitions.accept', $req->requisitionID) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 ml-2">Accept</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>    
    </div>
</x-app-layout>
