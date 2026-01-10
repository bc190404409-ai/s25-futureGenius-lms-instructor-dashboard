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
    /**
     * Redirect user to social provider
     */
    public function redirect(string $provider)
    {
        if (!in_array($provider, ['google'])) {
            abort(404);
        }

        return Socialite::driver($provider)
            ->stateless()
            ->redirectUrl(config('services.google.redirect'))
            ->redirect();
    }

    /**
     * Handle provider callback
     */
    public function callback(string $provider)
    {
        if (!in_array($provider, ['google'])) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)
                ->stateless()
                ->redirectUrl(config('services.google.redirect'))
                ->user();
        } catch (\Throwable $e) {
            Log::error('Social login failed', [
                'provider' => $provider,
                'message' => $e->getMessage(),
            ]);

            return redirect()
                ->route('login.form')
                ->with('error', 'Social login failed. Please try again.');
        }

        // Google MUST return email
        if (!$socialUser->getEmail()) {
            return redirect()
                ->route('login.form')
                ->with('error', 'Your Google account has no email.');
        }

        // 1️⃣ Find user by provider
        $user = User::where('provider', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        // 2️⃣ Fallback: find by email
        if (!$user) {
            $user = User::where('email', $socialUser->getEmail())->first();
        }

        // 3️⃣ Attach provider if missing
        if ($user && (!$user->provider || !$user->provider_id)) {
            $user->update([
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
            ]);
        }

        // 4️⃣ Create new instructor (pending approval)
        if (!$user) {
            $user = User::create([
                'name' => $socialUser->getName() ?? $socialUser->getEmail(),
                'email' => $socialUser->getEmail(),
                'password' => bcrypt(Str::random(32)),
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

        // 5️⃣ Ensure instructor role
        if ($user->role !== 'instructor') {
            abort(403, 'Unauthorized role');
        }

        // 6️⃣ Approval check
        if (!$user->instructor || !$user->instructor->is_approved) {
            return view('auth.instructor_pending');
        }

        // 7️⃣ Login approved instructor
        Auth::login($user, true);

        return redirect()->route('dashboard');
    }
}
