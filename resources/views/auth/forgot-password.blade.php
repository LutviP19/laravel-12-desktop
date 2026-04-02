@extends('layouts.auth')
@section('content')
<div class="bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800">
    <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Lupa Password?</h2>
    <p class="text-sm text-slate-500 mb-6">Masukkan email Anda dan kami akan kirimkan link untuk mengatur ulang password.</p>
    
    <form hx-post="{{ route('password.email') }}" 
        hx-target="#reset-status" 
        hx-indicator="#loading-spinner" 
        class="relative">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1 ml-1 uppercase tracking-wider">Alamat Email</label>
                <input type="email" name="email" placeholder="contoh@email.com" 
                    class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 text-slate-900 dark:text-slate-100 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition-all">
            </div>
            
            <div id="reset-status" class="min-h-[20px]"></div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg shadow-lg shadow-blue-200 dark:shadow-none transition flex items-center justify-center gap-2 group">
                
                <svg id="loading-spinner" class="animate-spin h-5 w-5 text-white htmx-indicator" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <span class="group-[.htmx-request]:opacity-50">Kirim Link Reset</span>
            </button>
        </div>
    </form>
    <div class="mt-4 text-center">
        <a href="{{ route('login') }}" class="text-xs text-blue-600 font-bold hover:underline">Kembali ke Login</a>
    </div>
</div>
@endsection