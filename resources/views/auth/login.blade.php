@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<div class="bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 transition-colors duration-300">
    <form hx-post="/login" hx-target="#login-error" hx-swap="innerHTML">
        @csrf
        <div class="space-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Email</label>
                <input type="email" name="email"  
                    class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>
            
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Password</label>
                <input type="password" name="password"  
                    class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
            </div>

            <div id="login-error" class="text-sm"></div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-bold py-3 rounded-lg shadow-lg shadow-blue-200 dark:shadow-none transition transform active:scale-[0.98]">
                Masuk Sekarang
            </button>
        </div>
    </form>

    <div class="mt-6 pt-6 border-t border-slate-100 dark:border-slate-800 text-center">
        <p class="text-sm text-slate-600 dark:text-slate-400">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-blue-600 dark:text-blue-400 font-bold hover:underline">Daftar Gratis</a>
        </p>

        <!-- Link ke Home -->
        <p class="text-xs">
            <a href="{{ url('/') }}" class="text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 transition-colors flex items-center justify-center gap-1">
                <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Beranda
            </a>
        </p>
    </div>
</div>
@endsection
