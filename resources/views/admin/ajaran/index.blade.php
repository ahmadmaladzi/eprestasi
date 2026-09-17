<x-app-layout title="Tahun Ajaran">
    <div class="grid lg:grid-cols-[1fr_320px] gap-6 items-start">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 text-left text-slate-500">
                    <tr>
                        <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Tahun Ajaran</th>
                        <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Status</th>
                        <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Total Prestasi</th>
                        <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($daftarAjaran as $ajaran)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-5 py-4 font-medium text-slate-800">{{ $ajaran->tahun }}</td>
                            <td class="px-5 py-4">
                                @if($ajaran->status === 'Aktif')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-[#22C55E]/10 text-[#16A34A]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A]"></span> Aktif
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $ajaran->prestasi_count ?? $ajaran->prestasi()->count() }}</td>
                            <td class="px-5 py-4">
                                @if($ajaran->status !== 'Aktif')
                                    <form method="POST" action="{{ route('admin.ajaran.update', $ajaran) }}" onsubmit="return confirm('Jadikan {{ $ajaran->tahun }} sebagai tahun ajaran aktif?')">
                                        @csrf @method('PUT')
                                        <button class="text-[#2F6FED] hover:text-[#1B4FC4] font-medium text-xs">Jadikan Aktif</button>
                                    </form>
                                @else
                                    <span class="text-slate-300 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-14 text-center text-sm text-slate-400">Belum ada tahun ajaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-6">
            <h3 class="font-semibold text-sm text-slate-800 mb-1">Tambah Tahun Ajaran</h3>
            <p class="text-xs text-slate-400 mb-4">Tahun ajaran baru otomatis nonaktif, aktifkan manual kalau sudah siap dipakai.</p>
            <form method="POST" action="{{ route('admin.ajaran.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Format Tahun</label>
                    <input type="text" name="tahun" value="{{ old('tahun') }}" placeholder="Contoh: 2026/2027"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    @error('tahun') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
                <button class="w-full bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
                    Tambah
                </button>
            </form>
        </div>
    </div>
</x-app-layout>