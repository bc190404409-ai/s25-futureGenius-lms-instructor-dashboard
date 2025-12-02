<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    public function index()
    {
        $assessments = Assessment::whereHas('course', function ($q) {
            $q->where('instructor_id', Auth::id());
        })->latest()->get();

        return view('instructor.assessments.index', compact('assessments'));
    }
    public function selectType()
    {
        $courses = Course::where('instructor_id', Auth::id())->get();
        return view('instructor.assessments.select_type', compact('courses'));
    }
    public function createForm($type, Request $request)
    {
        $courses = Course::where('instructor_id', Auth::id())->get();

        if (!in_array($type, ['quiz', 'assignment', 'lab', 'true_false'])) {
            return redirect()->route('instructor.assessments.create')
                ->with('error', 'Invalid assessment type selected.');
        }

        $questions_count = $request->query('questions_count', 0);

        return view("instructor.assessments.create_{$type}", compact('courses', 'type', 'questions_count'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:quiz,assignment,lab,true_false',
            'total_marks' => 'required|integer|min:0',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
            'questions_count' => 'nullable|integer|min:1',
        ]);

        Assessment::create($request->all());

        return redirect()->route('instructor.assessments.index')
            ->with('success', 'Assessment created successfully!');
    }

    public function edit(Assessment $assessment)
    {
        $this->authorize('update', $assessment);
        $courses = Course::where('instructor_id', Auth::id())->get();
        return view('instructor.assessments.edit', compact('assessment', 'courses'));
    }

    public function update(Request $request, Assessment $assessment)
    {
        $this->authorize('update', $assessment);

        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'type' => 'required|in:quiz,assignment,lab,true_false',
            'total_marks' => 'required|integer|min:0',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $assessment->update($request->all());

        return redirect()->route('instructor.assessments.index')
            ->with('success', 'Assessment updated successfully!');
    }

    public function destroy(Assessment $assessment)
    {
        $this->authorize('delete', $assessment);
        $assessment->delete();
        return redirect()->route('instructor.assessments.index')
            ->with('success', 'Assessment deleted successfully!');
    }
}
