<x-app-layout title="Edit Prestasi">
    <div class="max-w-2xl bg-white rounded-lg shadow-sm p-6">
        @if($prestasi->status === 'Ditolak')
            <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-sm text-red-800">
                <strong>Catatan dari kesiswaan:</strong> {{ $prestasi->catatan ?? '-' }}
            </div>
        @endif

        <form method="POST" action="{{ route('siswa.prestasi.update', $prestasi) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Prestasi</label>
                <input type="text" name="nama_prestasi" value="{{ old('nama_prestasi', $prestasi->nama_prestasi) }}" class="mt-1 block w-full rounded border-gray-300">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Penyelenggara</label>
                <input type="text" name="penyelenggara" value="{{ old('penyelenggara', $prestasi->penyelenggara) }}" class="mt-1 block w-full rounded border-gray-300">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tingkat</label>
                    <select name="tingkat" class="mt-1 block w-full rounded border-gray-300">
                        @foreach(['Sekolah','Kabupaten/Kota','Provinsi','Nasional','Internasional'] as $t)
                            <option value="{{ $t }}" {{ old('tingkat', $prestasi->tingkat) == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $prestasi->tanggal->format('Y-m-d')) }}" class="mt-1 block w-full rounded border-gray-300">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded border-gray-300">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
            </div>

            <hr class="my-4">
            <p class="text-sm font-medium text-gray-700">Ganti/Tambah Dokumen (opsional)</p>
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Sertifikat Baru</label>
                <input type="file" name="sertifikat" class="mt-1 block w-full text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Foto Baru</label>
                <input type="file" name="foto" class="mt-1 block w-full text-sm">
            </div>

            <div class="flex gap-3">
                <button class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700">Simpan & Ajukan Ulang</button>
                <a href="{{ route('siswa.prestasi.index') }}" class="px-4 py-2 rounded border text-gray-700 hover:bg-gray-50">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
