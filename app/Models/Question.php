<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'assessment_id',
        'question_text',
        'question_type', // multiple_choice, true_false
        'marks',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }
}
