<x-app-layout title="Dashboard">
    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-900">Halo, {{ $siswa->nama }} 👋</h1>
        <p class="text-sm text-slate-500 mt-1">Ini ringkasan prestasi kamu sejauh ini.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-slate-800">
            <p class="text-xs text-slate-400 mb-1">Total Prestasi</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalPrestasi }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-green-500">
            <p class="text-xs text-slate-400 mb-1">Disetujui</p>
            <p class="text-2xl font-bold text-green-700">{{ $totalDisetujui }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-yellow-500">
            <p class="text-xs text-slate-400 mb-1">Menunggu</p>
            <p class="text-2xl font-bold text-yellow-700">{{ $totalMenunggu }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-sm p-5 border-l-4 border-red-500">
            <p class="text-xs text-slate-400 mb-1">Ditolak</p>
            <p class="text-2xl font-bold text-red-700">{{ $totalDitolak }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden mb-6">
        <div class="px-4 py-3 border-b flex items-center justify-between">
            <h2 class="font-semibold text-slate-800 text-sm">Prestasi Terbaru</h2>
            <a href="{{ route('siswa.prestasi.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua</a>
        </div>

        @forelse($prestasiTerbaru as $item)
            <div class="px-4 py-3 border-b last:border-0 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-800">{{ $item->nama_prestasi }}</p>
                    <p class="text-xs text-slate-400">{{ $item->tingkat }} &middot; {{ $item->tanggal->format('d M Y') }}</p>
                </div>
                @php
                    $color = match($item->status) {
                        'Disetujui' => 'bg-green-100 text-green-800',
                        'Ditolak' => 'bg-red-100 text-red-800',
                        default => 'bg-yellow-100 text-yellow-800',
                    };
                @endphp
                <span class="px-2 py-1 rounded text-xs {{ $color }}">{{ $item->status }}</span>
            </div>
        @empty
            <div class="px-4 py-8 text-center text-sm text-slate-400">
                Belum ada prestasi yang diajukan.
            </div>
        @endforelse
    </div>

    <a href="{{ route('siswa.prestasi.create') }}" class="inline-flex items-center gap-2 bg-slate-800 text-white px-4 py-2.5 rounded text-sm font-semibold hover:bg-slate-700">
        + Ajukan Prestasi Baru
    </a>
</x-app-layout>