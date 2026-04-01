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
        // Ambil UUID dari reference saat kirim notifikasi
        $id = $event->reference;
        $targetUrl = route('notification.public', ['id' => $id]);
        // $targetUrl = "/notification-detail-public/" . $id;

        // Example: Log the action
        Log::debug('Redirecting to Path: ' . $targetUrl);
        Log::debug('NotificationClicked clicked on ID: ' . $id);

        // Perintahkan Window 'main' untuk memuat URL tersebut
        Window::get('main')->url($targetUrl);
    }
}
