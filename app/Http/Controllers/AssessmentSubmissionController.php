<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentSubmission;
use App\Models\SubmittedAnswer;

class AssessmentSubmissionController extends Controller
{
    public function index()
    {
        $submissions = AssessmentSubmission::with(['assessment', 'student'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('instructor.assessments.submissions.index', compact('submissions'));
    }
    public function show($submissionId)
    {
        $submission = AssessmentSubmission::with(['assessment', 'student', 'submittedAnswers'])
            ->findOrFail($submissionId);

        return view('instructor.assessments.submissions.show', compact('submission'));
    }
    public function submit(Request $request, $assessmentId)
    {
        $assessment = Assessment::with('questions')->findOrFail($assessmentId);
        if (in_array($assessment->type, ['assignment', 'lab'])) {
            $request->validate([
                'file' => 'required|file',
                'description' => 'nullable|string',
            ]);

            $filePath = $request->file('file')->store('assessments', 'public');

            AssessmentSubmission::create([
                'assessment_id' => $assessment->id,
                'student_id' => Auth::id(),
                'file_path' => $filePath,
                'description' => $request->description,
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            return back()->with('success', 'Assignment submitted successfully!');
        }
        $request->validate([
            'answers' => 'required|array',
        ]);

        $submission = AssessmentSubmission::create([
            'assessment_id' => $assessment->id,
            'student_id' => Auth::id(),
            'obtained_marks' => 0, 
            'status' => 'graded',
            'submitted_at' => now(),
            'graded_at' => now(),
        ]);

        $totalObtained = 0;

        foreach ($assessment->questions as $question) {
            $answerValue = $request->input('answers.' . $question->id, null);

            $isCorrect = false;
            if (in_array($question->type, ['mcq', 'true_false'])) {
                $isCorrect = ($answerValue == $question->correct_answer);
            }

            $marksObtained = $isCorrect ? $question->marks : 0;
            $totalObtained += $marksObtained;

            SubmittedAnswer::create([
                'submission_id' => $submission->id,
                'question_id' => $question->id,
                'answer' => $answerValue,
                'is_correct' => $isCorrect,
                'marks_obtained' => $marksObtained,
            ]);
        }
        $submission->update([
            'obtained_marks' => $totalObtained,
            'percentage' => ($totalObtained / $assessment->total_marks) * 100,
            'letter_grade' => $this->getLetterGrade(($totalObtained / $assessment->total_marks) * 100),
        ]);

        return redirect()->route('student.assessments.index')
            ->with('success', 'Assessment submitted successfully! Your grade: ' . $submission->letter_grade);
    }
    public function grade(Request $request, $submissionId)
    {
        $submission = AssessmentSubmission::with('assessment')->findOrFail($submissionId);
        $assessment = $submission->assessment;

        if (!in_array($assessment->type, ['assignment', 'lab'])) {
            return back()->with('error', 'Only assignments/labs can be graded manually.');
        }

        $request->validate([
            'marks_obtained' => 'required|numeric|min:0',
        ]);

        $marksObtained = $request->marks_obtained;
        $totalMarks = $assessment->total_marks;
        $percentage = ($marksObtained / $totalMarks) * 100;

        $submission->update([
            'marks_obtained' => $marksObtained,
            'percentage' => $percentage,
            'letter_grade' => $this->getLetterGrade($percentage),
            'status' => 'graded',
            'graded_at' => now(),
        ]);

        return back()->with('success', 'Assignment graded successfully!');
    }
    public function mySubmissions()
    {
        $submissions = AssessmentSubmission::with('assessment')
            ->where('student_id', Auth::id())
            ->orderBy('graded_at', 'desc')
            ->get();

        return view('student.assessments.index', compact('submissions'));
    }
    private function getLetterGrade($percentage)
    {
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'F';
    }
}
