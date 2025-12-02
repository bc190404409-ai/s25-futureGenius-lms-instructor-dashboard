<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use App\Models\Certification;
use App\Models\Project;
use App\Models\Availability;
use Illuminate\Support\Facades\Auth;

class InstructorDashboardController extends Controller
{
    public function index()
    {
        dd('adkjgakdfad dasl asdfasd');
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

        return view('instructor.dashboard', compact('stats', 'recentSkills', 'recentCerts', 'recentProjects'));
    }
}
