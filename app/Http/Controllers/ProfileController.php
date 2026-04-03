<?php 

namespace App\Http\Controllers;

use App\Notifications\DesktopNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit() {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request) {
        $user = auth()->user();
        $isPasswordChanged = $request->filled('password');

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:5', 'max:255'],
            // 'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'notification_expiry_days' => 'nullable|integer|in:3,7,14,30', // Validasi pilihan
            'password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return response()->view('partials.form-error', [
                        'errors' => $validator->errors()
                    ], 422);
        }

        $user->name = $request->name;
        // $user->email = $request->email;
        $user->notification_expiry_days = $request->notification_expiry_days;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Sinkronisasi sesi agar Nama langsung berubah di UI
        auth()->setUser($user);

        if ($isPasswordChanged) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

             // Simpan Notification ke tabel
            $user->notify(new DesktopNotification(
                "Password Berhasil Diperbarui", 
                "Perubahan telah disimpan, Pengaturan ini akan aktif sepenuhnya pada sesi login Anda berikutnya."
            ));

            // Kirim pesan dan instruksi redirect 3 detik
            return response('<div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200 dark:bg-slate-800 dark:text-emerald-400 dark:border-emerald-900">
                                Password berhasil diperbarui. Mengalihkan ke halaman login dalam 5 detik...
                            </div>')
                ->header('HX-Trigger', json_encode([
                    'delayedRedirect' => ['url' => route('login'), 'ms' => 5000]
                ]));
        }

        // Simpan Notification ke tabel
        $user->notify(new DesktopNotification(
            "Profil({$request->email}) Berhasil Diperbarui", 
            "Perubahan telah disimpan dan aktif."
        ));

        // Redirect biasa ke dashboard untuk update profil tanpa ganti password
        return response('<div class="p-4 mb-4 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-200 dark:bg-slate-800 dark:text-emerald-400 dark:border-emerald-900">
                                Data berhasil diperbarui. Mengalihkan ke halaman Dashboard dalam 3 detik...
                            </div>')
            ->header('HX-Trigger', json_encode([
                    'delayedRedirect' => ['url' => route('dashboard'), 'ms' => 3000]
            ]));
    }
}
