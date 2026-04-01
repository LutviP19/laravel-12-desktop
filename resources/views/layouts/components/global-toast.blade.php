
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
            // Tangkap event sukses dari HTMX secara global
            document.addEventListener('htmx:afterRequest', (event) => {
                const xhr = event.detail.xhr;
                const method = event.detail.requestConfig.method.toUpperCase();
                
                // Jika sukses (200-299) dan bukan GET
                if (xhr.status >= 200 && xhr.status < 300 && method !== 'GET') {
                    this.showAlert('Data berhasil diperbarui', 'success');
                }
            });

            // Listener Manual (Trigger dari Controller)
            document.addEventListener('showToast', (event) => {
                this.showAlert(event.detail.value || 'Berhasil!', 'success');
            });

            // Monitor Koneksi Browser
            window.addEventListener('online', () => { 
                this.showAlert('Kembali Online', 'online');
            });

            window.addEventListener('offline', () => { 
                this.showAlert('Koneksi Terputus', 'offline');
            });

            // Monitor Error Server (HTMX)
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
            'bg-emerald-600 shadow-emerald-200/50': status === 'online' || status === 'success'
        }"
        class="flex items-center gap-3 px-4 py-3 rounded-2xl shadow-2xl text-white border border-white/10 backdrop-blur-md transition-colors duration-500">
        
        <div class="flex-shrink-0">
            <template x-if="status === 'offline'"><svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 010 12.728m0-12.728L5.636 18.364m12.728-12.728L5.636 5.636m12.728 12.728L5.636 18.364" /></svg></template>
            <template x-if="status === 'server_error'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></template>
            <template x-if="status === 'online' || status === 'success'"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg></template>
        </div>

        <div class="flex-1">
            <p class="text-xs font-bold uppercase tracking-widest" x-text="message"></p>
            <p class="text-[10px] opacity-80" x-text="status === 'offline' ? 'Periksa kabel LAN atau Wi-Fi Anda.' : (status === 'server_error' ? 'PHP Server mati atau tidak merespon.' : (status === 'success' ? 'Aksi berhasil dilakukan.' : 'Koneksi jaringan sudah normal kembali.'))"></p>
        </div>

        <button @click="show = false" class="p-1 hover:bg-white/20 rounded-lg">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
    </div>
</div>