<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class OTPController extends Controller
{
    public function showVerify(Request $request)
    {
        if (!session()->has('email')) {
            return redirect('/');
        }

        return view('verify', ['email' => session('email')]);
    }
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $email = $request->input('email');

        $user = User::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('otp_expires_at', '>=', now())
            ->first();

        if (!$user) {
            return back()->withErrors(['otp' => 'Invalid OTP'])->with('email', $email);
        }

        if (now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'OTP has expired'])->with('email', $email);
        }

        // Clear OTP after successful verification
        $user->update([
            'otp' => null,
            'otp_expires_at' => null
        ]);

        Auth::login($user);

        return redirect('/home')->with('message', 'OTP verified successfully!');
    }
    public function sendOtpEmail(Request $request)
    {
        // validate the request
        $request->validate([
            'email' => 'required|email',
        ]);

        // otp generation
        $email = $request->input('email');
        $otp = rand(100000, 999999);

        // create / update user
        User::updateOrCreate(
            ['email' => $email],
            [
                'otp' => $otp,
                'otp_expires_at' => Carbon::now()->addSeconds(60),
            ]
        );

        //logs
        $user = User::where('email', $email)->first();
        \Log::info('Saved OTP: ' . $user->otp);
        \Log::info('OTP Expires At: ' . $user->otp_expires_at);
        \Log::info('Now: ' . now());

        // store email in session
        $request->session()->put('email', $email);
        //session(['otp_email' => $email]);

        // send otp email
        Mail::to($email)->send(new OtpMail($otp));
        // return response
        return redirect()->route('verify.otp')->with([
            'message' => 'OTP sent successfully!',
            'email' => $email,
            'otp' => $otp,
        ]);
    }
}
