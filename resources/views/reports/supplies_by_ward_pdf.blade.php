<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Supplies Report - {{ $ward->wardName }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #000; }
        h2, h4 { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 4px; text-align: left; }
        th { background-color: #f2f2f2; }
        .section { margin-bottom: 25px; }
    </style>
</head>
<body>
    <h2>📦 Supplies Provided to Ward</h2>
    <h4>Ward: {{ $ward->wardName }} ({{ $ward->location }})</h4>
    <h4>Charge Nurse: {{ $ward->chargeNurse->name ?? 'N/A' }}</h4>
    <h4>Medical Director: {{ $ward->staff->first()->name ?? 'N/A' }}</h4>

    @forelse ($requisitions as $req)
        <div class="section">
            <h4>Requisition #{{ $req->requisitionID }}</h4>
            <p><strong>Date Ordered:</strong> {{ $req->dateOrdered }}</p>
            <p><strong>Placed By:</strong> {{ $req->staff->name ?? 'N/A' }}</p>
            <p><strong>Received By:</strong> {{ $req->receivedByNurse->staff->name ?? 'N/A' }} on {{ $req->dateReceived }}</p>

            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Unit Cost</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($req->wardRequisitionItems as $item)
                        <tr>
                            <td>{{ $item->item->supplyName ?? $item->drug->drugName ?? 'Unknown' }}</td>
                            <td>{{ $item->item ? 'Surgical/Non-Surgical' : 'Pharmaceutical' }}</td>
                            <td>{{ $item->quantityRequired }}</td>
                            <td>${{ number_format($item->costPerUnit, 2) }}</td>
                            <td>${{ number_format($item->quantityRequired * $item->costPerUnit, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @empty
        <p>No requisitions received for this ward.</p>
    @endforelse
</body>
</html>
