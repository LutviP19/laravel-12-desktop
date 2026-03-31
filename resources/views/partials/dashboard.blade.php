<div class="space-y-6 animate-in fade-in duration-500">
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-lg shadow-blue-200 dark:shadow-none">
        <h1 class="text-2xl font-bold mb-2">Halo, {{ auth()->user()->name ?? 'Pengguna' }}! 👋</h1>
        <p class="text-blue-100 opacity-90 text-sm">Selamat datang kembali di panel kendali NativeApp Anda. Semua sistem berjalan normal.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm transition-all hover:shadow-md"><div class="flex items-center justify-between mb-4"><div class="p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg"><svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg></div><span class="text-green-500 text-xs font-bold bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">+12%</span></div><p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Total Notifikasi</p><h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">1,284</h3></div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm transition-all hover:shadow-md"><div class="flex items-center justify-between mb-4"><div class="p-2 bg-purple-50 dark:bg-purple-900/20 rounded-lg"><svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg></div><span class="text-blue-500 text-xs font-bold bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-full">Stabil</span></div><p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Pengguna Aktif</p><h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">856</h3></div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm transition-all hover:shadow-md"><div class="flex items-center justify-between mb-4"><div class="p-2 bg-amber-50 dark:bg-amber-900/20 rounded-lg"><svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg></div><span class="text-amber-500 text-xs font-bold bg-amber-50 dark:bg-amber-900/20 px-2 py-1 rounded-full">99% Up</span></div><p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Performa Sistem</p><h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100">99.9%</h3></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm"
             x-data="chartComponent()" 
             x-init="initChart()" 
             @dark-mode-toggled.window="updateTheme($event.detail.darkMode)">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-2">
                    <h3 class="font-bold text-slate-800 dark:text-slate-100">Aktivitas Sistem</h3>
                    <div id="chart-loader" class="htmx-indicator">
                        <svg class="animate-spin h-4 w-4 text-blue-600" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <div x-data="{ open: false, label: '7 Hari Terakhir', value: '7' }" class="relative">
                    <input type="hidden" name="days" x-model="value" id="chart-days-input">

                    <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 px-3 py-1.5 bg-gray-50 dark:bg-slate-800/50 hover:bg-gray-100 dark:hover:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-lg text-xs font-bold text-slate-600 dark:text-slate-400 transition-all focus:outline-none">
                        <span x-text="label"></span>
                        <svg class="w-3 h-3 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" class="absolute right-0 mt-2 w-40 bg-white dark:bg-slate-900 border border-gray-100 dark:border-slate-800 rounded-xl shadow-xl z-50 overflow-hidden">
                        
                        <button @click="label = '7 Hari Terakhir'; value = '7'; open = false; $nextTick(() => { htmx.trigger('#htmx-chart-trigger', 'click') })" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 transition-colors">7 Hari Terakhir</button>

                        <button @click="label = '30 Hari Terakhir'; value = '30'; open = false; $nextTick(() => { htmx.trigger('#htmx-chart-trigger', 'click') })" class="w-full text-left px-4 py-2 text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 transition-colors border-t border-gray-50 dark:border-slate-800">30 Hari Terakhir</button>
                    </div>

                    <div id="htmx-chart-trigger" 
                        hx-get="/api/chart-data" 
                        hx-include="#chart-days-input" 
                        hx-indicator="#chart-loader" 
                        hx-swap="none" 
                        @htmx:after-request="updateChartFromResponse($event)" 
                        class="hidden"></div>
                </div>
                
            </div>
            
            <div id="chart-container" class="h-64 w-full">
                <div x-ref="chart"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-gray-100 dark:border-slate-800 shadow-sm overflow-hidden"><h3 class="font-bold text-slate-800 dark:text-slate-100 mb-4">Aktivitas Terkini</h3><div class="overflow-x-auto"><table class="w-full text-left border-collapse"><thead><tr class="border-b border-gray-50 dark:border-slate-800 text-xs text-slate-400 uppercase tracking-wider"><th class="pb-3 font-medium">Tugas</th><th class="pb-3 font-medium">Status</th><th class="pb-3 font-medium text-right">Waktu</th></tr></thead><tbody class="text-sm"><tr class="border-b border-gray-50 dark:border-slate-800/50 hover:bg-gray-50 dark:hover:bg-slate-800/20 transition-colors"><td class="py-3 font-medium text-slate-700 dark:text-slate-300">Update Database SQLite</td><td><span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-600 text-[10px] font-bold rounded-lg uppercase">Selesai</span></td><td class="py-3 text-right text-slate-400">2m ago</td></tr><tr class="border-b border-gray-50 dark:border-slate-800/50 hover:bg-gray-50 dark:hover:bg-slate-800/20 transition-colors"><td class="py-3 font-medium text-slate-700 dark:text-slate-300">Integrasi HTMX View</td><td><span class="px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-600 text-[10px] font-bold rounded-lg uppercase">Proses</span></td><td class="py-3 text-right text-slate-400">1h ago</td></tr><tr class="hover:bg-gray-50 dark:hover:bg-slate-800/20 transition-colors"><td class="py-3 font-medium text-slate-700 dark:text-slate-300">Setup NativePHP Window</td><td><span class="px-2 py-1 bg-gray-100 dark:bg-slate-700 text-slate-500 text-[10px] font-bold rounded-lg uppercase">Antrean</span></td><td class="py-3 text-right text-slate-400">5h ago</td></tr></tbody></table></div></div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-100 dark:border-slate-800 p-8 shadow-sm text-center"><h3 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-2">Aksi Cepat Desktop</h3><p class="text-slate-500 dark:text-slate-400 mb-6 text-sm">Picu fungsi native sistem operasi langsung dari Laravel.</p><div class="flex flex-wrap justify-center gap-4"><button hx-post="/notify" hx-target="#notif-status" class="bg-blue-600 hover:bg-blue-700 active:scale-95 text-white px-6 py-2.5 rounded-xl font-semibold transition shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">Kirim Notifikasi</button><button hx-get="/tasks" class="bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 active:scale-95 text-slate-700 dark:text-slate-200 px-6 py-2.5 rounded-xl font-semibold transition focus:outline-none">Lihat Semua Tugas</button></div><div id="notif-status" class="mt-4 text-xs font-mono text-blue-500 italic uppercase tracking-widest"></div></div>
