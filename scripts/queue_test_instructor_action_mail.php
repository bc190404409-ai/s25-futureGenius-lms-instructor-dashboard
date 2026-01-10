<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\InstructorRejected;
use App\Mail\InstructorStatusMail;
use App\Models\User;
use App\Models\Instructor;

$user = User::where('role', 'instructor')->first();
if (!$user) {
    $user = User::first();
    if (!$user) { echo "No user found\n"; exit(1); }
    $instructor = Instructor::firstOrCreate(['user_id' => $user->id], ['is_approved' => false]);
} else {
    $instructor = $user->instructor ?? Instructor::create(['user_id' => $user->id, 'is_approved' => false]);
}

$to = $user->email ?: env('MAIL_FROM_ADDRESS');
$adminName = 'Automated Test';

try {
    Mail::to($to)->queue(new InstructorRejected($instructor, $adminName, 'Test rejection reason'));
    echo "Queued InstructorRejected to {$to}\n";
    Mail::to($to)->queue(new InstructorStatusMail($instructor, 'disabled', $adminName));
    echo "Queued InstructorStatusMail(disabled) to {$to}\n";
} catch (Exception $e) {
    echo "Error queuing emails: " . $e->getMessage() . "\n"; exit(1);
}

echo "Jobs queued now: " . \DB::table('jobs')->count() . "\n";

return 0;
