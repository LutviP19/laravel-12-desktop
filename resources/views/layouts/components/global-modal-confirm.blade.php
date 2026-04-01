<!-- Modal Confirm Success Global -->
<div x-data="{ 
        open: false, 
        title: '', 
        message: '', 
        confirmText: 'Ya, Selesaikan',
        targetEl: null,
        
        // Suara Success: Nada ceria (C5 ke G5)
        playSuccessSound() {
            const context = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = context.createOscillator();
            const gainNode = context.createGain();

            oscillator.type = 'sine'; 
            oscillator.frequency.setValueAtTime(523.25, context.currentTime); // C5
            oscillator.frequency.exponentialRampToValueAtTime(783.99, context.currentTime + 0.1); // G5
            
            gainNode.gain.setValueAtTime(0.1, context.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, context.currentTime + 0.4);

            oscillator.connect(gainNode);
            gainNode.connect(context.destination);

            oscillator.start();
            oscillator.stop(context.currentTime + 0.4);
        },

        confirmAction() {
            if(this.targetEl) {
                htmx.trigger(this.targetEl, 'confirmed');
            }
            this.open = false;
        }
    }" 
    @open-confirm-success.window="
        open = true; 
        title = $event.detail.title; 
        message = $event.detail.message; 
        targetEl = $event.detail.target;
        confirmText = $event.detail.confirmText || 'Ya, Selesaikan';
        playSuccessSound();
    "
    x-show="open" 
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-md"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak>
    
    <div @click.away="open = false" 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-3xl shadow-2xl border border-emerald-100 dark:border-emerald-900/20 p-6 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-1.5 bg-emerald-500"></div>

        <div class="flex items-start gap-4 mt-2">
            <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <div class="flex-1">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white leading-tight" x-text="title"></h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed" x-text="message"></p>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-end gap-3">
            <button @click="open = false" 
                class="flex-1 px-4 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
                Batal
            </button>
            <button @click="confirmAction()" 
                class="flex-1 px-4 py-2.5 text-sm font-bold text-white bg-emerald-500 hover:bg-emerald-600 active:scale-95 rounded-xl shadow-lg shadow-emerald-200 dark:shadow-none transition-all duration-200">
                <span x-text="confirmText"></span>
            </button>
        </div>
    </div>
</div>

<!-- Modal Confirm Warning Global -->
<div x-data="{ 
        open: false, 
        title: '', 
        message: '', 
        confirmText: 'Ya, Lanjutkan',
        targetEl: null,
        playWarningSound() {
            const context = new (window.AudioContext || window.webkitAudioContext)();
            
            const playNote = (delay, frequency, duration) => {
                const oscillator = context.createOscillator();
                const gainNode = context.createGain();

                // 'square' memberikan suara yang lebih 'digital' dan jelas untuk peringatan
                oscillator.type = 'square'; 
                oscillator.frequency.setValueAtTime(frequency, context.currentTime + delay);
                
                gainNode.gain.setValueAtTime(0.1, context.currentTime + delay); // Volume rendah tapi tajam
                gainNode.gain.exponentialRampToValueAtTime(0.01, context.currentTime + delay + duration);

                oscillator.connect(gainNode);
                gainNode.connect(context.destination);

                oscillator.start(context.currentTime + delay);
                oscillator.stop(context.currentTime + delay + duration);
            };

            // Nada pertama (rendah)
            playNote(0, 660, 0.1); 
            // Nada kedua (lebih tinggi) untuk kesan interupsi yang jelas
            playNote(0.12, 880, 0.1); 
        },

        confirmAction() {
            if(this.targetEl) {
                htmx.trigger(this.targetEl, 'confirmed');
            }
            this.open = false;
        }
    }" 
    @open-confirm-warning.window="
        open = true; 
        title = $event.detail.title; 
        message = $event.detail.message; 
        targetEl = $event.detail.target;
        confirmText = $event.detail.confirmText || 'Ya, Lanjutkan';
        playWarningSound();
    "
    x-show="open" 
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-md"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    x-cloak>
    
    <div @click.away="open = false" 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-3xl shadow-2xl border border-gray-100 dark:border-slate-800 p-6 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-1.5 bg-amber-500"></div>

        <div class="flex items-start gap-4 mt-2">
            <div class="flex-shrink-0 w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-amber-600 dark:text-amber-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>

            <div class="flex-1">
                <h3 class="text-lg font-bold text-slate-800 dark:text-white leading-tight" x-text="title"></h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed" x-text="message"></p>
            </div>
        </div>

        <div class="mt-8 flex items-center justify-end gap-3">
            <button @click="open = false" 
                class="flex-1 px-4 py-2.5 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
                Batal
            </button>
            <button @click="confirmAction()" 
                class="flex-1 px-4 py-2.5 text-sm font-bold text-white bg-amber-500 hover:bg-amber-600 active:scale-95 rounded-xl shadow-lg shadow-amber-200 dark:shadow-none transition-all duration-200">
                <span x-text="confirmText"></span>
            </button>
        </div>
    </div>
