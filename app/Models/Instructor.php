<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Instructor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'experience_years',
        'availability_mode',
        'city',
        'is_approved',
        'approved_by',
        'approved_at',
        'is_disabled',
        'rejected_by',
        'rejected_at',
        'rejected_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
    public function certifications()
    {
        return $this->hasMany(Certification::class, 'instructor_id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'instructor_id');
    }

    public function projectEngagements()
    {
        return $this->hasMany(ProjectEngagement::class, 'instructor_id');
    }
}
