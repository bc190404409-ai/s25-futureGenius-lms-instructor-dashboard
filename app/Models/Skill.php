<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'user_id',
        'skill_name',
        'skill_type',
        'video_link',
        'status',
    ];

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
