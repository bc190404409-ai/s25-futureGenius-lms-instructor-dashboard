<?php

namespace App\Http\Controllers;

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

    public function approveCertification(Certification $cert)
    {
        $cert->status = 'approved';
        $cert->save();

        $cert->instructor->user->notify(new AdminActionNotification($cert, 'approved', 'Certification'));

        try {
            Mail::to($cert->instructor->user->email)->queue(new \App\Mail\AdminActionMail($cert, 'approved', 'Certification'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to queue email for certification approval: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Certification approved and notification sent.');
    }

    public function rejectCertification(Certification $cert)
    {
        $cert->status = 'rejected';
        $cert->save();

        $cert->instructor->user->notify(new AdminActionNotification($cert, 'rejected', 'Certification'));

        try {
            Mail::to($cert->instructor->user->email)->queue(new \App\Mail\AdminActionMail($cert, 'rejected', 'Certification'));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to queue email for certification rejection: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Certification rejected and notification sent.');
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
