<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use App\Models\AssessmentAnswer;
use App\Models\AssessmentOption;
use Illuminate\Http\Request;

class AssessmentAttemptController extends Controller
{
    public function start($assessmentId)
    {
        $assessment = Assessment::with('questions.options')->findOrFail($assessmentId);

        $attempt = AssessmentAttempt::create([
            'assessment_id' => $assessmentId,
            'student_id' => auth()->id(),
            'started_at' => now(),
        ]);

        return view('assessment.quiz.start', compact('assessment', 'attempt'));
    }

    public function submit(Request $request, $attemptId)
    {
        $attempt = AssessmentAttempt::findOrFail($attemptId);
        $assessment = $attempt->assessment;

        $totalScore = 0;

        foreach ($request->answers as $questionId => $optionId) {

            $option = AssessmentOption::find($optionId);

            AssessmentAnswer::create([
                'assessment_attempt_id' => $attemptId,
                'assessment_question_id' => $questionId,
                'assessment_option_id' => $optionId,
                'is_correct' => $option->is_correct,
                'marks_obtained' => $option->is_correct ? $option->question->marks : 0
            ]);

            if ($option->is_correct) {
                $totalScore += $option->question->marks;
            }
        }

        $attempt->update([
            'completed_at' => now(),
            'total_marks' => $totalScore
        ]);

        return redirect()->route('quiz.result', $attemptId)->with('success', 'Quiz submitted');
    }
}
