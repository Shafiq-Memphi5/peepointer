<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ReviewsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\ToiletController;

Route::get('/', function () {
    return view('welcome');
});


// Route for sending an OTP email
Route::post('/send-otp', [OTPController::class, 'sendOtpEmail']);
Route::post('/verify-otp', [OTPController::class, 'verifyOtp']);


// Home route after successful OTP verification
Route::view('/home', 'home')->middleware('auth')->name('home');
Route::view('/login','login')->name('login');
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->middleware('auth')->name('logout');
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->middleware('auth')->name('logout');
Route::get('/verify-otp', [OTPController::class, 'showVerify'])->name('verify.otp');


// Toilet management routes
Route::post('/washadd',[ToiletController::class,'addwash'])->name('washadd');
Route::get('/toilets/nearby', [ToiletController::class, 'nearbyToilets']);


// Navigation routes
Route::get('/toilets/nearby', [ToiletController::class, 'nearbyToilets']);
Route::get('/direction/{id}', [ToiletController::class, 'showDirections'])->name('toilet.direction');



Route::get('/settings', function () {
    if (!auth()->check())
    {
        return redirect('home');
    }
    return view('settings');
})->name('settings');

Route::get('/washadd',[ToiletController::class,'showAddWash'])->name('washadd');
Route::get('/addreview', [ReviewsController::class, 'showAddReview'])->name('toiletreview');

// Reivew routes
Route::post('/toilet/{id}/addreview', [ReviewsController::class, 'addReview'])->name('addreviews');
Route::get('/toilet/{id}/review', [ReviewsController::class, 'showAddReview']);
Route::get('/toilet/{id}/reviews', [ReviewsController::class, 'showReviews'])->name('toilet.reviews');

//Report routes
Route::get('/toilet/{id}/report', [ReportsController::class, 'showReport']);
Route::post('/toilet/{id}/addreport', [ReportsController::class, 'addReport']);;




// Admin routes
// Public Admin Routes (no auth required)
Route::get('/adminlogin', [AdminController::class, 'showLogin'])->name('adminlogin');
Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Protected Admin Routes (requires admin auth)
Route::middleware('auth:admin')->group(function () {
    Route::get('/admindashboard', [AdminController::class, 'showDashboard'])->name('admindashboard');
    Route::get('/admin/analytics', [AdminController::class, 'showAnalytics'])->name('analytics');

    // User Management
    Route::get('/admin/users', [AdminController::class, 'showUsers'])->name('allusers');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');

    // Toilet Management
    Route::get('/pendingtoilets', [AdminController::class, 'showPendingApproval'])->name('pendingtoilets');
    Route::post('/admin/toilets/{id}/approve', [AdminController::class, 'approveToilet'])->name('admin.toilets.approve');
    Route::delete('/admin/toilets/{id}', [AdminController::class, 'deleteToilet'])->name('admin.toilets.delete');
    Route::get('/admin/toilets/accepted', [AdminController::class, 'acceptedToilets'])->name('admin.toilets.accepted');
    Route::get('/admin/toilets/{id}', [AdminController::class, 'showDetails'])->name('admin.toilets.show');

    // Report Management
    Route::get('/allreports', [AdminController::class, 'showReports'])->name('allreports');
    Route::get('/admin/reports/{id}', [AdminController::class, 'showReport'])->name('adminreport');
    Route::delete('/admin/reports/{id}', [AdminController::class, 'deleteReport'])->name('admin.reports.delete');

    // Review Management
    Route::get('/allreviews', [AdminController::class, 'showReviews'])->name('allreviews');
});

