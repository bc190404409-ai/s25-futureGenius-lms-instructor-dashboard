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

        // certifications stats
        $certCount = \App\Models\Certification::count();
        $recentCerts = \App\Models\Certification::with('instructor.user')->orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('total', 'approved', 'pending', 'disabled', 'recent', 'certCount', 'recentCerts'));
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

        // Get counts for filter tabs
        $total = Instructor::count();
        $pending = Instructor::where('is_approved', false)->where('is_disabled', false)->count();
        $approved = Instructor::where('is_approved', true)->where('is_disabled', false)->count();
        $disabled = Instructor::where('is_disabled', true)->count();

        return view('admin.instructors.index', compact('instructors', 'status', 'total', 'pending', 'approved', 'disabled'));
    }

    public function showInstructor(Instructor $instructor)
    {
        $instructor->load('user', 'skills', 'certifications', 'availabilities', 'projectEngagements');
        
        return view('admin.instructors.show', compact('instructor'));
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

        // send notification email (queued or send immediately if queue driver is sync)
        try {
            $adminName = Auth::guard('admin')->user()->name ?? null;
            if (config('queue.default') === 'sync') {
                \Illuminate\Support\Facades\Mail::to($instructor->user->email)->send(new \App\Mail\InstructorApproved($instructor, $adminName));
                \Illuminate\Support\Facades\Log::info('Instructor approved email sent immediately', ['instructor' => $instructor->id]);
                $emailNote = ' Email sent.';
            } else {
                \Illuminate\Support\Facades\Mail::to($instructor->user->email)->queue(new \App\Mail\InstructorApproved($instructor, $adminName));
                \Illuminate\Support\Facades\Log::info('Instructor approved email queued', ['instructor' => $instructor->id]);
                $emailNote = ' Email queued to be sent by worker.';
            }
        } catch (\Exception $e) {
            // don't break flow on mail failures; log for debugging
            \Illuminate\Support\Facades\Log::error('Failed to queue/send instructor approved email: ' . $e->getMessage());
            $emailNote = ' Failed to queue/send email.';
        }

        // create a database notification so it shows up in-app
        try {
            $instructor->user->notify(new \App\Notifications\AdminActionNotification($instructor, 'approved', 'Instructor'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to create DB notification for instructor approval: ' . $e->getMessage());
        }

        return back()->with('status', 'Instructor approved.' . ($emailNote ?? ''));
    }

    public function rejectInstructor(Request $request, Instructor $instructor)
    {
        $reason = $request->input('reason');
        $instructor->is_approved = false;
        $instructor->rejected_by = Auth::guard('admin')->id();
        $instructor->rejected_at = now();
        $instructor->rejected_reason = $reason;
        $instructor->is_disabled = true; // rejected accounts disabled
        $instructor->save();

        // send rejection email (queued or send immediately if sync)
        try {
            $adminName = Auth::guard('admin')->user()->name ?? null;
            $reason = $request->input('reason');
            if (config('queue.default') === 'sync') {
                \Illuminate\Support\Facades\Mail::to($instructor->user->email)->send(new \App\Mail\InstructorRejected($instructor, $adminName, $reason));
                \Illuminate\Support\Facades\Log::info('Instructor rejected email sent immediately', ['instructor' => $instructor->id]);
                $emailNote = ' Email sent.';
            } else {
                \Illuminate\Support\Facades\Mail::to($instructor->user->email)->queue(new \App\Mail\InstructorRejected($instructor, $adminName, $reason));
                \Illuminate\Support\Facades\Log::info('Instructor rejected email queued', ['instructor' => $instructor->id]);
                $emailNote = ' Email queued to be sent by worker.';
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to queue/send instructor rejected email: ' . $e->getMessage());
            $emailNote = ' Failed to queue/send email.';
        }

        // create DB notification
        try {
            $instructor->user->notify(new \App\Notifications\AdminActionNotification($instructor, 'rejected', 'Instructor', ['reason' => $reason]));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to create DB notification for instructor rejection: ' . $e->getMessage());
        }

        return back()->with('status', 'Instructor rejected.' . ($emailNote ?? ''));
    }

    public function toggleDisableInstructor(Request $request, Instructor $instructor)
    {
        $instructor->is_disabled = !$instructor->is_disabled;
        $instructor->save();

        $adminName = Auth::guard('admin')->user()->name ?? null;

        // queue or send a status email (send immediately if queue driver is sync)
        try {
            $status = $instructor->is_disabled ? 'disabled' : 'enabled';
            if (config('queue.default') === 'sync') {
                \Illuminate\Support\Facades\Mail::to($instructor->user->email)->send(new \App\Mail\InstructorStatusMail($instructor, $status, $adminName));
                \Illuminate\Support\Facades\Log::info('Instructor status email sent immediately', ['instructor' => $instructor->id, 'status' => $status]);
                $emailNote = ' Email sent.';
            } else {
                \Illuminate\Support\Facades\Mail::to($instructor->user->email)->queue(new \App\Mail\InstructorStatusMail($instructor, $status, $adminName));
                \Illuminate\Support\Facades\Log::info('Instructor status email queued', ['instructor' => $instructor->id, 'status' => $status]);
                $emailNote = ' Email queued to be sent by worker.';
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to queue/send instructor status email: ' . $e->getMessage());
            $emailNote = ' Failed to queue/send email.';
        }

        // create DB notification
        try {
            $status = $instructor->is_disabled ? 'disabled' : 'enabled';
            $instructor->user->notify(new \App\Notifications\AdminActionNotification($instructor, $status, 'Instructor'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to create DB notification for instructor status change: ' . $e->getMessage());
        }

        $msg = $instructor->is_disabled ? 'Instructor disabled' : 'Instructor enabled';
        return back()->with('status', $msg . ($emailNote ?? ''));
    }
}
