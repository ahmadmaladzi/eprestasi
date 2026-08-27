<x-app-layout title="Detail Prestasi">
    <div class="max-w-2xl bg-white rounded-lg shadow-sm p-6 space-y-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $prestasi->nama_prestasi }}</h2>
            <p class="text-sm text-gray-500">{{ $prestasi->penyelenggara }} &middot; {{ $prestasi->tingkat }} &middot; {{ $prestasi->tanggal->format('d M Y') }}</p>
            <p class="text-sm text-gray-500">Tahun Ajaran: {{ $prestasi->tahunAjaran->tahun }}</p>
        </div>

        @php
            $color = match($prestasi->status) {
                'Disetujui' => 'bg-green-100 text-green-800',
                'Ditolak' => 'bg-red-100 text-red-800',
                default => 'bg-yellow-100 text-yellow-800',
            };
        @endphp
        <span class="inline-block px-3 py-1 rounded text-sm {{ $color }}">Status: {{ $prestasi->status }}</span>
        @if($prestasi->kategori)
            <span class="inline-block px-3 py-1 rounded text-sm bg-slate-100 text-slate-800">Kategori: {{ $prestasi->kategori }}</span>
        @endif

        @if($prestasi->catatan)
            <div class="p-3 bg-gray-50 border rounded text-sm">
                <strong>Catatan Kesiswaan:</strong> {{ $prestasi->catatan }}
            </div>
        @endif

        <div>
            <h3 class="font-medium text-gray-700 mb-1">Deskripsi</h3>
            <p class="text-sm text-gray-600">{{ $prestasi->deskripsi ?: '-' }}</p>
        </div>

        <div>
            <h3 class="font-medium text-gray-700 mb-2">Sertifikat</h3>
            <ul class="space-y-1 text-sm">
                @forelse($prestasi->sertifikat as $s)
                    <li><a href="{{ Storage::url($s->file_path) }}" target="_blank" class="text-blue-600 hover:underline">{{ $s->nama_file }}</a> <span class="text-gray-400">({{ $s->ukuran_file }} KB)</span></li>
                @empty
                    <li class="text-gray-500">Tidak ada sertifikat.</li>
                @endforelse
            </ul>
        </div>

        <div>
            <h3 class="font-medium text-gray-700 mb-2">Dokumentasi Foto</h3>
            <div class="grid grid-cols-3 gap-2">
                @forelse($prestasi->dokumentasi as $d)
                    <div>
                        <img src="{{ Storage::url($d->foto) }}" class="rounded border w-full h-24 object-cover">
                        @if($d->caption)<p class="text-xs text-gray-500 mt-1">{{ $d->caption }}</p>@endif
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Tidak ada dokumentasi foto.</p>
                @endforelse
            </div>
        </div>

        <a href="{{ route('siswa.prestasi.index') }}" class="inline-block text-sm text-slate-600 hover:underline">&larr; Kembali</a>
    </div>
</x-app-layout>
