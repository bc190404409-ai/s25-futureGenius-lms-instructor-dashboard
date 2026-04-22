<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Skill;
use App\Models\Certification;
use App\Models\Project;
use App\Notifications\AdminActionNotification;

class AdminApprovalController extends Controller
{
    public function approveSkill(Skill $skill)
    {
        $skill->status = 'approved';
        $skill->save();

        $skill->instructor->user->notify(new AdminActionNotification($skill, 'approved', 'Skill'));

        try {
            Mail::to($skill->instructor->user->email)->queue(new \App\Mail\AdminActionMail($skill, 'approved', 'Skill'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to queue email for skill approval: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Skill approved and notification sent.');
    }

    public function rejectSkill(Skill $skill)
    {
        $skill->status = 'rejected';
        $skill->save();

        $skill->instructor->user->notify(new AdminActionNotification($skill, 'rejected', 'Skill'));

        try {
            Mail::to($skill->instructor->user->email)->queue(new \App\Mail\AdminActionMail($skill, 'rejected', 'Skill'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to queue email for skill rejection: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Skill rejected and notification sent.');
    }

    // Show a single certification for admin review
    public function showCertification(Certification $cert)
    {
        $cert->load('instructor.user');
        return view('admin.approvals.show', compact('cert'));
    }

    public function approveCertification(Certification $cert)
    {
        $cert->status = 'approved';
        $cert->save();

        $cert->instructor->user->notify(new AdminActionNotification($cert, 'approved', 'Certification'));

        try {
            $mailable = new \App\Mail\AdminActionMail($cert, 'approved', 'Certification');
            if (config('queue.default') === 'sync') {
                Mail::to($cert->instructor->user->email)->send($mailable);
            } else {
                Mail::to($cert->instructor->user->email)->queue($mailable);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send/queue email for certification approval: ' . $e->getMessage());
        }

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Certification approved and notification sent.',
                'status' => 'approved',
                'cert_id' => $cert->id,
            ]);
        }

        return redirect()->route('admin.approvals.certifications')->with('success', 'Certification approved and notification sent.');
    }

    public function rejectCertification(Request $request, Certification $cert)
    {
        $reason = $request->input('reason');
        $cert->status = 'rejected';
        $cert->rejected_reason = $reason;
        $cert->save();

        $cert->instructor->user->notify(new AdminActionNotification($cert, 'rejected', 'Certification', ['reason' => $reason]));

        try {
            $mailable = new \App\Mail\AdminActionMail($cert, 'rejected', 'Certification');
            if (config('queue.default') === 'sync') {
                Mail::to($cert->instructor->user->email)->send($mailable);
            } else {
                Mail::to($cert->instructor->user->email)->queue($mailable);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send/queue email for certification rejection: ' . $e->getMessage());
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Certification rejected and notification sent.',
                'status' => 'rejected',
                'cert_id' => $cert->id,
            ]);
        }

        return redirect()->route('admin.approvals.certifications')->with('success', 'Certification rejected and notification sent.');
    }

    // List certifications for admin approvals
    public function certificationsIndex(Request $request)
    {
        $q = trim($request->query('q', ''));
        $query = Certification::with('instructor.user')->latest();

        if ($q !== '') {
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")->orWhere('issuer', 'like', "%{$q}%")->orWhereHas('instructor.user', function($uq) use ($q) {
                    $uq->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
                });
            });
        }

        $certs = $query->paginate(20)->withQueryString();
        return view('admin.approvals.certifications', compact('certs'));
    }

    public function approveProject(Project $project)
    {
        $project->status = 'approved';
        $project->save();

        $project->creator->notify(new AdminActionNotification($project, 'approved', 'Project'));

        try {
            Mail::to($project->creator->email)->queue(new \App\Mail\AdminActionMail($project, 'approved', 'Project'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to queue email for project approval: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Project approved and notification sent.');
    }

    public function rejectProject(Project $project)
    {
        $project->status = 'rejected';
        $project->save();

        $project->creator->notify(new AdminActionNotification($project, 'rejected', 'Project'));

        try {
            Mail::to($project->creator->email)->queue(new \App\Mail\AdminActionMail($project, 'rejected', 'Project'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to queue email for project rejection: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Project rejected and notification sent.');
    }
}
