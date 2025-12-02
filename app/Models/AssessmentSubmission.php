<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentSubmission extends Model
{
    protected $fillable = [
        'assessment_id',
        'student_id',
        'file_path',         // file path for uploaded assignment
        'description',
        'marks_obtained',    // grade entered by instructor or auto
        'percentage',        // optional, if you want to store %
        'letter_grade',      // optional, if you want to store letter grade
        'status',            // submitted / graded
        'submitted_at',
        'graded_at'
    ];

    // AssessmentSubmission belongs to Assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    // AssessmentSubmission belongs to Student (User model)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Optional: If you want to get answers for quizzes/labs
    public function submittedAnswers()
    {
        return $this->hasMany(SubmittedAnswer::class, 'submission_id');
    }
}