</div>

@push('scripts')
<!-- ApexCharts.js (Library Chart) -->
<script defer src="{{ asset('assets/js/apexcharts.js') }}"></script>
<script>
    function chartComponent() {
        return {
            chart: null,
            // Cek status dark mode saat ini (asumsi ada class 'dark' di <html>)
            isDark: document.documentElement.classList.contains('dark'),

            initChart() {
                // Cari lib ApexCharts
                if (typeof ApexCharts === 'undefined') {
                    setTimeout(() => this.initChart(), 500);
                    return;
                }

                // Hancurkan instance lama jika ada untuk mencegah memory leak di desktop app
                if (this.chart) { this.chart.destroy(); }

                // Konfigurasi ApexCharts
                const options = {
                    series: [{
                        name: 'Permintaan',
                        // DATA CONTOH (Nanti diganti dengan data dari Laravel)
                        data: [31, 40, 28, 51, 42, 109, 100] 
                    }],
                    chart: {
                        type: 'area',
                        height: '100%',
                        toolbar: { show: false }, // Sembunyikan toolbar bawaan
                        fontFamily: 'inherit',
                        foreColor: this.isDark ? '#94a3b8' : '#64748b', // Warna teks adaptif
                        sparkline: { enabled: false },
                        animations: { enabled: true, speed: 400 }
                    },
                    dataLabels: { enabled: false },
                    stroke: { curve: 'smooth', width: 2 },
                    // Warna garis biru konsisten
                    colors: ['#2563eb'], 
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: this.isDark ? 0.4 : 0.6,
                            opacityTo: 0.1,
                            stops: [0, 90, 100]
                        }
                    },
                    grid: {
                        borderColor: this.isDark ? '#334155' : '#e2e8f0', // Warna grid adaptif
                        xaxis: { lines: { show: true } },
                        yaxis: { lines: { show: false } }
                    },
                    xaxis: {
                        type: 'category',
                        // LABEL CONTOH (Nanti diganti dengan data dari Laravel)
                        categories: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
                        axisBorder: { show: false },
                        axisTicks: { show: false }
                    },
                    yaxis: { show: false },
                    tooltip: {
                        theme: this.isDark ? 'dark' : 'light',
                        x: { show: true },
                        marker: { show: false }
                    },
                    noData: { text: 'Memuat data...', style: { color: '#94a3b8' } }
                };
                
                // // Pastikan element container ada sebelum render
                // const container = this.$refs.chart;
                // if (container) {
                //     // Inisialisasi Chart
                //     this.chart = new ApexCharts(container, options);
                //     this.chart.render();
                // }

                this.chart = new ApexCharts(this.$refs.chart, options);
                this.chart.render();

                // 3. FIRST LOAD: Panggil data secara otomatis
                // this.fetchData();
            },

            // fetchData() {
            //     // Gunakan htmx.ajax untuk menarik data awal
            //     // Kita ambil value dari input hidden 'days' (default 7)
            //     const daysValue = document.getElementById('chart-days-input')?.value || '7';
                
            //     htmx.ajax('GET', '/api/chart-data', {
            //         values: { days: daysValue },
            //         indicator: '#chart-loader',
            //         swap: 'none',
            //         // Handler manual jika ingin langsung diproses di sini
            //         handler: (elt, config) => {
            //             // config.xhr berisi objek XMLHttpRequest asli
            //             // Kita perlu menunggu sampai statusnya 4 (Done)
            //             config.xhr.addEventListener('load', () => {
            //                 if (config.xhr.status >= 200 && config.xhr.status < 300) {
            //                     const responseData = JSON.parse(config.xhr.responseText);
            //                     console.log("Data diterima:", responseData);
                                
            //                     // Panggil fungsi update chart
            //                     this.updateChartManual(responseData);
            //                 }
            //             });
            //         }
            //     });
            // },

            updateChartFromResponse(event) {
                if (event.detail.successful) {
                    try {
                        const response = JSON.parse(event.detail.xhr.responseText);
                        
                        // Gabungkan pembaruan dalam satu call untuk efisiensi render
                        this.chart.updateOptions({
                            series: response.series,
                            xaxis: { 
                                categories: response.categories 
                            }
                        }, false, true); // (redrawPaths: false, animate: true)
                        
                    } catch (e) {
                        console.error("Gagal memproses data chart:", e);
                    }
                }
            },

            // Fungsi untuk menangani perubahan tema (panggil event 'dark-mode-toggled')
            updateTheme(darkMode) {
                this.isDark = darkMode;
                if(this.chart) {
                    this.chart.updateOptions({
                        chart: { foreColor: this.isDark ? '#94a3b8' : '#64748b' },
                        grid: { borderColor: this.isDark ? '#334155' : '#e2e8f0' },
                        fill: { gradient: { opacityFrom: this.isDark ? 0.4 : 0.6 } },
                        tooltip: { theme: this.isDark ? 'dark' : 'light' }
                    });
                }
            }
        }
    }
</script>
@endpush