@extends('layouts.app')
@section('content')
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800 p-8">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white mb-6">Pengaturan Profil</h2>

        <form hx-post="{{ route('profile.update') }}" hx-include="#csrf-holder [name=_token]" hx-target="#profile-status" hx-indicator="#saving">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" readonly 
                        class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 dark:text-white">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" 
                        class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 dark:text-white">
                </div>

                <hr class="border-slate-100 dark:border-slate-800">

                <p class="text-xs text-slate-500 italic">Kosongkan password jika tidak ingin diubah.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Password Baru</label>
                        <input type="password" name="password" class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 dark:text-white">
                    </div>
                </div>

                <div id="profile-status"></div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg flex items-center justify-center gap-2 transition">
                    <span id="saving" class="htmx-indicator animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection