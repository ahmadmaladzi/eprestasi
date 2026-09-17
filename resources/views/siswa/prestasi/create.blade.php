<x-app-layout title="Ajukan Prestasi">
    <div class="max-w-2xl">
        <div class="inline-flex items-center gap-2 bg-[#2F6FED]/10 text-[#2F6FED] text-xs font-semibold px-3 py-1.5 rounded-full mb-5">
            <span class="w-1.5 h-1.5 rounded-full bg-[#2F6FED]"></span>
            Tahun ajaran aktif: {{ $ajaranAktif->tahun }}
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-7">
            <form method="POST" action="{{ route('siswa.prestasi.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Prestasi</label>
                    <input type="text" name="nama_prestasi" value="{{ old('nama_prestasi') }}"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition"
                           placeholder="Contoh: Juara 1 Lomba LKS Web Design">
                    @error('nama_prestasi') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Penyelenggara</label>
                    <input type="text" name="penyelenggara" value="{{ old('penyelenggara') }}"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition"
                           placeholder="Contoh: Dinas Pendidikan Provinsi Jawa Barat">
                    @error('penyelenggara') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tingkat</label>
                        <select name="tingkat" class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                            @foreach(['Sekolah','Kabupaten/Kota','Provinsi','Nasional','Internasional'] as $t)
                                <option value="{{ $t }}" {{ old('tingkat') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                        @error('tanggal') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">{{ old('deskripsi') }}</textarea>
                </div>

                <p class="text-xs text-slate-400 bg-slate-50 rounded-lg px-3.5 py-2.5">Kategori (Akademik/Non Akademik/Kejuaraan) akan ditentukan oleh pihak kesiswaan saat prestasi disetujui.</p>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Asal Kompetisi</label>
                        <select name="asal" class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                            <option value="Dalam Negeri" {{ old('asal') == 'Dalam Negeri' ? 'selected' : '' }}>Dalam Negeri</option>
                            <option value="Luar Negeri" {{ old('asal') == 'Luar Negeri' ? 'selected' : '' }}>Luar Negeri</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Penyelenggara</label>
                        <select name="jenis_penyelenggara" class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                            <option value="">-- Pilih --</option>
                            <option value="Kementerian" {{ old('jenis_penyelenggara') == 'Kementerian' ? 'selected' : '' }}>Kementerian (Pemerintah)</option>
                            <option value="Non Kementerian" {{ old('jenis_penyelenggara') == 'Non Kementerian' ? 'selected' : '' }}>Non Kementerian (Swasta)</option>
                        </select>
                    </div>
                </div>

                <label class="flex items-center gap-2.5 bg-slate-50 rounded-xl px-3.5 py-3 cursor-pointer">
                    <input type="checkbox" name="terhubung_puspresnas" value="1" {{ old('terhubung_puspresnas') ? 'checked' : '' }}
                           class="rounded border-slate-300 text-[#2F6FED] focus:ring-[#2F6FED]/30">
                    <span class="text-sm text-slate-600">Prestasi ini terdaftar/terhubung di <strong>Puspresnas</strong> (Pusat Prestasi Nasional)</span>
                </label>

                <div class="border-t border-slate-100 pt-5">
                    <p class="text-sm font-semibold text-slate-800 mb-3.5 flex items-center gap-2">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M4 4H20V17L12 21L4 17V4Z" stroke="#2F6FED" stroke-width="1.6" stroke-linejoin="round"/></svg>
                        Sertifikat
                    </p>
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Upload Sertifikat (PDF/JPG/PNG, max 2MB)</label>
                        <input type="file" name="sertifikat"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#2F6FED]/10 file:text-[#2F6FED] hover:file:bg-[#2F6FED]/20 transition">
                        @error('sertifikat') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi Sertifikat (opsional)</label>
                        <input type="text" name="sertifikat_deskripsi" value="{{ old('sertifikat_deskripsi') }}"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-5">
                    <p class="text-sm font-semibold text-slate-800 mb-3.5 flex items-center gap-2">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><rect x="3" y="5" width="18" height="14" rx="2" stroke="#2F6FED" stroke-width="1.6"/><circle cx="12" cy="12" r="3.2" stroke="#2F6FED" stroke-width="1.6"/></svg>
                        Dokumentasi Foto
                    </p>
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Upload Foto (JPG/PNG, max 2MB)</label>
                        <input type="file" name="foto"
                               class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#2F6FED]/10 file:text-[#2F6FED] hover:file:bg-[#2F6FED]/20 transition">
                        @error('foto') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Caption Foto (opsional)</label>
                        <input type="text" name="caption" value="{{ old('caption') }}"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    </div>
                </div>

                <div class="flex gap-3 pt-2">
                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
                        Simpan &amp; Ajukan Verifikasi
                    </button>
                    <a href="{{ route('siswa.prestasi.index') }}" class="px-5 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>