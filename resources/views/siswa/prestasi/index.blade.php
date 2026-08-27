<x-app-layout title="Prestasi Saya">
    <div class="flex justify-between items-center mb-4">
        <p class="text-sm text-gray-500">Kelola prestasi kamu di sini.</p>
        <a href="{{ route('siswa.prestasi.create') }}" class="bg-slate-800 text-white px-4 py-2 rounded text-sm hover:bg-slate-700">+ Ajukan Prestasi</a>
    </div>

    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-left text-gray-600">
                <tr>
                    <th class="px-4 py-3">Nama Prestasi</th>
                    <th class="px-4 py-3">Tingkat</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($prestasi as $item)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $item->nama_prestasi }}</td>
                        <td class="px-4 py-3">{{ $item->tingkat }}</td>
                        <td class="px-4 py-3">{{ $item->tanggal->format('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $item->kategori ?? '-' }}</td>
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
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('siswa.prestasi.show', $item) }}" class="text-blue-600 hover:underline">Lihat</a>
                            @if($item->status !== 'Disetujui')
                                <a href="{{ route('siswa.prestasi.edit', $item) }}" class="text-amber-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('siswa.prestasi.destroy', $item) }}" class="inline" onsubmit="return confirm('Yakin hapus prestasi ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada prestasi yang diajukan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $prestasi->links() }}</div>
</x-app-layout>
