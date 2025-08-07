<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Review;
use App\Models\Toilet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showAnalytics()
    {
        return view('analytics');
    }
    public function showUsers()
    {
        $users = User::all();
        return view('allusers', compact('users'));
    }
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('allusers')->with('success', 'User deleted successfully.');
    }
    public function deleteReport($id)
    {
        $report = Report::findOrFail($id);

        // Optional: delete related reviews, images, etc. if needed
        // $toilet->reviews()->delete();

        $report->delete();

        return redirect()->route('admin.reports.delete')
            ->with('success', 'Toilet deleted successfully.');
    }
    public function deleteToilet($id)
    {
        $toilet = Toilet::findOrFail($id);

        // Optional: delete related reviews, images, etc. if needed
        // $toilet->reviews()->delete();

        $toilet->delete();

        return redirect()->route('admin.toilets.accepted')
            ->with('success', 'Toilet deleted successfully.');
    }
    public function showDetails($id)
    {
        // Load toilet with its reviews
        $toilet = Toilet::with('reviews')->findOrFail($id);

        // Calculate average rating safely
        $avgRating = $toilet->reviews->count() > 0
            ? $toilet->reviews->avg('rating')  // Laravel collection avg method
            : null;

        return view('toiletdetails', compact('toilet', 'avgRating'));
    }
    public function acceptedToilets()
    {
        $toilets = Toilet::select(
                'toilets.*',
                DB::raw('COALESCE(AVG(reviews.rating), 0) as avg_rating'),
                DB::raw('COUNT(reviews.id) as review_count')
            )
            ->leftJoin('reviews', 'toilets.id', '=', 'reviews.toilet_id')
            ->where('toilets.status', 'approved')
            ->groupBy('toilets.id')
            ->get();

        return view('alltoilets', compact('toilets'));
    }

    public function showReports(Request $request)
    {
        $query = Report::with(['toilet', 'user']);

        if ($request->filled('search')) {
            $query->whereHas('toilet', function ($q) use ($request) {
                $q->where('name', 'like', $request->search . '%');
            });
        }

        $reports = $query->latest()->paginate(10);

        return view('allreports', compact('reports'));
    }

    public function showReport($id)
    {
        $report = Report::with('toilet', 'user')->findOrFail($id);
        $report->images = $report->images ? json_decode($report->images, true) : [];
        return view('adminreport', compact('report'));
    }
    public function showReviews(Request $request)
    {
        $search = $request->input('search');

        $reviewsQuery = Review::with(['user', 'toilet'])
            ->when($search, function ($query, $search) {
                $query->whereHas('toilet', function ($q) use ($search) {
                    $q->where('name', 'like', $search . '%');
                });
            })
            ->orderBy('toilet_id')
            ->latest();

        $reviews = $reviewsQuery->get()->groupBy('toilet.name');
        return view('allreviews', compact('reviews', 'search'));
    }


    public function showPendingApproval()
    {
        $toilets = Toilet::where('status', 'pending')->get();
        return view('pendingtoilets', compact('toilets'));
    }

    public function approveToilet($id)
    {
        $toilet = Toilet::findOrFail($id);
        $toilet->status = 'approved';
        $toilet->save();

        return redirect()->route('pendingtoilets')->with('success', 'Toilet approved successfully.');
    }
    public function showDashboard()
    {
        return view('admindashboard');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('adminlogin');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('company_email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended(route('admindashboard'));
        }

        return back()->withErrors([
            'company_email' => 'Invalid email or password.',
        ]);
    }
    public function showLogin()
    {
        return view('adminlogin');
    }
    public function __construct()
    {
        $this->middleware('auth:admin')->except([
            'showLogin', 'login', 'logout'
        ]);
    }

}
