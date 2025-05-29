<?php

namespace App\Http\Controllers;

use App\Models\WardRequisition;
use App\Models\WardRequisitionItem;
use App\Models\SurgNonSurgSupply;
use App\Models\PharmaSupply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WardRequisitionController extends Controller
{
    public function index()
    {
        $requisitions = WardRequisition::with(['ward', 'staff', 'receivedByNurse'])->latest()->get();
        return view('requisitions.index', compact('requisitions'));
    }

    public function create()
    {
        $wards = \App\Models\Ward::all();
        $staff = \App\Models\Staff::all();
        $supplies = SurgNonSurgSupply::all();
        $drugs = PharmaSupply::all();

        return view('requisitions.create', compact('wards', 'staff', 'supplies', 'drugs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'wardID' => 'required',
            'staffIDPlacingReq' => 'required',
            'dateOrdered' => 'required|date',
            'items' => 'required|array'
        ]);

        $requisition = WardRequisition::create([
            'wardID' => $request->wardID,
            'staffIDPlacingReq' => $request->staffIDPlacingReq,
            'dateOrdered' => $request->dateOrdered,
            'receivedBy' => null,
            'dateReceived' => null
        ]);

        foreach ($request->items as $item) {
            WardRequisitionItem::create([
                'requisitionID' => $requisition->requisitionID,
                'itemID' => $item['itemID'] ?? null,
                'drugID' => $item['drugID'] ?? null,
                'quantityRequired' => $item['quantityRequired'],
                'costPerUnit' => $item['costPerUnit'],
            ]);
        }

        return redirect()->route('requisitions.index')->with('success', 'Requisition created successfully!');
    }

    public function show($id)
    {
        $requisition = WardRequisition::with(['ward', 'staff', 'receivedByNurse'])->findOrFail($id);
        $items = WardRequisitionItem::where('requisitionID', $id)->with(['item', 'drug'])->get();

        return view('requisitions.show', compact('requisition', 'items'));
    }

    public function accept($id)
    {
        $requisition = WardRequisition::findOrFail($id);
        $requisition->update([
            'dateReceived' => now(),
            'receivedBy' => Auth::user()->staffID // Assuming staff is logged in
        ]);

        return redirect()->route('requisitions.index')->with('success', 'Requisition accepted!');
    }
}