</div>

<!-- Modal Confirm Danger Global -->
<div x-data="{ 
        open: false, 
        title: '', 
        message: '', 
        confirmText: 'Ya, Hapus',
        targetEl: null,
        
        // Suara Danger: Nada lebih rendah & tegas
        playDangerSound() {
            const context = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = context.createOscillator();
            const gainNode = context.createGain();

            // Jenis gelombang 'triangle' memberikan suara yang lebih berisi/padat daripada 'sine'
            oscillator.type = 'triangle'; 

            // Nada Dasar Dong (Mulai dari 110Hz ke 40Hz)
            oscillator.frequency.setValueAtTime(110, context.currentTime); 
            oscillator.frequency.exponentialRampToValueAtTime(40, context.currentTime + 0.5); 

            // Pengaturan Volume (Gema/Decay)
            // Mulai dari 0.2 agar terdengar mantap, lalu perlahan menghilang
            gainNode.gain.setValueAtTime(0.1, context.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.001, context.currentTime + 0.8);

            oscillator.connect(gainNode);
            gainNode.connect(context.destination);

            oscillator.start();
            oscillator.stop(context.currentTime + 0.8); // Durasi gema lebih lama (0.8 detik)
        },

        confirmAction() {
            if(this.targetEl) {
                htmx.trigger(this.targetEl, 'confirmed');
            }
            this.open = false;
        }
    }" 
    @open-confirm-danger.window="
        open = true; 
        title = $event.detail.title; 
        message = $event.detail.message; 
        targetEl = $event.detail.target;
        confirmText = $event.detail.confirmText || 'Ya, Hapus';
        playDangerSound();
    "
    x-show="open" 
    class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
    x-cloak>
    
    <div @click.away="open = false" 
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95 translate-y-4"
        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
        class="bg-white dark:bg-slate-900 w-full max-w-sm rounded-3xl shadow-2xl border border-red-100 dark:border-red-900/20 p-6 relative overflow-hidden">
        
        <div class="absolute top-0 left-0 w-full h-1.5 bg-red-600"></div>

        <div class="flex flex-col items-center text-center mt-2">
            <div class="w-16 h-16 rounded-full bg-red-50 dark:bg-red-900/20 flex items-center justify-center text-red-600 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </div>

            <h3 class="text-xl font-extrabold text-slate-800 dark:text-white" x-text="title"></h3>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400 leading-relaxed" x-text="message"></p>
        </div>

        <div class="mt-8 flex flex-col gap-2">
            <button @click="confirmAction()" 
                class="w-full py-3 text-sm font-bold text-white bg-red-600 hover:bg-red-700 active:scale-[0.98] rounded-xl shadow-lg shadow-red-200 dark:shadow-none transition-all duration-200">
                <span x-text="confirmText"></span>
            </button>
            <button @click="open = false" 
                class="w-full py-3 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800 rounded-xl transition-colors">
                Batal
            </button>
        </div>
    </div>
</div>