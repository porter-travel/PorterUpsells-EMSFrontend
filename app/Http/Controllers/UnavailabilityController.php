<?php

namespace App\Http\Controllers;

use App\Models\Unavailability;
use Illuminate\Http\Request;

class UnavailabilityController extends Controller
{
    public function store(Request $request, $id) {
        // Validate the request data
        $validatedData = $request->validate([
            'start_at' => 'required|date',
            'end_at' => 'required|date|after:unavailable_from',
            'is_recurrent' => 'required|boolean',
        ]);

        // Create a new Unavailability instance and save it
        $unavailability = new Unavailability();
        $unavailability->product_id = $id;
        $unavailability->start_at = $request->input('start_at'); // Ensure correct field names
        $unavailability->end_at = $request->input('end_at');
        $unavailability->is_recurrent = $request->input('is_recurrent');
        $unavailability->save();

        // Check if the request is AJAX
        if ($request->ajax()) {
            // Return a JSON response for AJAX requests
            return response()->json([
                'success' => true,
                'message' => 'Unavailability period saved successfully!',
            ], 200);
        }

        // Fallback for non-AJAX requests
        return redirect()->back()->with('status', 'Unavailability period saved successfully!');
    }

    public function delete(Request $request, $id) {
        // Find the Unavailability instance
        $unavailability = Unavailability::find($id);

//        dd($unavailability);
        // Check if the Unavailability instance exists
        if ($unavailability) {
            // Delete the Unavailability instance
            $unavailability->delete();

            // Check if the request is AJAX
            if ($request->ajax()) {
                // Return a JSON response for AJAX requests
                return response()->json([
                    'success' => true,
                    'message' => 'Unavailability period deleted successfully!',
                ], 200);
            }

            // Fallback for non-AJAX requests
            return redirect()->back()->with('status', 'Unavailability period deleted successfully!');
        }

        // Check if the request is AJAX
        if ($request->ajax()) {
            // Return a JSON response for AJAX requests
            return response()->json([
                'success' => false,
                'message' => 'Unavailability period not found!',
            ], 404);
        }

        // Fallback for non-AJAX requests
        return redirect()->back()->with('error', 'Unavailability period not found!');
    }

}
