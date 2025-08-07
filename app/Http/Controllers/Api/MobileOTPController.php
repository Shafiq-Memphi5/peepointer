<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MobileOTPController extends Controller
{
    // (We won’t need showVerify because mobile apps handle UI)

    // Verify OTP - returns JSON
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $email = $request->input('email');

        $user = User::where('email', $email)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>=', now())
            ->first();

        if (!$user) {
            return response()->json(['error' => 'Invalid OTP'], 422);
        }

        if (now()->gt($user->otp_expires_at)) {
            return response()->json(['error' => 'OTP has expired'], 422);
        }

        // Clear OTP after successful verification
        $user->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);

        // Log in the user and create token for API auth
        // Assuming you use Sanctum:
        $token = $user->createToken('mobile-token')->plainTextToken;

        return response()->json([
            'message' => 'OTP verified successfully!',
            'token' => $token,
            'user' => $user,
        ]);
    }

    // Send OTP email - returns JSON
    public function sendOtpEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->input('email');
        $otp = rand(100000, 999999);

        User::updateOrCreate(
            ['email' => $email],
            [
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addMinutes(5), // Longer expiry recommended
            ]
        );

        // Logging for debug
        \Log::info('Saved OTP: ' . $otp);
        \Log::info('OTP Expires At: ' . now()->addMinutes(5));

        // Send email
        Mail::to($email)->send(new OtpMail($otp));

        return response()->json([
            'message' => 'OTP sent successfully!',
            'email' => $email,
        ]);
    }
}
