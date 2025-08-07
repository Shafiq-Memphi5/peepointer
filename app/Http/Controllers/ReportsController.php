<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    //
    public function showReport($id)
    {
        if (!auth()->check()) {
            return redirect('home');
        }

        $toilet = \App\Models\Toilet::findOrFail($id);
        return view('report', compact('toilet'));
    }
    public function addReport(Request $request, $id)
    {
        // authentication check
        if (!auth()->check()) {
            return redirect('home');
        }

        $report = $request->validate([
            'body' => 'required|string|max:1000',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $report['body'] = strip_tags($report['body']);
        $report['user_id'] = auth()->id();
        $report['toilet_id'] = $id;

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('report_images', 'public'); // Save to storage/app/public/report_images
            }
        }

        $report['images'] = json_encode($imagePaths); // Save as JSON in DB

        Report::create($report);

        return redirect()->route('home');
    }
}
