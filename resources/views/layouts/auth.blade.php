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
    <title>NativeApp - @yield('title')</title>

    <!-- htmx (Navigasi & Update Partial) -->
    <script src="{{ asset('assets/js/htmx.min.js') }}"></script>

    <!-- Tailwind CSS -->
    <script src="{{ asset('assets/js/tailwindcss.js') }}"></script>
    <script>
        // Inject config jika menggunakan Tailwind Play CDN/Standalone script
        tailwind.config = { darkMode: 'class' }
    </script>

    <!-- Alpine.js (Logic UI Frontend) -->
    <script defer src="{{ asset('assets/js/alpine.min.js') }}"></script>    
</head>
<body class="bg-slate-100 dark:bg-slate-950 font-sans antialiased transition-colors duration-300" 
      hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>

    <div class="min-h-screen flex flex-col justify-center items-center p-6">

        <!-- Tombol Toggle Tema (Opsional di halaman Auth agar user nyaman) -->
        <div class="absolute top-6 right-6">
            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                    class="p-2 rounded-full bg-white dark:bg-slate-900 shadow-sm border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-yellow-400">
                <svg x-show="darkMode" xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M3 12h2.25m.386-4.773 1.591-1.591M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z" /></svg>
                <svg x-show="!darkMode" xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" /></svg>
            </button>
        </div>

        <!-- Logo Area -->
        <div class="mb-8 flex flex-col items-center">
            <div class="w-16 h-16 bg-blue-600 dark:bg-blue-500 rounded-2xl shadow-lg flex items-center justify-center mb-4 transform hover:scale-105 transition">
                <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 dark:text-slate-100">NativeApp Desktop</h1>
            <p class="text-slate-500 dark:text-slate-400">Silakan masuk untuk melanjutkan</p>
        </div>

        <!-- Container Utama (Tempat Form Berada) -->
        <main id="auth-content" class="w-full max-w-md">
            @yield('content')
        </main>

        <footer class="mt-8 text-slate-400 dark:text-slate-600 text-sm">
            &copy; {{ date('Y') }} NativePHP Project
        </footer>
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

    <script>
        document.body.addEventListener('htmx:configRequest', (event) => {
            event.detail.headers['X-CSRF-Token'] = '{{ csrf_token() }}';
        });
    </script>
</body>
</html>
