<?php 

// app/Http/Controllers/TodoController.php
namespace App\Http\Controllers;

use App\Notifications\DesktopNotification;
use App\Models\Todo;
use Illuminate\Http\Request;
use Native\Desktop\Facades\Notification;
use Illuminate\Validation\ValidationException;

class TodoController extends Controller
{
    // Pagination perpage
    protected $perpage = 7;

    /**
     * Helper untuk mengambil query dasar agar konsisten di semua method
     */
    private function getTodoQuery()
    {
        return auth()->user()->todos()
            ->orderBy('is_completed', 'asc')
            ->latest();
    }

    /**
     * Menampilkan halaman utama atau load more data
     */
    public function index(Request $request) 
    {
        $todos = $this->getTodoQuery()->paginate($this->perpage)->withPath('/todos');

        // Jika ini request load more (Infinite Scroll)
        // Kita cek header HX-Request DAN bukan request dari aksi (seperti toggle/delete)
        if ($request->header('HX-Request') && $request->has('page')) {
            return view('todos.todo-list-items', compact('todos'));
        }

        // Default full page load
        return view('todos.index', compact('todos'));
    }

    /**
     * Digunakan untuk merespons HTMX setelah aksi (Store, Toggle, Destroy)
     * Kita kembalikan SEMUA data yang seharusnya ada di view port saat ini 
     * atau minimal Page 1 untuk meriset view.
     */
    public function renderList() 
    {
        $todos = $this->getTodoQuery()->paginate($this->perpage)->withPath('/todos');
        return response(view('todos.todo-list-items', compact('todos')));
    }

    public function store(Request $request) 
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'category' => 'required',
                'due_date' => 'nullable|date'
            ]);

            $todo = auth()->user()->todos()->create($validated);

            // Notification::title('Tugas Baru')
            //     ->message("Tugas '{$todo->title}' berhasil ditambahkan!")
            //     ->show();

            // Simpan Notification ke tabel
            $user = auth()->user();
            // Ini akan menyimpan ke DB DAN memunculkan popup desktop secara otomatis
            $user->notify(new DesktopNotification(
                "Tugas Baru: {$request->title}", 
                "Kategori: {$request->category}"
            ));

            // Render ulang list (kembali ke page 1 agar tugas baru terlihat)
            return $this->renderList()->withHeaders([
                'HX-Trigger' => json_encode(['showToast' => 'Data berhasil ditambah'])
            ]);
            
        } catch (ValidationException $e) {
            $errorMsg = $e->validator->errors()->first();
            
            // Perbaikan URL XMLNS agar valid
            $html = "<div id='todo-error' hx-swap-oob='true' class='flex items-center gap-2 p-3 mb-4 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-xl border border-red-100 dark:border-red-800'>
                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-4 h-4 shrink-0'>
                        <path stroke-linecap='round' stroke-linejoin='round' d='M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z' />
                    </svg>
                    <span>{$errorMsg}</span>
                </div>";

            return response($html, 422);
        }
    }

    public function toggle(Todo $todo) 
    {
        $todo->update(['is_completed' => !$todo->is_completed]);
        
        // Setelah toggle, kita reset list ke Page 1 
        // karena posisi sorting (is_completed) pasti berubah
        return $this->renderList()->withHeaders([
            'HX-Trigger' => json_encode(['showToast' => 'Data berhasil diupdate'])
        ]);
    }

    public function destroy(Todo $todo) 
    {
        $todo->delete();
        
        // Kembali ke list page 1
        return $this->renderList()->withHeaders([
            'HX-Trigger' => json_encode(['showToast' => 'Data berhasil dihapus'])
        ]);
    }
}
