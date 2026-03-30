<!-- HTMX -->
<script src="{{ asset('assets/js/htmx.min.js') }}"></script>

<div class="p-6">
    <h1 class="text-2xl font-bold">Detail Notifikasi</h1>

    @if($id)
        <p>ID Terdeteksi: <span class="font-mono text-blue-600">{{ $id }}</span></p>
    @else
        <p class="text-red-500">Peringatan: Tidak ada ID yang ditemukan.</p>
    @endif
    
    <!-- <button 
        hx-get="/" 
        hx-target="#main-content" 
        hx-select="#main-content"
        class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
        Kembali ke Dashboard
    </button> -->

    <a href="{{ url('/') }}" class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded">
        Kembali ke Dashboard
    </a>
</div>