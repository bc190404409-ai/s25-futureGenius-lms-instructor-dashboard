<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'user_id',
        'title',
        'issuer',
        'file_path',
        'issue_date',
        'expiry_date',
        'status',
        'rejected_reason',
    ];
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
}
