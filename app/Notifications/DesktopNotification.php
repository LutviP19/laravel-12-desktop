<?php 
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Native\Desktop\Facades\Notification as NativeNotification; 

class DesktopNotification extends Notification
{
    public function __construct(
        public string $title,
        public string $message
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        // Gunakan Facade NativeNotification untuk memicu popup desktop
        NativeNotification::title($this->title)
            ->message($this->message)
            ->reference($this->id) // UUID dari tabel notifications
            ->show();

        return [
            'title' => $this->title,
            'message' => $this->message,
        ];
    }
}