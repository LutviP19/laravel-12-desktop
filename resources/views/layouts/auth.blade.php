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

    <!-- Tailwind CSS -->
    <script src="{{ asset('assets/js/tailwindcss.js') }}"></script>
    <script>
        // Inject config jika menggunakan Tailwind Play CDN/Standalone script
        tailwind.config = { darkMode: 'class' }
    </script>

    <!-- Alpine.js (Logic UI Frontend) -->
    <script defer src="{{ asset('assets/js/alpine.min.js') }}"></script>

    <!-- htmx (Navigasi & Update Partial) -->
    <script src="{{ asset('assets/js/htmx.min.js') }}"></script>
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

    <script>
        document.body.addEventListener('htmx:configRequest', (event) => {
            event.detail.headers['X-CSRF-Token'] = '{{ csrf_token() }}';
        });
    </script>
</body>
</html>
