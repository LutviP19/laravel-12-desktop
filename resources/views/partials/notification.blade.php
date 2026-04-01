<div class="p-6 max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold mb-4 dark:text-white">Detail Notifikasi</h1>

    @if(isset($notification))
        <div class="bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-2xl p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                </div>
                <div>
                    <h2 class="font-bold text-slate-800 dark:text-slate-100">{{ $notification->data['title'] ?? 'Judul' }}</h2>
                    <p class="text-[10px] text-slate-400 uppercase">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                {{ $notification->data['message'] ?? 'Pesan tidak ditemukan.' }}
            </p>

            <div class="pt-4 border-t border-gray-50 dark:border-slate-800">
                <p class="text-[10px] font-mono text-slate-400 break-all">ID: {{ $id }}</p>
            </div>
        </div>
    @elseif(isset($id))
        <div class="p-4 bg-amber-50 dark:bg-amber-900/20 text-amber-600 rounded-xl border border-amber-100 dark:border-amber-800">
            <p class="text-sm">ID Terdeteksi: <span class="font-mono font-bold">{{ $id }}</span>, namun detail data tidak ditemukan di database.</p>
        </div>
    @else
        <div class="p-4 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl border border-red-100 dark:border-red-800">
            <p class="text-sm font-bold">Peringatan: Tidak ada ID yang ditemukan.</p>
        </div>
    @endif

    <div class="flex gap-3 mt-6">
        @auth
            <a href="{{ url('/dashboard') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-blue-200 dark:shadow-none">
                Kembali ke Dashboard
            </a>
        @else
            <a href="{{ url('/') }}" class="px-4 py-2 mr-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-blue-200 dark:shadow-none">
                Kembali ke Home
            </a>
            <a href="{{ url('/login') }}" class="px-4 py-2 bg-slate-800 hover:bg-black text-white text-xs font-bold rounded-xl transition-all">
                Login untuk Lihat Semua
            </a>
        @endauth
    </div>
</div>