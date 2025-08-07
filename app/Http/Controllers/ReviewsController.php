<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Toilet;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function showReviews($id)
    {
        // Fetch the toilet (optional: with basic info)
        $toilet = Toilet::findOrFail($id);

        // Fetch reviews for this toilet, eager load user if needed
        $reviews = Review::where('toilet_id', $id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Return a view (or JSON if API)
        return view('reviews', compact('toilet', 'reviews'));
    }

    //
    public function showAddReview($id)
    {
        if (!auth()->check()) {
            return redirect('home');
        }

        $toilet = Toilet::findOrFail($id);
        return view('addreviews', compact('toilet'));
    }
    public function addReview(Request $request, $id)
    {
        // authentication check
        if (!auth()->check()) {
            return redirect('home');
        }

        $review = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);



        $review['rating'] = strip_tags($review['rating']);
        $review['comment'] = strip_tags($review['comment']);
        $review['user_id'] = auth()->id();
        $review['toilet_id'] = $id;

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('review_images', 'public');
            }
        }

        $review['images'] = $imagePaths;

        Review::create($review);

        return redirect()->route('home');
    }



}
