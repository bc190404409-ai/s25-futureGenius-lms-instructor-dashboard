<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        return redirect()->back()->with('success', 'Skill approved and notification sent.');
    }

    public function rejectSkill(Skill $skill)
    {
        $skill->status = 'rejected';
        $skill->save();

        $skill->instructor->user->notify(new AdminActionNotification($skill, 'rejected', 'Skill'));

        return redirect()->back()->with('success', 'Skill rejected and notification sent.');
    }

    public function approveCertification(Certification $cert)
    {
        $cert->status = 'approved';
        $cert->save();

        $cert->instructor->user->notify(new AdminActionNotification($cert, 'approved', 'Certification'));

        return redirect()->back()->with('success', 'Certification approved and notification sent.');
    }

    public function rejectCertification(Certification $cert)
    {
        $cert->status = 'rejected';
        $cert->save();

        $cert->instructor->user->notify(new AdminActionNotification($cert, 'rejected', 'Certification'));

        return redirect()->back()->with('success', 'Certification rejected and notification sent.');
    }

    public function approveProject(Project $project)
    {
        $project->status = 'approved';
        $project->save();

        $project->creator->notify(new AdminActionNotification($project, 'approved', 'Project'));

        return redirect()->back()->with('success', 'Project approved and notification sent.');
    }

    public function rejectProject(Project $project)
    {
        $project->status = 'rejected';
        $project->save();

        $project->creator->notify(new AdminActionNotification($project, 'rejected', 'Project'));

        return redirect()->back()->with('success', 'Project rejected and notification sent.');
    }
}
