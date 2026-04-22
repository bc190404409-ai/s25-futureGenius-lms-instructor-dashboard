<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $table = config('auth.passwords.users.table');
        $throttleSeconds = config('auth.passwords.users.throttle', 60);

        // Server-side suppression: if a recent token exists, avoid creating/sending a new one
        try {
            $recent = \Illuminate\Support\Facades\DB::table($table)
                ->where('email', $request->email)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($recent) {
                $secondsSince = \Illuminate\Support\Carbon::now()->diffInSeconds(\Illuminate\Support\Carbon::parse($recent->created_at));
                if ($secondsSince < $throttleSeconds) {
                    $remaining = $throttleSeconds - $secondsSince;
                    return back()->with('status', 'A reset link was recently sent. Please check your email or try again in ' . $remaining . ' seconds.')->with('reset_remaining', $remaining);
                }
            }
        } catch (\Exception $e) {
            // If DB check fails for any reason, proceed to attempt sending to avoid blocking valid requests
        }

        $status = Password::sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status))->with('reset_remaining', $throttleSeconds);
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status == Password::PASSWORD_RESET) {
            return redirect()->route('login.form')->with('status', __($status));
        }

        return back()->withErrors(['email' => [__($status)]]);
    }
}
