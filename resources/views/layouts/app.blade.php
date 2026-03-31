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

    <!-- Tailwind CSS -->
    <script src="{{ asset('assets/js/tailwindcss.js') }}"></script>
    <script>
        // Konfigurasi Tailwind untuk mendukung dark mode class
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <!-- Alpine.js (Logic UI Frontend) -->
    <script defer src="{{ asset('assets/js/alpine.min.js') }}"></script>

    <!-- htmx (Navigasi & Update Partial) -->
    <script src="{{ asset('assets/js/htmx.min.js') }}"></script>
    
    <style>
        .htmx-indicator { opacity: 0; transition: opacity 200ms ease-in; }
        .htmx-request .htmx-indicator { opacity: 1; }
        .htmx-request.htmx-indicator { opacity: 1; }
    </style>
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

    <!-- Script HTMX Global untuk CSRF & Progress Bar -->
    <script>
        document.body.addEventListener('htmx:configRequest', (event) => {
            event.detail.headers['X-CSRF-Token'] = '{{ csrf_token() }}';
        });

        document.body.addEventListener('htmx:configRequest', (event) => {
            event.detail.headers['X-CSRF-Token'] = document.querySelector('meta[name="csrf-token"]').content;
        });
    </script>
</body>
</html>
