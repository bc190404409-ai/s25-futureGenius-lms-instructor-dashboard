<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    // Show available courses
    public function index()
    {
        $courses = Course::all();
        return view('courses.list', compact('courses'));
    }

    // Enroll student
    public function enroll($courseId)
    {
        $userId = Auth::id();

        // Check if already enrolled
        if (Enrollment::where('user_id', $userId)->where('course_id', $courseId)->exists()) {
            return back()->with('error', 'You are already enrolled in this course.');
        }

        Enrollment::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrolled_at' => now(),
        ]);

        return redirect()->route('student.myCourses')->with('success', 'Enrolled successfully!');
    }

    // Student’s enrolled courses
    public function myCourses()
    {
        $courses = Auth::user()->enrolledCourses;
        return view('student.my_courses', compact('courses'));
    }
}
