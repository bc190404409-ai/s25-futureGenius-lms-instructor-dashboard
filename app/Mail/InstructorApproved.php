<?php

namespace App\Mail;

use App\Models\Instructor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $instructor;
    public $approvedByName;

    /**
     * Create a new message instance.
     */
    public function __construct(Instructor $instructor, $approvedByName = null)
    {
        $this->instructor = $instructor;
        $this->approvedByName = $approvedByName;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your instructor account has been approved')
                    ->view('emails.instructor_approved')
                    ->text('emails.instructor_approved_plain');
    }
}
