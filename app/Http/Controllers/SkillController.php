<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Skill;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    use AuthorizesRequests;
    // List all skills for the logged-in instructor
    public function index()
    {
        $skills = Auth::user()->skills()->latest()->get();
        return view('instructor.skills.index', compact('skills'));
    }

    // Show form to create a new skill
    public function create()
    {
        return view('instructor.skills.create');
    }

    // Store new skill
    public function store(Request $request)
    {
        $request->validate([
            'skill_name' => 'required|string|max:255',
            'skill_type' => 'required|in:technical,soft,other',
            'video_link' => 'nullable|url',
            'status' => 'nullable|in:pending,approval',
        ]);

        $status = 'pending';

        if ($request->has('status')) {
            if ($request->status === 'approval') {
                $status = 'approval';
            } else {
                $status = 'pending';
            }
        }

        Skill::create([
            'instructor_id' => Auth::id(),
            'skill_name' => $request->skill_name,
            'skill_type' => $request->skill_type,
            'video_link' => $request->video_link,
            'status' => $status,
        ]);

        return redirect()->route('skills.index')->with('success', 'Skill added successfully.');
    }

    // Show form to edit a skill
    public function edit(Skill $skill)
    {
        if ($skill->instructor_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('instructor.skills.edit', compact('skill'));
    }

    // Update skill
    public function update(Request $request, Skill $skill)
    {
        if ($skill->instructor_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'skill_name' => 'required|string|max:255',
            'skill_type' => 'required|in:technical,soft,other',
            'video_link' => 'nullable|url',
            'status' => 'required|in:pending,approved',
        ]);

        $skill->update([
            'skill_name' => $validated['skill_name'],
            'skill_type' => $validated['skill_type'],
            'video_link' => $validated['video_link'] ?? null,
            'status' => $validated['status']
        ]);

        return redirect()->route('skills.index')->with('success', 'Skill updated successfully.');
    }

    // Delete skill
    public function destroy(Skill $skill)
    {
        if ($skill->instructor_id != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $skill->delete();

        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully.');
    }
}
