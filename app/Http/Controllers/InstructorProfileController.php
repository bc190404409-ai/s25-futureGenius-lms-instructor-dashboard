<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class InstructorProfileController extends Controller
{
    public function show()
    {
        $instructor = Auth::user();
        return view('instructor.profile', compact('instructor'));
    }

    public function edit()
    {
        $instructor = Auth::user();
        return view('instructor.edit-profile', compact('instructor'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'linkedin_url' => 'nullable|url|max:255',
            'bio' => 'nullable|string|max:1000',
            'portfolio_url' => 'nullable|url|max:255',
            'profile_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'cv_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'intro_video' => 'nullable|file|mimes:mp4,mov,avi|max:51200',
            'portfolio_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        // Handle file uploads
        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }
        if ($request->hasFile('cv_file')) {
            $validated['cv_file'] = $request->file('cv_file')->store('cv_files', 'public');
        }
        if ($request->hasFile('intro_video')) {
            $validated['intro_video'] = $request->file('intro_video')->store('intro_videos', 'public');
        }
        if ($request->hasFile('portfolio_file')) {
            $validated['portfolio_file'] = $request->file('portfolio_file')->store('portfolio_files', 'public');
        }
        

        $user->update($validated);

        return redirect()->route('instructor.profile')->with('success', 'Profile updated successfully.');
    }
}
