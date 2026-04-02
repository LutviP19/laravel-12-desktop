@forelse($notifications as $noti)
    <div 
        {{-- Logika Auto-Load saat Scroll (Revealed) --}}
        @if ($loop->last && $notifications->hasMorePages())
            hx-get="{{ $notifications->nextPageUrl() }}"
            hx-trigger="revealed"
            hx-swap="afterend"
            hx-indicator="#noti-load-spinner"
        @endif
        class="p-4 mb-2 rounded-xl border transition-all duration-300 flex justify-between items-center group
        {{ $noti->read_at ? 'bg-gray-50/50 dark:bg-slate-800/30 opacity-70 border-gray-100 dark:border-slate-800' : 'bg-white dark:bg-slate-900 border-blue-100 dark:border-blue-900/30 shadow-sm' }}">
        
        <div class="flex-1 cursor-pointer" 
             hx-get="{{ route('notification.detail', $noti->id) }}" 
             hx-target="#main-content">
            <div class="flex items-center gap-2">
                @if(!$noti->read_at)
                    <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                @endif
                <p class="text-sm font-bold {{ $noti->read_at ? 'text-slate-500' : 'text-slate-800 dark:text-slate-100' }}">
                    {{ $noti->data['title'] }}
                </p>
            </div>
            <p class="text-xs text-slate-500 mt-1">{{ $noti->data['message'] }}</p>
            <span class="text-[10px] text-slate-400 uppercase mt-2 block tracking-tighter">
                {{ $noti->created_at->diffForHumans() }}
            </span>
        </div>

        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-all">
            @if(!$noti->read_at)
                <button hx-patch="/notifications/{{ $noti->id }}/read" 
                        hx-include="#csrf-holder [name=_token]" 
                        hx-target="#main-content"
                        class="p-2 text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M5 13l4 4L19 7"/></svg>
                </button>
            @endif
            <button hx-delete="/notifications/{{ $noti->id }}" 
                    hx-include="#csrf-holder [name=_token]" 
                    hx-target="#main-content" 
                    hx-trigger="confirmed" 
                    @click="$dispatch('open-confirm-danger', { title: 'Hapus Notifikasi?', message: 'Hapus pesan ini secara permanen?', target: $el })"
                    class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
        </div>
    </div>

    {{-- Tombol Load More untuk Debug/Manual --}}
    @if ($loop->last && $notifications->hasMorePages())
        <div id="noti-load-more-container" class="py-4 flex justify-center">
            <button 
                hx-get="{{ $notifications->nextPageUrl() }}" 
                hx-target="#noti-load-more-container" 
                hx-swap="outerHTML"
                hx-indicator="#noti-load-spinner"
                class="px-6 py-2 bg-slate-100 dark:bg-slate-800 hover:bg-blue-600 hover:text-white text-[10px] uppercase tracking-widest font-bold rounded-full transition-all">
                Muat Lebih Banyak
            </button>
        </div>
    @endif

@empty
    @if ($notifications->currentPage() == 1)
        <div class="text-center py-20 border-2 border-dashed border-slate-100 dark:border-slate-800 rounded-3xl">
            <p class="text-slate-400 text-sm">Kotak masuk kosong.</p>
        </div>
    @endif
@endforelse

{{-- Spinner Indikator --}}
<div id="noti-load-spinner" class="htmx-indicator py-4 flex justify-center">
    <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
    </svg>
</div>