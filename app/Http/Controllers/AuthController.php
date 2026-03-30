<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

            if (Auth::attempt($credentials)) {
                return response("")->header('HX-Redirect', url('/dashboard'));
            }

            return "<div class='p-2 bg-red-50 dark:bg-red-900/20 text-red-500 text-xs rounded-lg border border-red-100 dark:border-red-800'>Email atau password salah.</div>";
            
        } catch (ValidationException $e) {
            // Mengambil pesan error pertama saja untuk ditampilkan di area error umum
            return "<div class='p-2 bg-red-50 dark:bg-red-900/20 text-red-500 text-xs rounded-lg border border-red-100 dark:border-red-800'>" . $e->validator->errors()->first() . "</div>";
        }
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
