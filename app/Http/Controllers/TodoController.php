<?php 

// app/Http/Controllers/TodoController.php
namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    // Menampilkan halaman utama Todo (Full Page)
    public function index() {
        return view('todos.index', ['todos' => auth()->user()->todos()->latest()->get()]);
    }

    // Menampilkan daftar saja (Partial untuk htmx)
    public function list() {
        return view('todos._list', ['todos' => auth()->user()->todos()->latest()->get()]);
    }

    public function store(Request $request) {
        try {
            $request->validate([
                'title' => 'required|max:255',
                'category' => 'required',
                'due_date' => 'nullable|date'
            ]);

            // Simpan hasil create ke dalam variabel $todo
            $todo = auth()->user()->todos()->create([
                'title' => $request->title,
                'category' => $request->category,
                'due_date' => $request->due_date
            ]);

            // Sekarang variabel $todo sudah ada dan bisa digunakan untuk Notifikasi
            \Native\Desktop\Facades\Notification::title('Tugas Baru')
                ->message("Tugas '{$todo->title}' berhasil ditambahkan!")
                ->show();

            return $this->list();
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Ambil error pertama saja agar UI tetap bersih
            $errorMsg = $e->validator->errors()->first();
            
            $html = "<div id='todo-error' hx-swap-oob='true' class='flex items-center gap-2 p-3 mb-4 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-xs rounded-xl border border-red-100 dark:border-red-800'>
                    <svg xmlns='http://w3.org' fill='none' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' class='w-4 h-4 shrink-0'>
                        <path stroke-linecap='round' stroke-linejoin='round' d='M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z' />
                    </svg>
                    <span>{$errorMsg}</span>
                </div>";

            return response($html, 422);
        }
    }

    public function toggle(Todo $todo) {
        $todo->update(['is_completed' => !$todo->is_completed]);
        return $this->list();
    }

    public function destroy(Todo $todo) {
        $todo->delete();
        return $this->list();
    }
}
