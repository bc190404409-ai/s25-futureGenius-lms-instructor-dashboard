<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login.form');
    }

    public function dashboard()
    {
        // stats for dashboard
        $total = Instructor::count();
        $approved = Instructor::where('is_approved', true)->count();
        $pending = Instructor::where('is_approved', false)->where('is_disabled', false)->count();
        $disabled = Instructor::where('is_disabled', true)->count();

        $recent = Instructor::with('user')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('total', 'approved', 'pending', 'disabled', 'recent'));
    }

    public function instructors(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Instructor::with('user')->orderBy('created_at', 'desc');

        if ($status === 'pending') {
            $query->where('is_approved', false)->where('is_disabled', false);
        }

        if ($status === 'approved') {
            $query->where('is_approved', true)->where('is_disabled', false);
        }

        if ($status === 'disabled') {
            $query->where('is_disabled', true);
        }

        $instructors = $query->paginate(20)->withQueryString();

        return view('admin.instructors.index', compact('instructors', 'status'));
    }

    public function approveInstructor(Request $request, Instructor $instructor)
    {
        $instructor->is_approved = true;
        $instructor->approved_by = Auth::guard('admin')->id();
        $instructor->approved_at = now();
        // clear prior rejection if any
        $instructor->rejected_by = null;
        $instructor->rejected_at = null;
        $instructor->is_disabled = false;
        $instructor->save();

        // send notification email
        try {
            \Illuminate\Support\Facades\Mail::to($instructor->user->email)->send(new \App\Mail\InstructorApproved($instructor));
        } catch (\Exception $e) {
            // don't break flow on mail failures; log for debugging
            \Illuminate\Support\Facades\Log::error('Failed to send instructor approved email: ' . $e->getMessage());
        }

        return back()->with('status', 'Instructor approved');
    }

    public function rejectInstructor(Request $request, Instructor $instructor)
    {
        $instructor->is_approved = false;
        $instructor->rejected_by = Auth::guard('admin')->id();
        $instructor->rejected_at = now();
        $instructor->is_disabled = true; // rejected accounts disabled
        $instructor->save();

        // send rejection email
        try {
            \Illuminate\Support\Facades\Mail::to($instructor->user->email)->send(new \App\Mail\InstructorRejected($instructor));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send instructor rejected email: ' . $e->getMessage());
        }

        return back()->with('status', 'Instructor rejected');
    }

    public function toggleDisableInstructor(Request $request, Instructor $instructor)
    {
        $instructor->is_disabled = !$instructor->is_disabled;
        $instructor->save();

        $msg = $instructor->is_disabled ? 'Instructor disabled' : 'Instructor enabled';
        return back()->with('status', $msg);
    }
}
