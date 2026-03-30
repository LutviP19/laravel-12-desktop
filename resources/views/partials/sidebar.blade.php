<nav class="flex-1 mt-4 px-3 space-y-2"
     x-data="{ currentPath: window.location.pathname }"
     @htmx:after-settle.window="currentPath = window.location.pathname">
    <!-- Dashboard -->
    <a hx-get="/dashboard-partial" hx-target="#main-content" hx-push-url="/dashboard"
        class="flex items-center p-3 rounded-lg cursor-pointer transition group"  
        :class="currentPath.startsWith('/dashboard') || currentPath === '/'
            ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' 
            : 'text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400'">
        
        <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
            class="w-6 h-6 mr-3 transition-colors"
            :class="currentPath.startsWith('/dashboard') || currentPath === '/' ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400 group-hover:text-blue-600 dark:group-hover:text-blue-400'">
            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>
        <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
    </a>
    
    <!-- Notifikasi -->
    <a hx-get="/notification-partial" hx-target="#main-content" hx-push-url="/notification-detail"
        class="flex items-center p-3 rounded-lg cursor-pointer transition group"
        :class="currentPath.startsWith('/notification') 
            ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' 
            : 'text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800 hover:text-blue-600 dark:hover:text-blue-400'">
        
        <svg xmlns="http://www.w3.org" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
            class="w-6 h-6 mr-3 transition-colors"
            :class="currentPath.startsWith('/notification') ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400 group-hover:text-blue-600 dark:group-hover:text-blue-400'">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>
        <span x-show="sidebarOpen" class="font-medium">Notifikasi</span>
    </a>
</nav>