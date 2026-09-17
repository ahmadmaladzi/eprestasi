<x-app-layout title="Edit Prestasi">
    <div class="max-w-2xl">
        <a href="{{ route('siswa.prestasi.show', $prestasi) }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 font-medium mb-5">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            Kembali ke Detail
        </a>

        @if($prestasi->status === 'Ditolak' && $prestasi->catatan)
            <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-5">
                <p class="text-xs font-semibold text-red-700 mb-1">Prestasi ini ditolak dengan catatan:</p>
                <p class="text-sm text-red-600 leading-relaxed">{{ $prestasi->catatan }}</p>
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 p-7">
            <form method="POST" action="{{ route('siswa.prestasi.update', $prestasi) }}" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Prestasi</label>
                    <input type="text" name="nama_prestasi" value="{{ old('nama_prestasi', $prestasi->nama_prestasi) }}"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    @error('nama_prestasi') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Penyelenggara</label>
                    <input type="text" name="penyelenggara" value="{{ old('penyelenggara', $prestasi->penyelenggara) }}"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    @error('penyelenggara') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tingkat</label>
                        <select name="tingkat" class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                            @foreach(['Sekolah','Kabupaten/Kota','Provinsi','Nasional','Internasional'] as $t)
                                <option value="{{ $t }}" {{ old('tingkat', $prestasi->tingkat) == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $prestasi->tanggal->format('Y-m-d')) }}"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                        @error('tanggal') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Asal Kompetisi</label>
                        <select name="asal" class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                            <option value="Dalam Negeri" {{ old('asal', $prestasi->asal) == 'Dalam Negeri' ? 'selected' : '' }}>Dalam Negeri</option>
                            <option value="Luar Negeri" {{ old('asal', $prestasi->asal) == 'Luar Negeri' ? 'selected' : '' }}>Luar Negeri</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jenis Penyelenggara</label>
                        <select name="jenis_penyelenggara" class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                            <option value="">-- Pilih --</option>
                            <option value="Kementerian" {{ old('jenis_penyelenggara', $prestasi->jenis_penyelenggara) == 'Kementerian' ? 'selected' : '' }}>Kementerian</option>
                            <option value="Non Kementerian" {{ old('jenis_penyelenggara', $prestasi->jenis_penyelenggara) == 'Non Kementerian' ? 'selected' : '' }}>Non Kementerian (Swasta)</option>
                        </select>
                    </div>
                </div>

                <label class="flex items-center gap-2.5 bg-slate-50 rounded-xl px-3.5 py-3 cursor-pointer">
                    <input type="checkbox" name="terhubung_puspresnas" value="1" {{ old('terhubung_puspresnas', $prestasi->terhubung_puspresnas) ? 'checked' : '' }}
                           class="rounded border-slate-300 text-[#2F6FED] focus:ring-[#2F6FED]/30">
                    <span class="text-sm text-slate-600">Prestasi ini terdaftar/terhubung di <strong>Puspresnas</strong></span>
                </label>

                <div class="border-t border-slate-100 pt-5">
                    <p class="text-sm font-semibold text-slate-800 mb-3.5">Ganti Sertifikat (opsional)</p>
                    <input type="file" name="sertifikat"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#2F6FED]/10 file:text-[#2F6FED] hover:file:bg-[#2F6FED]/20 transition">
                    <p class="text-xs text-slate-400 mt-1.5">Kosongkan jika tidak ingin mengganti sertifikat yang sudah ada.</p>
                </div>

                <div class="flex gap-3 pt-2">
                    <button class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
                        Simpan &amp; Ajukan Ulang
                    </button>
                    <a href="{{ route('siswa.prestasi.show', $prestasi) }}" class="px-5 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition">Batal</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>