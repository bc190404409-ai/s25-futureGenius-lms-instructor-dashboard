<?php

namespace App\Mail;

use App\Models\Instructor;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $instructor;

    /**
     * Create a new message instance.
     */
    public function __construct(Instructor $instructor)
    {
        $this->instructor = $instructor;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Your instructor account has been approved')
                    ->view('emails.instructor_approved');
    }
}
