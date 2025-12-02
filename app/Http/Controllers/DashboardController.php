<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $skillsCount = $user->skills()->count();
        $certificationsCount = $user->certifications()->count();
        $projectsCreated = $user->projectsCreated()->count();
        $projectsJoined = $user->projectEngagements()->count();
        $unreadMessages = $user->messagesReceived()->where('is_read', false)->count();

        return view('instructor.dashboard', compact(
            'user',
            'skillsCount',
            'certificationsCount',
            'projectsCreated',
            'projectsJoined',
            'unreadMessages'
        ));
    }
}
