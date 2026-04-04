<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin() { return view('auth.login'); }
    public function showRegister() { return view('auth.register'); }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Menggunakan response("")->header() agar htmx melakukan redirect penuh
        return response("")->header('HX-Redirect', url('/login'));
    }

    public function login(Request $request) {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            // Ambil nilai checkbox (akan bernilai true jika dicentang)
            $remember = $request->has('remember');

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();

                // return response("")->header('HX-Redirect', url('/dashboard'));
                return response('', 204)->header('HX-Redirect', route('dashboard'));
            }

            return "<div class='p-2 bg-red-50 dark:bg-red-900/20 text-red-500 text-xs rounded-lg border border-red-100 dark:border-red-800'>Email atau password salah.</div>";
            
        } catch (ValidationException $e) {
            // Mengambil pesan error pertama saja untuk ditampilkan di area error umum
            return "<div class='p-2 bg-red-50 dark:bg-red-900/20 text-red-500 text-xs rounded-lg border border-red-100 dark:border-red-800'>" . $e->validator->errors()->first() . "</div>";
        }
    }

    public function sendResetLink(Request $request) 
    {
        // 1. Validasi Manual
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        // 2. Jika Validasi Gagal, Kembalikan Pesan Error (Warna Merah)
        if ($validator->fails()) {
            return '<div class="flex items-center gap-2 p-3 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <p class="text-sm font-medium text-red-700 dark:text-red-400">' . $validator->errors()->first('email') . '</p>
                    </div>';
        }

        // 3. Proses Kirim Link Reset
        try {
            $status = Password::sendResetLink($request->only('email'));

            if ($status === Password::ResetLinkSent) {
                return '<div class="flex items-center gap-2 p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800">
                            <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400">Link reset telah dikirim ke email Anda.</p>
                        </div>';
            }

            // Jika email tidak ditemukan di database
            return '<div class="flex items-center gap-2 p-3 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        <p class="text-sm font-medium text-red-700 dark:text-red-400">Alamat email tersebut tidak terdaftar.</p>
                    </div>';
                    
        } catch (\Exception $e) {
            return '<p class="text-sm text-red-600 dark:text-red-400 italic">Terjadi kesalahan sistem. Coba lagi nanti.</p>';
        }
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Lakukan proses reset
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                if ($user) {
                    // Laravel menjamin $user tidak null DI DALAM closure ini 
                    // JIKA data email & token valid.
                    $user->forceFill([
                        'password' => Hash::make($password)
                    ])->setRememberToken(Str::random(60));
                    $user->save();

                    event(new PasswordReset($user));
                }
            }
        );

        // Jika statusnya sukses
        if ($status === Password::PASSWORD_RESET) {
            return response('', 204)->header('HX-Redirect', route('login'));
        }

        // // Jika gagal (token kadaluarsa atau email salah)
        // return '<div class="p-3 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-sm text-red-700 dark:text-red-400">
        //             Gagal mereset password. Pastikan email benar atau minta link baru.
        //         </div>';

        // Tangkap pesan error asli dari Laravel (misal: token invalid)
        return '<div class="p-3 rounded-lg bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-sm text-red-700 dark:text-red-400">' 
        . __($status) . 
       '</div>';
    }

    public function register(Request $request) {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6|confirmed',
            ]);

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            return response("")->header('HX-Redirect', url('/login'));

        } catch (ValidationException $e) {
            // Mengembalikan semua error dalam format list yang rapi
            $errors = $e->validator->errors()->all();
            $html = "<ul class='p-3 bg-red-50 dark:bg-red-900/20 text-red-500 text-xs rounded-lg border border-red-100 dark:border-red-800 list-disc list-inside space-y-1'>";
            foreach ($errors as $error) {
                $html .= "<li>$error</li>";
            }
            $html .= "</ul>";
            return $html;
        }
    }
}
