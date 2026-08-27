<x-app-layout title="Ajukan Prestasi">
    <div class="max-w-2xl bg-white rounded-lg shadow-sm p-6">
        <p class="text-sm text-gray-500 mb-4">Tahun ajaran aktif: <strong>{{ $ajaranAktif->tahun }}</strong></p>

        <form method="POST" action="{{ route('siswa.prestasi.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">Nama Prestasi</label>
                <input type="text" name="nama_prestasi" value="{{ old('nama_prestasi') }}" class="mt-1 block w-full rounded border-gray-300" placeholder="Contoh: Juara 1 Lomba LKS Web Design">
                @error('nama_prestasi') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Penyelenggara</label>
                <input type="text" name="penyelenggara" value="{{ old('penyelenggara') }}" class="mt-1 block w-full rounded border-gray-300" placeholder="Contoh: Dinas Pendidikan Provinsi Jawa Barat">
                @error('penyelenggara') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tingkat</label>
                    <select name="tingkat" class="mt-1 block w-full rounded border-gray-300">
                        @foreach(['Sekolah','Kabupaten/Kota','Provinsi','Nasional','Internasional'] as $t)
                            <option value="{{ $t }}" {{ old('tingkat') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="mt-1 block w-full rounded border-gray-300">
                    @error('tanggal') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="mt-1 block w-full rounded border-gray-300">{{ old('deskripsi') }}</textarea>
            </div>

            <p class="text-xs text-gray-500">Catatan: Kategori (Akademik/Non Akademik/Kejuaraan) akan ditentukan oleh pihak kesiswaan saat prestasi disetujui.</p>

            <hr class="my-4">
            <p class="text-sm font-medium text-gray-700">Sertifikat</p>
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Sertifikat (PDF/JPG/PNG, max 2MB)</label>
                <input type="file" name="sertifikat" class="mt-1 block w-full text-sm">
                @error('sertifikat') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Deskripsi Sertifikat (opsional)</label>
                <input type="text" name="sertifikat_deskripsi" value="{{ old('sertifikat_deskripsi') }}" class="mt-1 block w-full rounded border-gray-300">
            </div>

            <p class="text-sm font-medium text-gray-700 pt-2">Dokumentasi Foto</p>
            <div>
                <label class="block text-sm font-medium text-gray-700">Upload Foto (JPG/PNG, max 2MB)</label>
                <input type="file" name="foto" class="mt-1 block w-full text-sm">
                @error('foto') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Caption Foto (opsional)</label>
                <input type="text" name="caption" value="{{ old('caption') }}" class="mt-1 block w-full rounded border-gray-300">
            </div>

            <div class="flex gap-3">
                <button class="bg-slate-800 text-white px-4 py-2 rounded hover:bg-slate-700">Simpan & Ajukan Verifikasi</button>
                <a href="{{ route('siswa.prestasi.index') }}" class="px-4 py-2 rounded border text-gray-700 hover:bg-gray-50">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
