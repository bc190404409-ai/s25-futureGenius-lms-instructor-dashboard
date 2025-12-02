<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class InstructorPublicProfileController extends Controller
{
    public function show($id)
    {
        $instructor = User::where('role', 'instructor')
            ->with(['skills', 'certifications', 'projectsCreated'])
            ->findOrFail($id);

        return view('instructor.public_profile', compact('instructor'));
    }
}
