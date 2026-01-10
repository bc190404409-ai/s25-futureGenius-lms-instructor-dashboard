<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminActionMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $item;
    public $status;
    public $type;

    /**
     * Create a new message instance.
     */
    public function __construct($item, $status, $type)
    {
        $this->item = $item;
        $this->status = $status;
        $this->type = $type;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $subject = ucfirst($this->type) . ' ' . ($this->item->title ?? $this->item->skill_name ?? '') . ' has been ' . $this->status;

        return $this->subject($subject)
                    ->view('emails.admin_action')
                    ->with([
                        'item' => $this->item,
                        'status' => $this->status,
                        'type' => $this->type,
                    ]);
    }
}
