<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bed;   // Make sure to import your Bed model
use App\Models\Ward;  // Make sure to import your Ward model

class BedController extends Controller
{
    /**
     * Fetch available beds for a given ward.
     * Used for dynamic dropdown population via AJAX.
     *
     * @param int $wardId The ID of the selected ward.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBedsByWard($wardId)
    {
        // First, check if the ward exists to prevent errors
        $ward = Ward::find($wardId);

        if (!$ward) {
            // Return an empty array and a 404 status if the ward is not found
            return response()->json([], 404);
        }

        // Fetch beds belonging to this ward that are currently 'available'
        // Assuming your Bed model has a 'status' column and 'bedID' primary key
        $beds = Bed::where('wardID', $wardId)
                    ->where('status', 'available') // Adjust 'available' if your status value is different
                    ->orderBy('bedNumber') // Order by bedNumber for better user experience
                    ->get(['bedID', 'bedNumber', 'status']); // Select only necessary columns

        return response()->json($beds);
    }
}