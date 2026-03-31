<!DOCTYPE html>
<html lang="id" 
      x-data="{ 
        darkMode: localStorage.getItem('darkMode') === 'true' || 
                 (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) 
      }" 
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Native App - @yield('title', 'Dashboard')</title>

    <!-- htmx (Navigasi & Update Partial) -->
    <script src="{{ asset('assets/js/htmx.min.js') }}"></script>

    <!-- Tailwind CSS -->
    <script src="{{ asset('assets/js/tailwindcss.js') }}"></script>
    <script>
        // Konfigurasi Tailwind untuk mendukung dark mode class
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .htmx-indicator { opacity: 0; transition: opacity 200ms ease-in; }
        .htmx-request .htmx-indicator { opacity: 1; }
        .htmx-request.htmx-indicator { opacity: 1; }
    </style>
</head>
<body 
    hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}' 
    hx-history="true" 
    class="bg-gray-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 transition-colors duration-300">

    <div class="flex h-screen" x-data="{ sidebarOpen: true }">
        
        <!-- Sidebar -->
        @auth
        <aside class="flex flex-col h-screen bg-white dark:bg-slate-900 border-r border-gray-200 dark:border-slate-800 transition-all duration-300 sticky top-0"
            :class="sidebarOpen ? 'w-64' : 'w-20'">
            
            <!-- Header Sidebar -->
            <div class="h-16 flex items-center border-b border-gray-100 dark:border-slate-800 shrink-0"
                :class="sidebarOpen ? 'px-6 justify-between' : 'justify-center'">
                
                <span x-show="sidebarOpen" x-transition.opacity class="font-bold text-blue-600 dark:text-blue-400 whitespace-nowrap">
                    NativeApp
                </span>

                <button @click="sidebarOpen = !sidebarOpen" 
                        class="p-2 rounded-lg text-gray-500 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors outline-none">
                    <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" 
                        class="w-6 h-6 transition-transform duration-300"
                        :class="{ 'rotate-180': !sidebarOpen }">
                        
                        <!-- Animasi Dinamis Hamburger ke Silang -->
                        <path x-show="!sidebarOpen" stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        <path x-show="sidebarOpen" stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Menu Navigasi (Flex-1 membuat area ini mengambil sisa ruang) -->
            <div class="flex-1 overflow-y-auto py-4 overflow-x-hidden">
                @include('partials.sidebar')
            </div>

            <!-- Footer Sidebar (mt-auto memaksanya ke bawah) -->
            <div class="p-4 border-t border-gray-100 dark:border-slate-800 mt-auto shrink-0 transition-colors bg-gray-50/50 dark:bg-slate-900/50">
                <div x-show="sidebarOpen" x-transition.opacity class="text-[10px] uppercase tracking-wider font-semibold text-slate-400 dark:text-slate-500">
                    Laravel 12 + NativePHP
                </div>
                <!-- Ikon kecil saat sidebar tertutup -->
                <div x-show="!sidebarOpen" class="flex justify-center text-blue-500 font-bold text-xs">
                    v1.0
                </div>
            </div>
        </aside>
        @endauth


        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-hidden">
            <!-- Header/Top Bar -->
            <header class="bg-white dark:bg-slate-900 h-16 flex items-center px-8 justify-between border-b border-gray-200 dark:border-slate-800 sticky top-0 z-40 transition-colors duration-300">
                
                <!-- Bagian Kiri: Judul Halaman -->
                <div class="flex items-center">
                    <h2 class="text-lg font-bold text-slate-800 dark:text-slate-100 tracking-tight">
                        @yield('title', 'Dashboard')
                    </h2>
                </div>

                <!-- Bagian Kanan: Aksi & Profil -->
                <div class="flex items-center space-x-5">
                    
                    <!-- Tombol Toggle Dark Mode -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                            class="p-2 rounded-xl bg-gray-50 dark:bg-slate-800 text-gray-500 dark:text-yellow-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-all duration-200 focus:outline-none">
                        <!-- Icon Sun -->
                        <svg x-show="darkMode" xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M3 12h2.25m.386-4.773 1.591-1.591M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z" />
                        </svg>
                        <!-- Icon Moon -->
                        <svg x-show="!darkMode" xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>

                    <!-- Divider -->
                    @auth
                    <div class="h-6 w-px bg-gray-200 dark:bg-slate-700"></div>

                    <!-- Dropdown Profil -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center group space-x-3 focus:outline-none">
                            <div class="flex flex-col text-right hidden sm:flex">
                                <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ auth()->user()->name ?? 'User' }}
                                </span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-widest">Administrator</span>
                            </div>
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200 dark:shadow-none transition-transform group-hover:scale-105">
                                {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                            class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-2xl shadow-2xl z-50 py-2 overflow-hidden"
                            style="display: none;">
                            
                            <div class="px-4 py-2 border-b border-gray-50 dark:border-slate-800 mb-1">
                                <p class="text-xs text-slate-400">Signed in as</p>
                                <p class="text-sm font-medium text-slate-700 dark:text-slate-200 truncate">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                            </div>

                            <a href="#" class="flex items-center px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profile Settings
                            </a>
                            
                            <hr class="my-1 border-gray-50 dark:border-slate-800">
                            
                            <form hx-post="/logout" hx-trigger="click" class="cursor-pointer">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors font-medium">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                    @endauth
                </div>
            </header>

            <!-- Content Placeholder -->
            <section id="main-content" class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </section>
        </main>
    </div>


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
    
    <!-- Toast Global Cek Status Jaringan -->
    <div x-data="{ 
            status: !navigator.onLine ? 'offline' : 'online',
            show: false,
            message: '',
            timer: null,

            // Fungsi untuk menampilkan toast dan mengatur auto-close
            showAlert(msg, stat) {
                this.status = stat;
                this.message = msg;
                this.show = true;

                // Bersihkan timer sebelumnya jika ada (reset timer)
                if (this.timer) clearTimeout(this.timer);

                // Set timer baru untuk menutup setelah 10 detik (10000 ms)
                // Khusus status 'offline', kita biarkan tetap muncul (optional) 
                // Tapi jika ingin semua auto-close, gunakan kode di bawah:
                this.timer = setTimeout(() => {
                    this.show = false;
                }, 10000);
            },
            
            init() {
                // 1. Monitor Koneksi Browser
                window.addEventListener('online', () => { 
                    this.showAlert('Kembali Online', 'online');
                });

                window.addEventListener('offline', () => { 
                    this.showAlert('Koneksi Terputus', 'offline');
                });

                // 2. Monitor Error Server (HTMX)
                document.addEventListener('htmx:sendError', () => {
                    this.showAlert('Server Tidak Terjangkau', 'server_error');
                });

                document.addEventListener('htmx:responseError', (event) => {
                    if(event.detail.xhr.status >= 500) {
                        this.showAlert('Server Bermasalah (500)', 'server_error');
                    }
                });

                // Cek kondisi awal
                if(!navigator.onLine) { 
                    this.showAlert('Koneksi Terputus', 'offline');
                }
            }
        }"
        x-show="show"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-20 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-6 left-1/2 -translate-x-1/2 z-[200] w-full max-w-xs"
    >
        <div :class="{
                'bg-red-600 shadow-red-200/50': status === 'offline',
                'bg-amber-600 shadow-amber-200/50': status === 'server_error',
                'bg-emerald-600 shadow-emerald-200/50': status === 'online'
            }"
            class="flex items-center gap-3 px-4 py-3 rounded-2xl shadow-2xl text-white border border-white/10 backdrop-blur-md transition-colors duration-500">
            
            <div class="flex-shrink-0">
                <template x-if="status === 'offline'"><svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0-12.728L5.636 18.364m12.728-12.728L5.636 5.636m12.728 12.728L5.636 18.364" /></svg></template>
                <template x-if="status === 'server_error'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></template>
                <template x-if="status === 'online'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></template>
            </div>

            <div class="flex-1">
                <p class="text-xs font-bold uppercase tracking-widest" x-text="message"></p>
                <p class="text-[10px] opacity-80" x-text="status === 'offline' ? 'Periksa kabel LAN atau Wi-Fi Anda.' : (status === 'server_error' ? 'PHP Server mati atau tidak merespon.' : 'Koneksi jaringan sudah normal kembali.')"></p>
            </div>

            <button @click="show = false" class="p-1 hover:bg-white/20 rounded-lg">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
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

    <!-- Script HTMX Global untuk CSRF & Progress Bar -->
    <script>
        document.body.addEventListener('htmx:configRequest', (event) => {
            // Ambil token dari meta tag atau input hidden
            const token = document.querySelector('meta[name="csrf-token"]')?.content;
            if (token) {
                event.detail.headers['X-CSRF-Token'] = token;
            } else {
                event.detail.headers['X-CSRF-Token'] = '{{ csrf_token() }}';
            }
        });
    </script>

    @stack('scripts')

    <!-- Alpine.js (Logic UI Frontend) -->
    <script defer src="{{ asset('assets/js/alpine.min.js') }}"></script>
</body>
</html>
