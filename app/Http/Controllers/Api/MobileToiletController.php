<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Toilet;
use Illuminate\Http\Request;

class MobileToiletController extends Controller
{
    // Show directions data for a toilet (JSON)
    public function showDirections($id)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $toilet = Toilet::find($id);
        if (!$toilet) {
            return response()->json(['error' => 'Toilet not found'], 404);
        }

        return response()->json([
            'toilet' => $toilet,
        ]);
    }

    // Add a new washroom
    public function addwash(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'description' => 'nullable|string|max:1000',
            'pricing' => 'required|string',
            'address' => 'required|string|max:255',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data['name'] = strip_tags($data['name']);
        $data['latitude'] = strip_tags($data['latitude']);
        $data['longitude'] = strip_tags($data['longitude']);
        $data['description'] = strip_tags($data['description'] ?? '');
        $data['address'] = strip_tags($data['address']);
        $data['pricing'] = strip_tags($data['pricing']);
        $data['user_id'] = $user->id;
        $data['status'] = 'pending';

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('toilet_images', 'public');
            }
        }
        $data['images'] = json_encode($imagePaths);

        $toilet = Toilet::create($data);

        return response()->json([
            'message' => 'Washroom added successfully and pending approval',
            'toilet' => $toilet,
        ], 201);
    }

    // Remove showAddWash() because mobile app handles UI

    // Get toilets near given coordinates
    public function nearbyToilets(Request $request)
    {
        $lat = $request->input('lat');
        $lng = $request->input('lng');

        if (!$lat || !$lng) {
            return response()->json(['error' => 'Missing coordinates'], 400);
        }

        $allToilets = Toilet::select('id', 'name', 'latitude', 'longitude', 'address')
            ->where('status', 'approved')
            ->get();

        $closestToilets = Toilet::select(
                'id',
                'name',
                'latitude',
                'longitude',
                'address',
                'description'
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
            'closestToilets' => $closestToilets,
        ]);
    }
}
