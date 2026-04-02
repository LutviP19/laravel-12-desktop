@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-4 md:p-8" x-data="{ showPw: false }">
    <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        
        <div x-data="{ isSaving: false }" class="p-8">
            <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-1 tracking-tight">Pengaturan Profil</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-8">Kelola informasi akun dan keamanan Anda.</p>

            <form hx-post="{{ route('profile.update') }}" 
                  hx-include="#csrf-holder [name=_token]" 
                  hx-target="#profile-status" 
                  hx-indicator="#saving-loader" 
                  @input="document.getElementById('profile-status').innerHTML = ''" 
                  @htmx:before-request="isSaving = true"
                  @htmx:after-request="if($event.detail.xhr.status === 422) isSaving = false">
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" readonly 
                            class="w-full px-5 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:text-white transition-all">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ $user->name }}" 
                            class="w-full px-5 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:text-white transition-all">
                    </div>                    

                    <div class="py-4">
                        <div class="h-px bg-slate-100 dark:bg-slate-800 w-full"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ inputPass: '' }">
                        <div class="space-y-2" x-data="{ show: false }">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Password Baru</label>
                            <div class="relative">
                                <input 
                                    :type="show ? 'text' : 'password'" 
                                    name="password" 
                                    x-model="inputPass"
                                    :placeholder="inputPass.length > 0 ? '' : '••••••••'"
                                    class="w-full px-5 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:text-white transition-all pr-12">
                                
                                <button type="button" @click="show = !show" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-500 transition-colors focus:outline-none">
                                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>

                        <div class="space-y-2" x-data="{ show: false }">
                            <label class="text-sm font-bold text-slate-700 dark:text-slate-300 ml-1">Konfirmasi Password</label>
                            <div class="relative">
                                <input 
                                    :type="show ? 'text' : 'password'" 
                                    name="password_confirmation" 
                                    :placeholder="inputPass.length > 0 ? '' : '••••••••'"
                                    class="w-full px-5 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl outline-none focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 dark:text-white transition-all pr-12">
                                
                                <button type="button" @click="show = !show" 
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-500 transition-colors focus:outline-none">
                                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg x-show="show" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="profile-status"></div>

                    <div class="flex flex-col sm:flex-row gap-4 pt-4">
                        <a href="{{ route('dashboard') }}" 
                        class="w-full sm:w-1/3 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 font-bold py-4 rounded-2xl transition transform active:scale-[0.98] flex items-center justify-center border border-slate-200 dark:border-slate-700">
                            Batal
                        </a>

                        <button type="submit" 
                            :disabled="isSaving"
                            :class="isSaving ? 'opacity-70 cursor-not-allowed scale-[0.98] shadow-none' : ''" 
                            class="w-full sm:flex-1 bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl shadow-xl shadow-blue-500/20 transition transform active:scale-[0.98] flex items-center justify-center gap-3">
                            <svg id="saving-loader" class="htmx-indicator animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span x-text="isSaving ? 'Menyimpan...' : 'Simpan Perubahan'"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection