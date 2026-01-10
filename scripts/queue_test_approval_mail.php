<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\InstructorApproved;
use App\Models\User;
use App\Models\Instructor;

// find an instructor user
$user = User::where('role', 'instructor')->first();

if (!$user) {
    // fallback to any user
    $user = User::first();
    if (!$user) {
        echo "No user found in DB to associate with an instructor. Cannot continue.\n";
        exit(1);
    }
    // create instructor if missing
    $instructor = Instructor::firstOrCreate(['user_id' => $user->id], ['is_approved' => true]);
} else {
    $instructor = $user->instructor;
    if (!$instructor) {
        $instructor = Instructor::create(['user_id' => $user->id, 'is_approved' => true]);
    }
}

$to = env('MAIL_FROM_ADDRESS') ?: $user->email;
if (!$to) { echo "No recipient address available.\n"; exit(1); }

try {
    Mail::to($to)->queue(new InstructorApproved($instructor, 'Automated Test'));
    echo "Queued InstructorApproved email to: {$to}\n";
} catch (Exception $e) {
    echo "Failed to queue email: " . $e->getMessage() . "\n";
    exit(1);
}

// show jobs count now
$jobs = \DB::table('jobs')->count();
echo "Jobs queued now: " . $jobs . "\n";

return 0;
