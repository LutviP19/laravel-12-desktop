@forelse($todos as $todo)
    <div 
        class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-gray-100 dark:border-slate-800 group shadow-sm flex items-center justify-between transition-all duration-300 hover:border-blue-200 dark:hover:border-blue-900/50 {{ $todo->is_completed ? 'bg-slate-50/50 dark:bg-slate-800/30 grayscale-[0.4] opacity-80' : '' }}">
        
        <div class="flex items-start gap-3">
            <div class="flex flex-col">
                <span class="text-sm font-semibold transition-all duration-300 {{ $todo->is_completed ? 'text-slate-400 line-through' : 'text-slate-700 dark:text-slate-200' }}">
                    {{ $todo->title }}
                </span>

                <div class="flex items-center gap-2 mt-1">
                    {{-- Category Icon & Text --}}
                    <div class="flex items-center gap-1">
                        @php
                            $cat = match($todo->category) {
                                'Work' => ['c' => 'text-purple-500', 'p' => 'M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM10 5h4v2h-4V5z'],
                                'Personal' => ['c' => 'text-green-500', 'p' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                                'Urgent' => ['c' => 'text-red-500', 'p' => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z'],
                                default => ['c' => 'text-slate-400', 'p' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z']
                            };
                        @endphp
                        <svg class="w-3.5 h-3.5 {{ $cat['c'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $cat['p'] }}" /></svg>
                        <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-tighter">{{ $todo->category }}</span>
                    </div>

                    {{-- Due Date Section --}}
                    @if($todo->due_date)
                        <div class="flex items-center gap-2">
                            <span class="w-1 h-1 bg-slate-300 dark:bg-slate-700 rounded-full"></span>
                            <div class="flex items-center gap-1">
                                @php $isOverdue = $todo->due_date < now()->toDateString() && !$todo->is_completed; @endphp
                                <svg class="w-3.5 h-3.5 {{ $isOverdue ? 'text-red-500' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <span class="text-[10px] font-bold tracking-tighter uppercase {{ $isOverdue ? 'text-red-500' : 'text-slate-500 dark:text-slate-400' }}">
                                    {{ \Carbon\Carbon::parse($todo->due_date)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Actions Group --}}
        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-all duration-300">
            <button hx-patch="/todos/{{ $todo->id }}/toggle" hx-target="#todo-list" hx-include="#csrf-holder [name=_token]" hx-swap="innerHTML" hx-trigger="confirmed"
                @click.prevent="if({{ $todo->is_completed ? 'true' : 'false' }}) { $dispatch('open-confirm-warning', { title: 'Aktifkan Kembali?', message: 'Tugas akan dikembalikan ke daftar aktif.', confirmText: 'Ya, Aktifkan', target: $el }) } else { $dispatch('open-confirm-success', { title: 'Selesaikan Tugas?', message: 'Selamat! Anda telah menyelesaikan tugas ini.', confirmText: 'Ya, Selesai!', target: $el }) }"
                class="p-2 rounded-xl transition-all duration-200 {{ $todo->is_completed ? 'text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20' : 'text-slate-400 hover:text-emerald-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/20' }}">
                @if($todo->is_completed)
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg>
                @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path d="M5 13l4 4L19 7" /></svg>
                @endif
            </button>

            <button hx-delete="/todos/{{ $todo->id }}" hx-target="#todo-list" hx-include="#csrf-holder [name=_token]" hx-trigger="confirmed" 
                @click="$dispatch('open-confirm-danger', { title: 'Hapus Tugas?', message: 'Tindakan ini tidak bisa dibatalkan.', target: $el })" 
                class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-all focus:outline-none">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
        </div>
    </div>
    
    {{-- LOGIK DEBUG: Munculkan tombol Load More hanya di item terakhir jika ada halaman selanjutnya --}}
    @if ($loop->last && $todos->hasMorePages())
        <div id="load-more-container" class="py-6 flex justify-center">
            <button 
                hx-get="{{ $todos->nextPageUrl() }}" 
                hx-include="#csrf-holder [name=_token]" 
                hx-target="#load-more-container" 
                hx-swap="outerHTML"
                {{-- hx-indicator akan membuat tombol ini transparan saat diklik --}}
                hx-indicator="#load-more-spinner"
                class="group flex items-center gap-2 px-5 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-blue-600 hover:text-white text-slate-600 dark:text-slate-400 text-xs font-bold rounded-2xl transition-all shadow-sm active:scale-95"
            >
                <span>Tampilkan (Page {{ $todos->currentPage() + 1 }})</span>
                <svg class="w-4 h-4 group-hover:translate-y-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
    @endif
@empty
    @if ($todos->currentPage() == 1)
        <div class="text-center py-12 border-2 border-dashed border-slate-100 dark:border-slate-800 rounded-3xl">
            <p class="text-slate-400 text-sm">Tidak ada tugas ditemukan.</p>
        </div>
    @endif
@endforelse