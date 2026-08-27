<x-app-layout title="Verifikasi Prestasi">
    <form method="GET" class="mb-4 flex flex-wrap gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa/prestasi..." class="rounded border-gray-300 text-sm flex-1 min-w-[200px]">
        <select name="tahun_ajaran" class="rounded border-gray-300 text-sm">
            @foreach($daftarAjaran as $ajaran)
                <option value="{{ $ajaran->id_ajaran }}" {{ (string) request('tahun_ajaran', optional($daftarAjaran->firstWhere('status', 'Aktif'))->id_ajaran) === (string) $ajaran->id_ajaran ? 'selected' : '' }}>
                    {{ $ajaran->tahun }}{{ $ajaran->status === 'Aktif' ? ' (Aktif)' : '' }}
                </option>
            @endforeach
            <option value="semua" {{ request('tahun_ajaran') == 'semua' ? 'selected' : '' }}>Semua Tahun</option>
        </select>
        <select name="status" class="rounded border-gray-300 text-sm">
            <option value="">Semua Status</option>
            <option value="Belum" {{ request('status') == 'Belum' ? 'selected' : '' }}>Belum</option>
            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <button class="bg-slate-800 text-white px-4 py-2 rounded text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Siswa</th>
                    <th class="px-4 py-3">Prestasi</th>
                    <th class="px-4 py-3">Tingkat</th>
                    <th class="px-4 py-3">Tahun Ajaran</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($prestasi as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->siswa->nama }}</td>
                        <td class="px-4 py-3 font-medium">{{ $item->nama_prestasi }}</td>
                        <td class="px-4 py-3">{{ $item->tingkat }}</td>
                        <td class="px-4 py-3">{{ $item->tahunAjaran->tahun }}</td>
                        <td class="px-4 py-3">{{ $item->tanggal->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @php
                                $color = match($item->status) {
                                    'Disetujui' => 'bg-green-100 text-green-800',
                                    'Ditolak' => 'bg-red-100 text-red-800',
                                    default => 'bg-yellow-100 text-yellow-800',
                                };
                            @endphp
                            <span class="px-2 py-1 rounded text-xs {{ $color }}">{{ $item->status }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('kesiswaan.prestasi.show', $item) }}" class="text-blue-600 hover:underline">Lihat Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="px-4 py-6 text-center text-gray-500">Tidak ada prestasi untuk filter ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $prestasi->links() }}</div>
</x-app-layout>
