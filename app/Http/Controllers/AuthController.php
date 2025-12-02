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
        Instructor::create(['user_id'=>$user->id]);

        Auth::login($user);

        return redirect()->route('dashboard');
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

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
        return back()->withErrors([
            'email'=>'The provided credentials do not match our records.',
        ]);
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
