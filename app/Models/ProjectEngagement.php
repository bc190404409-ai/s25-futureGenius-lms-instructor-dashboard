<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectEngagement extends Model
{
    use HasFactory;

    protected $table = 'project_engagement';

    protected $fillable = [
        'project_id',
        'instructor_id',
        'role',
        'status',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
