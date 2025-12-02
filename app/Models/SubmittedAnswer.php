<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubmittedAnswer extends Model
{
    protected $fillable = [
        'assessment_id',
        'student_id',
        'question_id',
        'answer_text',
        'marks_obtained',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
