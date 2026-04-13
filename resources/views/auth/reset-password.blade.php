@extends('layouts.auth')
@section('title', 'Atur Ulang Password')

@section('content')
<div class="bg-white dark:bg-slate-900 p-8 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-800">
    <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Password Baru</h2>
    <p class="text-sm text-slate-500 mb-6">Silakan masukkan password baru Anda.</p>

    <form hx-post="{{ route('password.update') }}" hx-target="#reset-error"
          @input="
                const errDiv = document.getElementById('reset-error');
                errDiv.innerHTML = ''; 
                errDiv.className = 'empty:hidden mb-0';
            ">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Email</label>
                <input type="email" name="email" value="{{ request()->email }}" required
                    class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 text-slate-900 dark:text-slate-100">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Password Baru</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 text-slate-900 dark:text-slate-100">
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full px-4 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 text-slate-900 dark:text-slate-100">
            </div>

            <div id="reset-error" class="text-sm"></div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-lg transition shadow-lg shadow-blue-200 dark:shadow-none">
                Simpan Password Baru
            </button>
        </div>
    </form>
</div>
@endsection