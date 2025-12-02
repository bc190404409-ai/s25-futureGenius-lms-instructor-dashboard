<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // List all courses
    public function index()
    {
        $courses = Course::latest()->paginate(10);
        return view('courses.index', compact('courses'));
    }

    // Show create course form
    public function create()
    {
        return view('courses.create');
    }

    // Store course
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'status' => 'required|in:pending,published,archived',
        ]);
        $validated['instructor_id'] = Auth::id();

        Course::create($validated);
        return redirect()->route('instructor.courses.index')->with('success', 'Course created successfully.');
    }

    // Show edit form
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    // Update course
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'status' => 'required|in:pending,published,archived',
        ]);

        $course->update($validated);

        return redirect()->route('instructor.courses.index')->with('success', 'Course updated successfully.');
    }

    // Delete course
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('instructor.courses.index')->with('success', 'Course deleted successfully.');
    }
}
