
<div class="max-w-2xl mx-auto space-y-6">
    
    <!-- Container Utama dengan State Error -->
    <div x-data="{ error: false }" 
        class="bg-white dark:bg-slate-900 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-800 transition-all duration-300"
        :class="{ 'ring-2 ring-red-500/20 border-red-200 dark:border-red-900/50': error }">
        
        <!-- Area Placeholder Error -->
        <div id="todo-error" 
            :class="{ 'animate-pulse': error }" 
            class="empty:hidden mb-4">
            <!-- Konten error dari server akan masuk ke sini -->
        </div>

        <form 
            hx-post="/todos" 
            hx-include="#csrf-holder [name=_token]" 
            x-data="{ 
                target: '#todo-list',
                checkTarget(el) {
                    const title = el.querySelector('input[name=title]').value;
                    this.target = title.trim() === '' ? '#todo-error' : '#todo-list';
                    this.error = (title.trim() === '');
                }
            }"
            :hx-target="target"
            @htmx:before-request="checkTarget($el)"
            @htmx:after-request="
                this.error = !event.detail.successful; 
                
                if (event.detail.successful) { 
                    // SUKSES: Reset form & bersihkan pesan error
                    $el.reset(); 
                    document.getElementById('todo-error').innerHTML = '';
                    this.target = '#todo-list';
                } else {
                    // ERROR: Ambil response dari server (HTML error dari Controller)
                    const responseHTML = event.detail.xhr.responseText;
                    
                    if (responseHTML) {
                        // Masukkan response HTML (merah) dari Controller ke div error
                        document.getElementById('todo-error').innerHTML = responseHTML;
                    } else {
                        // Fallback jika server tidak mengirimkan response (koneksi putus/crash)
                        document.getElementById('todo-error').innerHTML = '<div class=\'p-3 bg-red-50 dark:bg-red-900/20 text-red-600 rounded-xl text-xs border border-red-100 dark:border-red-800\'>Terjadi kesalahan sistem.</div>';
                    }
                }
            "
            @input="error = false; document.getElementById('todo-error').innerHTML = ''" 
            class="space-y-4">
            
            <div class="flex gap-3">
                <input type="text" name="title" placeholder="Tulis tugas baru..."
                    class="flex-1 flex items-center gap-3 px-4 py-2.5 bg-gray-100 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 rounded-xl transition-all duration-200 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent focus:outline-none appearance-none">
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl font-bold transition">
                    Tambah
                </button>
            </div>

            <div class="flex gap-4 items-center text-sm">
                <!-- Dropdown Kategori -->
                <div x-data="{ 
                        open: false, 
                        selected: 'General',
                        categories: [
                            { id: 'General', label: 'General', color: 'text-slate-400', path: 'M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z' },
                            { id: 'Work', label: 'Work', color: 'text-purple-500', path: 'M20 7h-4V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2zM10 5h4v2h-4V5z' },
                            { id: 'Personal', label: 'Personal', color: 'text-green-500', path: 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6' },
                            { id: 'Urgent', label: 'Urgent', color: 'text-red-500', path: 'M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z' }
                        ]
                    }" class="relative w-40">
                    
                    <!-- Input Hidden agar htmx tetap bisa ambil data -->
                    <input type="hidden" name="category" :value="selected">

                    <!-- Tombol Dropdown -->
                    <button @click="open = !open" type="button" 
                            class="w-full flex items-center justify-between bg-gray-50 dark:bg-slate-800 px-3 py-2 rounded-xl text-sm border-none focus:ring-2 focus:ring-blue-500 transition">
                        <div class="flex items-center gap-2 text-slate-700 dark:text-slate-300">
                            <svg class="w-4 h-4" :class="categories.find(c => c.id === selected).color" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" :d="categories.find(c => c.id === selected).path" />
                            </svg>
                            <span x-text="selected"></span>
                        </div>
                        <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <!-- Menu Dropdown -->
                    <div x-show="open" @click.away="open = false" 
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="absolute top-full mt-2 w-full bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-xl shadow-xl z-50 overflow-hidden py-1">
                        
                        <template x-for="category in categories" :key="category.id">
                            <button @click="selected = category.id; open = false" type="button"
                                    class="w-full flex items-center gap-3 px-4 py-2 text-xs hover:bg-gray-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors">
                                <svg class="w-4 h-4" :class="category.color" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" :d="category.path" />
                                </svg>
                                <span x-text="category.label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Input Tanggal -->
                <div class="flex items-center gap-3 px-4 py-2.5 bg-gray-100 dark:bg-slate-800/50 border border-gray-200 dark:border-slate-700 rounded-xl transition-all duration-200 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <input type="date" name="due_date" class="bg-transparent border-none p-0 text-xs focus:ring-0 focus:outline-none cursor-pointer text-gray-900 dark:text-white appearance-none">
                </div>
            </div>
        </form>
    </div>

    <!-- Container List -->
    <div id="todo-list" class="space-y-3">
       @include('todos.todo-list-items')
    </div>

    <div id="load-more-spinner" class="htmx-indicator py-4 flex justify-center">
        <svg class="animate-spin h-6 w-6 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </div>
</div>
