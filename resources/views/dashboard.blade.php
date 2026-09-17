<x-app-layout title="Dashboard">
    <div class="flex items-center justify-between mb-7">
        <div>
            <h1 class="text-xl font-extrabold text-slate-900">Halo, {{ $siswa->nama }} 👋</h1>
            <p class="text-sm text-slate-500 mt-1">Ini ringkasan prestasi kamu sejauh ini.</p>
        </div>
        <a href="{{ route('siswa.prestasi.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="white" stroke-width="2.2" stroke-linecap="round"/></svg>
            Ajukan Prestasi
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="w-9 h-9 rounded-lg bg-[#2F6FED]/10 flex items-center justify-center mb-3">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="16" height="16" rx="2" stroke="#2F6FED" stroke-width="1.6"/><path d="M8 9H16M8 13H13" stroke="#2F6FED" stroke-width="1.6" stroke-linecap="round"/></svg>
            </div>
            <p class="text-xs text-slate-400 mb-1">Total Prestasi</p>
            <p class="text-2xl font-extrabold text-slate-900">{{ $totalPrestasi }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="w-9 h-9 rounded-lg bg-[#22C55E]/10 flex items-center justify-center mb-3">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="#16A34A" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </div>
            <p class="text-xs text-slate-400 mb-1">Disetujui</p>
            <p class="text-2xl font-extrabold text-[#16A34A]">{{ $totalDisetujui }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="w-9 h-9 rounded-lg bg-[#F59E0B]/10 flex items-center justify-center mb-3">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="#D97706" stroke-width="1.8"/><path d="M12 7V12L15 14" stroke="#D97706" stroke-width="1.8" stroke-linecap="round"/></svg>
            </div>
            <p class="text-xs text-slate-400 mb-1">Menunggu</p>
            <p class="text-2xl font-extrabold text-[#D97706]">{{ $totalMenunggu }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-slate-200 p-5">
            <div class="w-9 h-9 rounded-lg bg-red-50 flex items-center justify-center mb-3">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M6 6L18 18M18 6L6 18" stroke="#DC2626" stroke-width="2" stroke-linecap="round"/></svg>
            </div>
            <p class="text-xs text-slate-400 mb-1">Ditolak</p>
            <p class="text-2xl font-extrabold text-red-600">{{ $totalDitolak }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-semibold text-slate-800 text-sm">Prestasi Terbaru</h2>
            <a href="{{ route('siswa.prestasi.index') }}" class="text-xs font-semibold text-[#2F6FED] hover:text-[#1B4FC4]">Lihat semua →</a>
        </div>

        @forelse($prestasiTerbaru as $item)
            <div class="px-5 py-4 border-b border-slate-50 last:border-0 flex items-center justify-between hover:bg-slate-50/50 transition">
                <div class="flex items-center gap-3.5">
                    @php
                        $iconBg = match($item->status) {
                            'Disetujui' => 'bg-[#22C55E]/10',
                            'Ditolak' => 'bg-red-50',
                            default => 'bg-[#F59E0B]/10',
                        };
                        $iconColor = match($item->status) {
                            'Disetujui' => '#16A34A',
                            'Ditolak' => '#DC2626',
                            default => '#D97706',
                        };
                    @endphp
                    <div class="w-9 h-9 rounded-lg {{ $iconBg }} flex items-center justify-center shrink-0">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 8.5L21 9L16 13.5L17.5 20L12 16.5L6.5 20L8 13.5L3 9L9.5 8.5L12 2Z" fill="{{ $iconColor }}"/></svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-800">{{ $item->nama_prestasi }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $item->tingkat }} &middot; {{ $item->tanggal->format('d M Y') }}</p>
                    </div>
                </div>
                @php
                    $badge = match($item->status) {
                        'Disetujui' => 'bg-[#22C55E]/10 text-[#16A34A]',
                        'Ditolak' => 'bg-red-50 text-red-600',
                        default => 'bg-[#F59E0B]/10 text-[#D97706]',
                    };
                @endphp
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $item->status }}</span>
            </div>
        @empty
            <div class="px-5 py-12 text-center">
                <p class="text-sm text-slate-400 mb-1">Belum ada prestasi yang diajukan.</p>
                <a href="{{ route('siswa.prestasi.create') }}" class="text-xs font-semibold text-[#2F6FED] hover:text-[#1B4FC4]">Ajukan prestasi pertamamu →</a>
            </div>
        @endforelse
    </div>
</x-app-layout>