<x-app-layout title="Prestasi Saya">
    <div class="flex justify-between items-center mb-5">
        <p class="text-sm text-slate-500">Kelola prestasi kamu di sini.</p>
        <a href="{{ route('siswa.prestasi.create') }}"
           class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="white" stroke-width="2.2" stroke-linecap="round"/></svg>
            Ajukan Prestasi
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500">
                <tr>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Nama Prestasi</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Tingkat</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Tanggal</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Kategori</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Status</th>
                    <th class="px-5 py-3.5 font-semibold text-xs uppercase tracking-wide">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($prestasi as $item)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="px-5 py-4 font-medium text-slate-800">{{ $item->nama_prestasi }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $item->tingkat }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $item->tanggal->format('d M Y') }}</td>
                        <td class="px-5 py-4 text-slate-600">{{ $item->kategori ?? '—' }}</td>
                        <td class="px-5 py-4">
                            @php
                                $badge = match($item->status) {
                                    'Disetujui' => 'bg-[#22C55E]/10 text-[#16A34A]',
                                    'Ditolak' => 'bg-red-50 text-red-600',
                                    default => 'bg-[#F59E0B]/10 text-[#D97706]',
                                };
                            @endphp
                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $item->status }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-3.5">
                                <a href="{{ route('siswa.prestasi.show', $item) }}" class="text-[#2F6FED] hover:text-[#1B4FC4] font-medium text-xs">Lihat</a>
                                @if($item->status !== 'Disetujui')
                                    <a href="{{ route('siswa.prestasi.edit', $item) }}" class="text-[#D97706] hover:text-amber-700 font-medium text-xs">Edit</a>
                                    <form method="POST" action="{{ route('siswa.prestasi.destroy', $item) }}" class="inline" onsubmit="return confirm('Yakin hapus prestasi ini?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-700 font-medium text-xs">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-5 py-14 text-center text-sm text-slate-400">Belum ada prestasi yang diajukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $prestasi->links() }}</div>
</x-app-layout>