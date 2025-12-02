<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'mode',
        'city',
        'days',
        'time_slots',
    ];

    protected $casts = [
        'days' => 'array',
        'time_slots' => 'array',
    ];
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function user()
    {
        return $this->instructor->user();
    }
}
