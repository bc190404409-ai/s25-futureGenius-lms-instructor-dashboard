<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\Certification;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Instructor;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle email registration (sends OTP for verification). Social signups skip OTP.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=>'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>'instructor',
        ]);

        // create instructor record (pending approval by admin)
        Instructor::create([
            'user_id' => $user->id,
            'is_approved' => false,
        ]);

        // create an OTP and send it to the user for email verification
        $code = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $otp = \App\Models\EmailOtp::create([
            'user_id' => $user->id,
            'code' => $code,
            'expires_at' => now()->addMinutes(15),
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\InstructorOtp($otp));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send OTP email: '. $e->getMessage());
        }

        // Show OTP verification form (do not log in or show pending page until verified)
        return view('auth.verify_otp', ['user' => $user]);
    }
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);

        // Pre-check instructor states before attempting authentication to show helpful messages
        $userByEmail = \App\Models\User::where('email', $request->email)->first();
        if ($userByEmail && $userByEmail->role === 'instructor') {
            $instructor = $userByEmail->instructor;

            // If instructor record is missing or not yet approved, show pending page first
            if (!$instructor || !$instructor->is_approved) {
                return view('auth.instructor_pending');
            }

            if (!$userByEmail->email_verified_at) {
                return back()->with('error', 'Please verify your email before logging in.');
            }

            if ($instructor->is_disabled) {
                return back()->with('error', 'Your account has been disabled. Please contact support.');
            }

            // For instructors, authenticate by checking password and logging in directly
            if (!\Illuminate\Support\Facades\Hash::check($credentials['password'], $userByEmail->password)) {
                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ]);
            }

            Auth::loginUsingId($userByEmail->id);
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        // Non-instructor flows use the normal attempt
        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function dashboard()
    {
        $instructorId = Auth::id();

        $stats = [
            'skills' => Skill::where('instructor_id', $instructorId)->count(),
            'certifications' => Certification::where('instructor_id', $instructorId)->count(),
            'projects' => Project::where('created_by', $instructorId)->count(),
            'availabilities' => Availability::where('instructor_id', $instructorId)->count(),
        ];

        $recentSkills = Skill::where('instructor_id', $instructorId)->latest()->take(5)->get();
        $recentCerts = Certification::where('instructor_id', $instructorId)->latest()->take(5)->get();
        $recentProjects = Project::where('created_by', $instructorId)->latest()->take(5)->get();

        return view('instructor.dashboard', compact('stats', 'recentSkills', 'recentCerts', 'recentProjects'));$user = Auth::user();
    }
}
