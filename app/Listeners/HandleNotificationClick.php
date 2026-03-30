<?php

namespace App\Listeners;

use Native\Desktop\Events\Notifications\NotificationClicked;
use Native\Desktop\Facades\Window;
use Illuminate\Support\Facades\Log;

class HandleNotificationClick
{
    // Handle event NotificationClicked
    public function handle(NotificationClicked $event)
    {
        // Ambil UUID dari cache yang disimpan saat kirim notifikasi
        $id = $event->reference ?? cache()->get('last_notif_id');
        $targetUrl = url('/notification-detail');

        // Example: Log the action
        Log::info('NotificationClicked clicked on ID: ' . $id);

        // Perintahkan Window 'main' untuk memuat URL tersebut
        Window::get('main')
            ->url($targetUrl);
    }
}
