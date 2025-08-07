<?php

namespace App\Http\Controllers;

use App\Models\Toilet;
use Illuminate\Http\Request;

class ToiletController extends Controller
{
    public function showDirections($id)
    {
        if (!auth()->check()) {
            return redirect('home');
        }
        $toilet = Toilet::findOrFail($id);
        return view('direction', compact('toilet'));
    }

    //add new washroom
    public function addwash(Request $request)
    {
        // authentication check
        if (!auth()->check()) {
            return redirect('home');
        }
        $toilet = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string|max:1000',
            'pricing' => 'required',
            'address' => 'required|string|max:255',
            'status' => 'pending',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $toilet['name'] = strip_tags($toilet['name']);
        $toilet['latitude'] = strip_tags($toilet['latitude']);
        $toilet['longitude'] = strip_tags($toilet['longitude']);
        $toilet['description'] = strip_tags($toilet['description']);
        $toilet['address'] = strip_tags($toilet['address']);
        $toilet['pricing'] = strip_tags($toilet['pricing']);
        $toilet['user_id'] = auth()->id();
        $toilet['status'] = 'pending';

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('toilet_images', 'public');
            }
        }

        $toilet['images'] = $imagePaths;

        Toilet::create($toilet);

        return redirect()->route('home');
    }
    //display add washroom page
    public function showAddWash()
    {
        //auth check
        if (!auth()->check()) {
            return redirect('home');
        }
        return view('washadd');
    }
    // display toilets close to the user
    public function nearbyToilets(Request $request)
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        if (!$lat || !$lng) {
            return response()->json(['error' => 'Missing coordinates'], 400);
        }

        // All toilets (for showing on the map)
        $allToilets = Toilet::select('toilets.id', 'toilets.name', 'toilets.latitude', 'toilets.longitude', 'toilets.address')
            ->where('toilets.status', 'approved')
            ->get();

        // 5 closest toilets with distance and reviews (for cards)
        $closestToilets = Toilet::select(
                'toilets.id',
                'toilets.name',
                'toilets.latitude',
                'toilets.longitude',
                'toilets.address',
                'toilets.description'
            )
            ->selectRaw('
                (6371 * acos(
                    cos(radians(?)) * cos(radians(latitude)) *
                    cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(latitude))
                )) AS distance', [$lat, $lng, $lat])
            ->leftJoin('reviews', 'toilets.id', '=', 'reviews.toilet_id')
            ->where('toilets.status', 'approved')
            ->groupBy('toilets.id', 'toilets.name', 'toilets.latitude', 'toilets.longitude', 'toilets.address', 'toilets.description')
            ->selectRaw('COALESCE(AVG(reviews.rating), 0) AS avg_rating, COUNT(reviews.id) AS reviews_count')
            ->orderBy('distance')
            ->limit(5)
            ->get();

        return response()->json([
            'allToilets' => $allToilets,
            'closestToilets' => $closestToilets
        ]);
    }

}
