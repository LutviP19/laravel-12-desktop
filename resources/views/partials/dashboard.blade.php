<div class="space-y-6 animate-in fade-in duration-500">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-lg shadow-blue-200 dark:shadow-none">
        <h1 class="text-2xl font-bold mb-2">Halo, {{ auth()->user()->name ?? 'Pengguna' }}! 👋</h1>
        <p class="text-blue-100 opacity-90">Selamat datang kembali di panel kendali NativeApp Anda. Semua sistem berjalan normal.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Stat Item 1 -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <span class="text-green-500 text-xs font-bold bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">+12%</span>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Notifikasi</p>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">1,284</h3>
        </div>

        <!-- Stat Item 2 -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Pengguna Aktif</p>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">856</h3>
        </div>

        <!-- Stat Item 3 -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="p-2 bg-amber-50 dark:bg-amber-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
            </div>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Performa Sistem</p>
            <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">99.9%</h3>
        </div>
    </div>

    <!-- Action Section -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 p-8 shadow-sm text-center">
        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-2">Uji Coba Fitur Desktop</h3>
        <p class="text-slate-500 dark:text-slate-400 mb-6">Gunakan tombol di bawah untuk memicu fungsi native sistem operasi Anda.</p>
        
        <div class="flex flex-wrap justify-center gap-4">
            <button 
                hx-post="/notify" 
                hx-target="#notif-status"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl font-semibold transition transform active:scale-95 shadow-md">
                Trigger Notification
            </button>
        </div>
        <div id="notif-status" class="mt-4 text-sm font-medium"></div>
    </div>
</div>