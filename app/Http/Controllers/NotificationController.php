<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    private $perPage = 7;

    public function index(Request $request)
    {
        // Ambil notifikasi terbaru
        $notifications = auth()->user()->notifications()
            ->latest()
            ->paginate($this->perPage)
            ->withPath('/notifications');

        if ($request->header('HX-Request')) {
            return view('notifications._list', compact('notifications'));
        }
        
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return $this->index(request());
    }

    public function destroy($id)
    {
        auth()->user()->notifications()->findOrFail($id)->delete();
        
        return response($this->index(request()))->withHeaders([
            'HX-Trigger' => json_encode(['showToast' => 'Notifikasi berhasil dihapus'])
        ]);
    }
}