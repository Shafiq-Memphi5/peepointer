<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Toilet;
use Illuminate\Http\Request;

class MobileReportController extends Controller
{
    // Optional: fetch toilet details for reporting (JSON)
    public function showReport($toilet_id)
    {
        $toilet = Toilet::find($toilet_id);

        if (!$toilet) {
            return response()->json(['error' => 'Toilet not found'], 404);
        }

        return response()->json([
            'toilet' => $toilet,
        ]);
    }

    // Submit a new report for a toilet
    public function addReport(Request $request, $toilet_id)
    {
        $user = $request->user();

        $toilet = Toilet::find($toilet_id);
        if (!$toilet) {
            return response()->json(['error' => 'Toilet not found'], 404);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:1000',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $validated['body'] = strip_tags($validated['body']);
        $validated['user_id'] = $user->id;
        $validated['toilet_id'] = $toilet_id;

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('report_images', 'public');
            }
        }

        $validated['images'] = json_encode($imagePaths);

        $report = Report::create($validated);

        return response()->json([
            'message' => 'Report submitted successfully',
            'report' => $report,
        ], 201);
    }
}
