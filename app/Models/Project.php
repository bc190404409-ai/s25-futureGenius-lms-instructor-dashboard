<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category',
        'start_date',
        'end_date',
        'created_by',
        'status',
        'media',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function instructors()
    {
        return $this->belongsToMany(
            Instructor::class,
            'project_instructor',
            'project_id',
            'instructor_id'
        );
    }

    // public function engagements()
    // {
    //     return $this->hasMany(ProjectEngagement::class, 'project_id');
    // }
}
