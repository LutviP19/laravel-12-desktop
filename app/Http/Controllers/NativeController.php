<?php

// app/Http/Controllers/NativeController.php
namespace App\Http\Controllers;


use Native\Desktop\Events\Notifications\NotificationActionClicked;
use Native\Desktop\Facades\Window;

use Native\Desktop\Events\Notifications\NotificationClicked;
use Native\Desktop\Facades\Notification;

use Illuminate\Support\Facades\Event;


use Illuminate\Support\Str;

class NativeController extends Controller
{
    // Kirim notifikasi
    public function sendNotification()
    {
        // Memanggil API Native untuk menampilkan notifikasi OS
        $dataId = Str::uuid(); // Contoh data
        Notification::title('Update Baru')
            ->message('Klik untuk melihat detail data #'.$dataId)
            ->reference($dataId)
            ->show();

        return "<span>✅ Notifikasi terkirim dan siap diklik!</span>";
    }
}
