<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MobileOTPController;
use App\Http\Controllers\Api\MobileToiletController;
use App\Http\Controllers\Api\MobileReviewController;
use App\Http\Controllers\Api\MobileReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider within a group
| assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes (no auth)
Route::post('/send-otp', [MobileOTPController::class, 'sendOtpEmail']);
Route::post('/verify-otp', [MobileOTPController::class, 'verifyOtp']);

// Toilets - public
Route::get('/toilets/nearby', [MobileToiletController::class, 'nearbyToilets']);
Route::get('/toilets/{id}/directions', [MobileToiletController::class, 'showDirections']); // Consider protecting this if sensitive

// Reviews - public read
Route::get('/toilets/{id}/reviews', [MobileReviewController::class, 'showReviews']);

// Routes requiring authenticated user
Route::middleware('auth:sanctum')->group(function () {
    
    // Toilet management
    Route::post('/toilets/add', [MobileToiletController::class, 'addwash']);

    // Reviews management
    Route::post('/toilets/{id}/reviews', [MobileReviewController::class, 'addReview']);

    // Reports management
    Route::get('/toilets/{id}/report', [MobileReportController::class, 'showReport']);
    Route::post('/toilets/{id}/report', [MobileReportController::class, 'addReport']);
});
