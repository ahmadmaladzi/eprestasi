<x-app-layout title="Detail Verifikasi">
    <div class="max-w-2xl bg-white rounded-lg shadow-sm p-6 space-y-4" x-data="{ status: '{{ $prestasi->status === 'Belum' ? '' : $prestasi->status }}' }">
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $prestasi->nama_prestasi }}</h2>
            <p class="text-sm text-gray-500">
                Diajukan oleh <strong>{{ $prestasi->siswa->nama }}</strong> ({{ $prestasi->siswa->nis }}) &middot;
                {{ $prestasi->penyelenggara }} &middot; {{ $prestasi->tingkat }} &middot; {{ $prestasi->tanggal->format('d M Y') }}
            </p>
        </div>

        <div>
            <h3 class="font-medium text-gray-700 mb-1">Deskripsi</h3>
            <p class="text-sm text-gray-600">{{ $prestasi->deskripsi ?: '-' }}</p>
        </div>

        <div>
            <h3 class="font-medium text-gray-700 mb-2">Sertifikat</h3>
            <ul class="space-y-1 text-sm">
                @forelse($prestasi->sertifikat as $s)
                    <li><a href="{{ Storage::url($s->file_path) }}" target="_blank" class="text-blue-600 hover:underline">{{ $s->nama_file }}</a></li>
                @empty
                    <li class="text-gray-500">Tidak ada sertifikat.</li>
                @endforelse
            </ul>
        </div>

        <div>
            <h3 class="font-medium text-gray-700 mb-2">Dokumentasi Foto</h3>
            <div class="grid grid-cols-3 gap-2">
                @forelse($prestasi->dokumentasi as $d)
                    <img src="{{ Storage::url($d->foto) }}" class="rounded border w-full h-24 object-cover">
                @empty
                    <p class="text-gray-500 text-sm">Tidak ada dokumentasi foto.</p>
                @endforelse
            </div>
        </div>

        @if($prestasi->status === 'Belum')
            <form method="POST" action="{{ route('kesiswaan.prestasi.verifikasi', $prestasi) }}" class="space-y-3 pt-4 border-t">
                @csrf
                <input type="hidden" name="status" x-model="status">

                <div class="flex gap-3">
                    <button type="button" @click="status = 'Disetujui'" :class="status === 'Disetujui' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded text-sm">Setujui</button>
                    <button type="button" @click="status = 'Ditolak'" :class="status === 'Ditolak' ? 'bg-red-600 text-white' : 'bg-gray-100 text-gray-700'" class="px-4 py-2 rounded text-sm">Tolak</button>
                </div>

                <div x-show="status === 'Disetujui'" x-cloak>
                    <label class="block text-sm font-medium text-gray-700">Kategori Prestasi</label>
                    <select name="kategori" class="mt-1 block w-full rounded border-gray-300">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Non Akademik">Non Akademik</option>
                        <option value="Kejuaraan">Kejuaraan</option>
                    </select>
                </div>

                <div x-show="status === 'Ditolak'" x-cloak>
                    <label class="block text-sm font-medium text-gray-700">Catatan Penolakan</label>
                    <textarea name="catatan" rows="2" class="mt-1 block w-full rounded border-gray-300" placeholder="Contoh: sertifikat kurang jelas, mohon upload ulang"></textarea>
                </div>

                <button type="submit" x-show="status" x-cloak class="bg-slate-800 text-white px-4 py-2 rounded text-sm hover:bg-slate-700">Kirim Verifikasi</button>
            </form>
        @else
            <div class="pt-4 border-t text-sm">
                Status: <strong>{{ $prestasi->status }}</strong>
                @if($prestasi->kategori) &middot; Kategori: <strong>{{ $prestasi->kategori }}</strong> @endif
                @if($prestasi->catatan)<p class="mt-1 text-gray-600">Catatan: {{ $prestasi->catatan }}</p>@endif
            </div>
        @endif

        <a href="{{ route('kesiswaan.prestasi.index') }}" class="inline-block text-sm text-slate-600 hover:underline">&larr; Kembali</a>
    </div>
</x-app-layout>
