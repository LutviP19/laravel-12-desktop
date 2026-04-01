<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $perPage = 10;

    public function index(Request $request)
    {
        // Ambil notifikasi terbaru
        $notifications = auth()->user()->notifications()
            ->latest()
            ->paginate($this->perPage)
            ->withPath('/notification-partial'); // Konsisten dengan route HTMX

        if ($request->header('HX-Request')) {
            return view('notifications._list', compact('notifications'));
        }
        
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return $this->index(request()); // Gunakan index() agar logic pagination sama
    }

    public function destroy($id)
    {
        auth()->user()->notifications()->findOrFail($id)->delete();
        
        return $this->index(request())->withHeaders([
            'HX-Trigger' => json_encode(['showToast' => 'Notifikasi berhasil dihapus'])
        ]);
    }
}