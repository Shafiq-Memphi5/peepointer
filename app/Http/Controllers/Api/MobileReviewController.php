<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Toilet;
use Illuminate\Http\Request;

class MobileReviewController extends Controller
{
    // Show all reviews for a toilet (JSON response)
    public function showReviews($id)
    {
        $toilet = Toilet::find($id);

        if (!$toilet) {
            return response()->json(['error' => 'Toilet not found'], 404);
        }

        $reviews = Review::where('toilet_id', $id)
            ->with('user:id,email') // Adjust fields as needed
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'toilet' => $toilet,
            'reviews' => $reviews,
        ]);
    }

    // Show add review form - **not needed for API** - mobile app handles UI, so you can omit this method.

    // Add a new review
    public function addReview(Request $request, $id)
    {
        $user = $request->user();

        $toilet = Toilet::find($id);
        if (!$toilet) {
            return response()->json(['error' => 'Toilet not found'], 404);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $validated['rating'] = strip_tags($validated['rating']);
        $validated['comment'] = strip_tags($validated['comment']);
        $validated['user_id'] = $user->id;
        $validated['toilet_id'] = $id;

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('review_images', 'public');
            }
        }

        $validated['images'] = json_encode($imagePaths);

        $review = Review::create($validated);

        return response()->json([
            'message' => 'Review added successfully',
            'review' => $review,
        ], 201);
    }
}
