<x-app-layout title="Tahun Ajaran">
    <div class="grid md:grid-cols-3 gap-6">
        <div class="md:col-span-1 bg-white rounded-lg shadow-sm p-4">
            <h3 class="font-medium text-gray-700 mb-3">Tambah Tahun Ajaran</h3>
            <form method="POST" action="{{ route('admin.ajaran.store') }}" class="space-y-3">
                @csrf
                <input type="text" name="tahun" placeholder="Contoh: 2026/2027" class="w-full rounded border-gray-300 text-sm">
                <select name="status" class="w-full rounded border-gray-300 text-sm">
                    <option value="Tidak Aktif">Tidak Aktif</option>
                    <option value="Aktif">Aktif</option>
                </select>
                <button class="bg-slate-800 text-white px-4 py-2 rounded text-sm w-full hover:bg-slate-700">Simpan</button>
            </form>
            <p class="text-xs text-gray-500 mt-2">Kalau dipilih "Aktif", tahun ajaran lain otomatis jadi "Tidak Aktif" (hanya boleh 1 yang aktif).</p>
        </div>

        <div class="md:col-span-2 bg-white rounded-lg shadow-sm overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr>
                        <th class="px-4 py-3">Tahun</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($ajaran as $a)
                        <tr>
                            <td class="px-4 py-3">{{ $a->tahun }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded text-xs {{ $a->status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">{{ $a->status }}</span>
                            </td>
                            <td class="px-4 py-3 space-x-2">
                                @if($a->status !== 'Aktif')
                                    <form method="POST" action="{{ route('admin.ajaran.update', $a) }}" class="inline">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status" value="Aktif">
                                        <button class="text-green-600 hover:underline">Aktifkan</button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.ajaran.destroy', $a) }}" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-4 py-6 text-center text-gray-500">Belum ada tahun ajaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="p-4">{{ $ajaran->links() }}</div>
        </div>
    </div>
</x-app-layout>
