<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentAnswer extends Model
{
    protected $fillable = [
        'assessment_attempt_id', 'assessment_question_id', 'assessment_option_id',
        'answer_text', 'is_correct', 'marks_obtained'
    ];

    public function attempt()
    {
        return $this->belongsTo(AssessmentAttempt::class, 'assessment_attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(AssessmentQuestion::class, 'assessment_question_id');
    }

    public function option()
    {
        return $this->belongsTo(AssessmentOption::class, 'assessment_option_id');
    }
}
