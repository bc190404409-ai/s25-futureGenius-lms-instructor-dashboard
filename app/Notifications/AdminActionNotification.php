<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminActionNotification extends Notification
{
    use Queueable;

    public $item;
    public $status;
    public $type;

    public function __construct($item, $status, $type)
    {
        $this->item = $item;
        $this->status = $status;
        $this->type = $type;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'type' => $this->type,
            'status' => $this->status,
            'message' => ucfirst($this->type) . ' "' . ($this->item->title ?? $this->item->skill_name) . '" has been ' . $this->status,
            'item_id' => $this->item->id,
        ];
    }
}
