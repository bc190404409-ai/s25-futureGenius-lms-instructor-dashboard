<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailOtp;
use App\Models\User;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function verify(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'code' => 'required|string',
        ]);

        $user = User::find($request->user_id);
        $otp = EmailOtp::where('user_id', $user->id)
            ->where('code', $request->code)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp) {
            return back()->with('error', 'Invalid or expired code.');
        }

        $otp->used = true;
        $otp->save();

        $user->email_verified_at = now();
        $user->save();

        // show pending approval page
        return view('auth.instructor_pending');
    }

    public function resend(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);

        // Only for instructor role
        if ($user->role !== 'instructor') {
            return back()->with('error', 'Invalid request');
        }

        // Enforce per-user cooldown: disallow sending if last OTP was created less than 60 seconds ago
        $lastOtp = EmailOtp::where('user_id', $user->id)->latest()->first();
        if ($lastOtp && $lastOtp->created_at->gt(now()->subSeconds(60))) {
            return back()->with('error', 'Please wait a moment before requesting a new code.');
        }

        // create OTP and send
        $code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $otp = EmailOtp::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(15),
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\InstructorOtp($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send OTP email on resend: '. $e->getMessage());
            return back()->with('error', 'Failed to send code, try again later.');
        }

        return back()->with('success', 'Verification code resent.');
    }
}
