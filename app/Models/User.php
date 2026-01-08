<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo',
        'city',
        'province',
        'street',
        'phone',
        'bio',
        'linkedIn_url',
        'video_url',
        'portfolio_url',
        'portfolio_file',
    ];

    protected $hidden = ['password'];

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'instructor_id');
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class, 'instructor_id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class, 'instructor_id');
    }

    public function projectsCreated()
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    public function projectEngagements()
    {
        return $this->hasMany(ProjectEngagement::class, 'instructor_id');
    }

    public function messagesSent()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function messagesReceived()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }
}
