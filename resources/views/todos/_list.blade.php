@forelse($todos as $todo)
    <div class="p-4 bg-white dark:bg-slate-900 rounded-xl border border-gray-50 dark:border-slate-800 group shadow-sm flex items-center justify-between">
        <div class="flex items-start gap-3">
            <input type="checkbox" hx-patch="/todos/{{ $todo->id }}/toggle" hx-target="#todo-list"
                   {{ $todo->is_completed ? 'checked' : '' }}
                   class="mt-1 w-5 h-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
            
            <div class="flex flex-col">
                <span class="text-slate-700 dark:text-slate-200 font-medium {{ $todo->is_completed ? 'line-through opacity-50' : '' }}">
                    {{ $todo->title }}
                </span>
                
                <div class="flex items-center gap-1.5 mt-1">
                    @php
                        $catData = match($todo->category) {
                            'Work' => ['color' => 'text-purple-500', 'path' => 'M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM10 5h4v2h-4V5z'],
                            'Personal' => ['color' => 'text-green-500', 'path' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            'Urgent' => ['color' => 'text-red-500', 'path' => 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z'],
                            default => ['color' => 'text-slate-400', 'path' => 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z']
                        };
                    @endphp
                    
                    <svg class="w-3.5 h-3.5 {{ $catData['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $catData['path'] }}" />
                    </svg>
                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase">{{ $todo->category }}</span>
                </div>
            </div>
        </div>

        <button 
            hx-delete="/todos/{{ $todo->id }}" 
            hx-target="#todo-list" 
            hx-include="#csrf-holder [name=_token]"
            hx-trigger="confirmed"
            @click="$dispatch('open-confirm', { 
                title: 'Hapus Tugas?', 
                message: 'Tindakan ini tidak bisa dibatalkan.', 
                target: $el 
            })" 
            class="text-slate-400 hover:text-red-500 transition opacity-0 group-hover:opacity-100">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
        </button>
    </div>
@empty
    <div class="text-center py-10 text-slate-400">Belum ada tugas hari ini.</div>
@endforelse
