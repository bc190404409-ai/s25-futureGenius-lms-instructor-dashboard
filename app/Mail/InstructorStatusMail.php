<?php

namespace App\Mail;

use App\Models\Instructor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorStatusMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $instructor;
    public $status; // 'disabled' or 'enabled'
    public $adminName;

    public function __construct(Instructor $instructor, $status, $adminName = null)
    {
        $this->instructor = $instructor;
        $this->status = $status;
        $this->adminName = $adminName;
    }

    public function build()
    {
        $subject = $this->status === 'disabled' ? 'Your instructor account has been disabled' : 'Your instructor account has been enabled';

        return $this->subject($subject)
                    ->view('emails.instructor_status')
                    ->text('emails.instructor_status_plain');
    }
}
