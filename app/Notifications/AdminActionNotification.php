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
    public $meta;

    public function __construct($item, $status, $type, $meta = [])
    {
        $this->item = $item;
        $this->status = $status;
        $this->type = $type;
        $this->meta = $meta;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $title = null;

        // items may be Skill/Certification/Project/Instructor — try common properties
        if (isset($this->item->title)) {
            $title = $this->item->title;
        } elseif (isset($this->item->skill_name)) {
            $title = $this->item->skill_name;
        } elseif (isset($this->item->user) && isset($this->item->user->name)) {
            $title = $this->item->user->name;
        } elseif (isset($this->item->name)) {
            $title = $this->item->name;
        }

        $message = ucfirst($this->type) . ($title ? ' "' . $title . '"' : '') . ' has been ' . $this->status;

        // append a short reason when provided in meta (e.g., rejection reason)
        if (!empty($this->meta) && isset($this->meta['reason']) && $this->meta['reason']) {
            $message .= '. Reason: ' . 
                (is_string($this->meta['reason']) ? $this->meta['reason'] : json_encode($this->meta['reason']));
        }

        return [
            'type' => $this->type,
            'status' => $this->status,
            'message' => $message,
            'item_id' => $this->item->id,
            'meta' => $this->meta,
        ];
    }
}
