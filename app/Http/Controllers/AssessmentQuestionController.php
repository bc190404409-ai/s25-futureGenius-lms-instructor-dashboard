<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentOption;
use Illuminate\Http\Request;

class AssessmentQuestionController extends Controller
{
    public function create($assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);
        return view('assessment.questions.create', compact('assessment'));
    }

    public function store(Request $request, $assessmentId)
    {
        $assessment = Assessment::findOrFail($assessmentId);

        foreach ($request->questions as $q) {

            $question = AssessmentQuestion::create([
                'assessment_id' => $assessmentId,
                'question_text' => $q['text'],
                'marks' => $q['marks'],
                'type' => $assessment->type === 'true_false' ? 'boolean' : 'mcq',
            ]);
            if (isset($q['options'])) {
                foreach ($q['options'] as $opt) {
                    AssessmentOption::create([
                        'assessment_question_id' => $question->id,
                        'option_text' => $opt['text'],
                        'is_correct' => isset($opt['is_correct']),
                    ]);
                }
            }
        }

        return redirect()->route('assessment.view', $assessmentId)
            ->with('success', 'Questions added successfully');
    }
}
