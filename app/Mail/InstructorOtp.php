<?php

namespace App\Mail;

use App\Models\EmailOtp;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorOtp extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $user;

    public function __construct(EmailOtp $otp)
    {
        $this->otp = $otp;
        $this->user = $otp->user;
    }

    public function build()
    {
        return $this->subject('Your Kidicode verification code')
                    ->view('emails.instructor_otp');
    }
}
