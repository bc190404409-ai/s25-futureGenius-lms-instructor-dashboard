<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    // List all projects created by the instructor
    public function index()
    {
        $projects = Auth::user()->projectsCreated()->latest()->get();
        return view('instructor.projects.index', compact('projects'));
    }

    // Show form to create project
    public function create()
    {
        return view('instructor.projects.create');
    }

    // Store new project
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'media' => 'nullable|file|mimes:jpg,png,mp4,pdf|max:5120',
        ]);

        $mediaPath = $request->file('media') ? $request->file('media')->store('projects', 'public') : null;

        Auth::user()->projectsCreated()->create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
            'media' => $mediaPath,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project added successfully.');
    }

    // Show edit form
    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('instructor.projects.edit', compact('project'));
    }

    // Update project
    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'media' => 'nullable|file|mimes:jpg,png,mp4,pdf|max:5120',
        ]);

        if ($request->hasFile('media')) {
            if ($project->media && Storage::disk('public')->exists($project->media)) {
                Storage::disk('public')->delete($project->media);
            }
            $project->media = $request->file('media')->store('projects', 'public');
        }

        $project->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    // Delete project
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        if ($project->media && Storage::disk('public')->exists($project->media)) {
            Storage::disk('public')->delete($project->media);
        }

        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
