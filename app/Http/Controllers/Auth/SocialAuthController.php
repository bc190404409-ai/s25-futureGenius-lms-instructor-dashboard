<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function callback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        // require email from provider to create an account
        if (!$socialUser->getEmail()) {
            return redirect()->route('login.form')->with('error', 'No email provided by the provider. Please sign up with email.');
        }

        // try find by provider id first
        $user = User::where('provider', $provider)->where('provider_id', $socialUser->getId())->first();

        // fallback to email
        if (!$user && $socialUser->getEmail()) {
            $user = User::where('email', $socialUser->getEmail())->first();
        }

        if ($user && (!$user->provider || !$user->provider_id)) {
            // attach provider info for future logins
            $user->provider = $provider;
            $user->provider_id = $socialUser->getId();
            $user->save();
        }

        if (!$user) {
            // create a new user and pending instructor
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? $socialUser->getEmail(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(16)),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'role' => 'instructor',
            ]);

            Instructor::create([
                'user_id' => $user->id,
                'is_approved' => false,
            ]);

            return view('auth.instructor_pending');
        }

        // ensure user is an instructor
        if ($user->role !== 'instructor') {
            abort(403, 'Only instructors may sign in here');
        }

        $instructor = $user->instructor;

        if (!$instructor || !$instructor->is_approved) {
            return view('auth.instructor_pending');
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
