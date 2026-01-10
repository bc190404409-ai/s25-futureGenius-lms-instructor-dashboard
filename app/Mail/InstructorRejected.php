<?php

namespace App\Mail;

use App\Models\Instructor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorRejected extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $instructor;
    public $adminName;
    public $reason;

    /**
     * Create a new message instance.
     */
    public function __construct(Instructor $instructor, $adminName = null, $reason = null)
    {
        $this->instructor = $instructor;
        $this->adminName = $adminName;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Instructor request not approved')
                    ->view('emails.instructor_rejected')
                    ->text('emails.instructor_rejected_plain');
    }
}
