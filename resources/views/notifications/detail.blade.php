<div class="p-4 md:p-8 max-w-4xl mx-auto">
    {{-- Header & Back Button --}}
    <div class="flex items-center gap-4 mb-8">
        <button hx-get="/notifications" hx-target="#main-content" hx-push-url="true"
            class="p-2 rounded-xl bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 text-slate-400 hover:text-blue-500 transition-all shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Detail Notifikasi</h1>
            <p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">Informasi Sistem</p>
        </div>
    </div>

    {{-- Main Content Card --}}
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden">
        {{-- Status Bar --}}
        <div class="px-6 py-3 bg-blue-50/50 dark:bg-blue-900/10 border-b border-gray-100 dark:border-slate-800 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <span class="flex h-2 w-2 rounded-full bg-blue-500"></span>
                <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase">Pesan Berhasil Terkirim</span>
            </div>
            <span class="text-[10px] font-mono text-slate-400 uppercase tracking-tighter">Ref: {{ substr($notification->id, 0, 8) }}...</span>
        </div>

        <div class="p-8">
            {{-- Icon & Title --}}
            <div class="flex items-start gap-6 mb-8">
                <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h2 class="text-xl font-bold text-slate-800 dark:text-white mb-2">
                        {{ $notification->data['title'] ?? 'Judul Tidak Tersedia' }}
                    </h2>
                    <div class="flex items-center gap-3">
                        <span class="text-xs text-slate-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            {{ $notification->created_at->translatedFormat('d F Y, H:i') }}
                        </span>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span class="text-xs text-slate-500 italic">{{ $notification->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>

            {{-- Message Body --}}
            <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 mb-8">
                <p class="text-slate-600 dark:text-slate-300 leading-relaxed italic">
                    "{{ $notification->data['message'] ?? 'Tidak ada detail pesan.' }}"
                </p>
            </div>

            {{-- Technical Metadata --}}
            <div class="grid grid-cols-2 gap-4 pt-8 border-t border-gray-100 dark:border-slate-800">
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">ID Notifikasi</p>
                    <p class="text-xs font-mono text-blue-600 break-all bg-blue-50 dark:bg-blue-900/20 p-2 rounded-lg">
                        {{ $notification->id }}
                    </p>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mb-1">Status Baca</p>
                    <div class="flex items-center gap-2 mt-2">
                        @if($notification->read_at)
                            <span class="px-2 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 text-[10px] font-bold rounded-md uppercase">Sudah Dibaca</span>
                            <span class="text-[10px] text-slate-400 italic">{{ $notification->read_at->diffForHumans() }}</span>
                        @else
                            <span class="px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-600 text-[10px] font-bold rounded-md uppercase">Belum Dibaca</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Actions --}}
    <div class="mt-8 flex justify-between items-center px-4">
        <button hx-delete="/notifications/{{ $notification->id }}" hx-target="#main-content" hx-include="#csrf-holder [name=_token]" 
            @click="$dispatch('open-confirm-danger', { title: 'Hapus Notifikasi?', message: 'Hapus data ini dari riwayat?', target: $el })"
            class="text-xs font-bold text-red-500 hover:text-red-600 transition-colors uppercase tracking-widest flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Hapus Riwayat
        </button>

        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-blue-200 dark:shadow-none transition-all active:scale-95 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
            Kembali ke Dashboard
        </a>
    </div>
</div>