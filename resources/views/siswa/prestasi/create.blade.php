<x-app-layout title="Ajukan Prestasi">
    @php
        $field = 'block w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-[#0B1E38] placeholder:text-[#94A3B8] shadow-sm transition focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20';
        $fileField = 'block w-full text-[13px] text-[#64748B] file:mr-3 file:rounded-lg file:border-0 file:bg-[#EEF4FF] file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-[#2F6FED] hover:file:bg-[#E0EAFF]';
    @endphp

    <div class="mx-auto max-w-3xl">
        <a href="{{ route('siswa.prestasi.index') }}" class="mb-5 inline-flex items-center gap-1.5 text-sm font-medium text-[#64748B] transition hover:text-[#0B1E38]">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M19 12H5M5 12l7 7M5 12l7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali ke Prestasi Saya
        </a>

        <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
            <p class="max-w-md text-sm text-[#64748B]">Lengkapi data prestasi di bawah ini, lalu ajukan untuk diverifikasi kesiswaan.</p>

            <div class="inline-flex items-center gap-2 rounded-lg bg-[#EEF4FF] px-3 py-1.5 text-xs font-semibold text-[#2F6FED]">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <rect x="4" y="5.5" width="16" height="14" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
                    <path d="M4 10h16M8.5 3.5v4M15.5 3.5v4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                </svg>
                Tahun ajaran aktif: {{ $ajaranAktif->tahun }}
            </div>
        </div>

        <form method="POST" action="{{ route('siswa.prestasi.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            {{-- 1. INFORMASI PRESTASI --}}
            <section class="overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white">
                <div class="flex items-center gap-3 border-b border-[#E8EDF5] px-5 py-4 sm:px-6">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M6 3.5h8.5L19 8v12.5H6V3.5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            <path d="M14 3.5V8h5M9 12h7M9 15.5h7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Informasi Prestasi</h2>
                        <p class="text-xs text-[#64748B]">Data utama kompetisi yang kamu ikuti.</p>
                    </div>
                </div>

                <div class="space-y-5 p-5 sm:p-6">
                    <div>
                        <label for="nama_prestasi" class="mb-1.5 block text-xs font-semibold text-[#64748B]">Nama Prestasi <span class="text-red-500">*</span></label>
                        <input id="nama_prestasi" type="text" name="nama_prestasi" value="{{ old('nama_prestasi') }}"
                               placeholder="Contoh: Juara 1 Lomba LKS Web Design"
                               class="{{ $field }} {{ $errors->has('nama_prestasi') ? 'border-red-300' : 'border-[#E2E8F0]' }}">
                        @error('nama_prestasi') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="penyelenggara" class="mb-1.5 block text-xs font-semibold text-[#64748B]">Penyelenggara <span class="text-red-500">*</span></label>
                        <input id="penyelenggara" type="text" name="penyelenggara" value="{{ old('penyelenggara') }}"
                               placeholder="Contoh: Dinas Pendidikan Provinsi Jawa Barat"
                               class="{{ $field }} {{ $errors->has('penyelenggara') ? 'border-red-300' : 'border-[#E2E8F0]' }}">
                        @error('penyelenggara') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="tingkat" class="mb-1.5 block text-xs font-semibold text-[#64748B]">Tingkat <span class="text-red-500">*</span></label>
                            <select id="tingkat" name="tingkat" class="{{ $field }} border-[#E2E8F0]">
                                @foreach(['Sekolah','Kabupaten/Kota','Provinsi','Nasional','Internasional'] as $t)
                                    <option value="{{ $t }}" {{ old('tingkat') == $t ? 'selected' : '' }}>{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="tanggal" class="mb-1.5 block text-xs font-semibold text-[#64748B]">Tanggal <span class="text-red-500">*</span></label>
                            <input id="tanggal" type="date" name="tanggal" value="{{ old('tanggal') }}"
                                   class="{{ $field }} {{ $errors->has('tanggal') ? 'border-red-300' : 'border-[#E2E8F0]' }}">
                            @error('tanggal') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="deskripsi" class="mb-1.5 block text-xs font-semibold text-[#64748B]">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="3"
                                  placeholder="Ceritakan singkat tentang kompetisi dan pencapaianmu..."
                                  class="{{ $field }} border-[#E2E8F0]">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
            </section>

            {{-- 2. DETAIL KOMPETISI --}}
            <section class="overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white">
                <div class="flex items-center gap-3 border-b border-[#E8EDF5] px-5 py-4 sm:px-6">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M5 21V4M5 4h12l-2.5 4L17 12H5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Detail Kompetisi</h2>
                        <p class="text-xs text-[#64748B]">Asal dan jenis penyelenggara lomba.</p>
                    </div>
                </div>

                <div class="space-y-5 p-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="asal" class="mb-1.5 block text-xs font-semibold text-[#64748B]">Asal Kompetisi</label>
                            <select id="asal" name="asal" class="{{ $field }} border-[#E2E8F0]">
                                <option value="Dalam Negeri" {{ old('asal') == 'Dalam Negeri' ? 'selected' : '' }}>Dalam Negeri</option>
                                <option value="Luar Negeri" {{ old('asal') == 'Luar Negeri' ? 'selected' : '' }}>Luar Negeri</option>
                            </select>
                        </div>
                        <div>
                            <label for="jenis_penyelenggara" class="mb-1.5 block text-xs font-semibold text-[#64748B]">Jenis Penyelenggara</label>
                            <select id="jenis_penyelenggara" name="jenis_penyelenggara" class="{{ $field }} border-[#E2E8F0]">
                                <option value="">-- Pilih --</option>
                                <option value="Kementerian" {{ old('jenis_penyelenggara') == 'Kementerian' ? 'selected' : '' }}>Kementerian (Pemerintah)</option>
                                <option value="Non Kementerian" {{ old('jenis_penyelenggara') == 'Non Kementerian' ? 'selected' : '' }}>Non Kementerian (Swasta)</option>
                            </select>
                        </div>
                    </div>

                    <label class="flex cursor-pointer items-start gap-3 rounded-xl bg-[#F8FAFC] px-4 py-3.5 transition hover:bg-[#F8FAFC]/70">
                        <input type="checkbox" name="terhubung_puspresnas" value="1" {{ old('terhubung_puspresnas') ? 'checked' : '' }}
                               class="mt-0.5 rounded border-[#CBD5E1] text-[#2F6FED] focus:ring-[#2F6FED]/30">
                        <span class="text-sm leading-relaxed text-[#475569]">
                            Prestasi ini terdaftar/terhubung di <strong class="font-semibold text-[#0B1E38]">Puspresnas</strong> (Pusat Prestasi Nasional)
                        </span>
                    </label>

                    <p class="flex items-start gap-2 rounded-xl border border-[#BFDBFE] bg-[#EFF6FF] px-4 py-3 text-xs leading-relaxed text-[#64748B]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="mt-0.5 shrink-0 text-[#2F6FED]">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M12 11v5.5M12 7.5v.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Kategori (Akademik/Non Akademik/Kejuaraan) akan ditentukan oleh pihak kesiswaan saat prestasi disetujui.
                    </p>
                </div>
            </section>

            {{-- 3. BERKAS PENDUKUNG --}}
            <section class="overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white">
                <div class="flex items-center gap-3 border-b border-[#E8EDF5] px-5 py-4 sm:px-6">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M20 11.5 12.5 19a4.6 4.6 0 0 1-6.5-6.5l8-8a3.2 3.2 0 0 1 4.5 4.5l-7.8 7.8a1.8 1.8 0 0 1-2.5-2.5l7-7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Berkas Pendukung</h2>
                        <p class="text-xs text-[#64748B]">Sertifikat dan foto dokumentasi mempercepat verifikasi.</p>
                    </div>
                </div>

                <div class="space-y-6 p-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="sertifikat" class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-[#64748B]">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M4 4h16v13l-8 4-8-4V4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                    <path d="M9 11l2 2 4-4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Upload Sertifikat
                            </label>
                            <div class="rounded-xl border border-dashed border-[#CBD5E1] bg-[#F8FAFC] p-3">
                                <input id="sertifikat" type="file" name="sertifikat" class="{{ $fileField }}">
                                <p class="mt-2 text-[11px] text-[#94A3B8]">PDF/JPG/PNG, maksimal 2MB.</p>
                            </div>
                            @error('sertifikat') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="sertifikat_deskripsi" class="mb-1.5 block text-xs font-semibold text-[#64748B]">Deskripsi Sertifikat <span class="font-normal text-[#94A3B8]">(opsional)</span></label>
                            <input id="sertifikat_deskripsi" type="text" name="sertifikat_deskripsi" value="{{ old('sertifikat_deskripsi') }}"
                                   placeholder="Contoh: Sertifikat Juara 1"
                                   class="{{ $field }} border-[#E2E8F0]">
                        </div>
                    </div>

                    <div class="h-px bg-[#0B1E38]/6"></div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="foto" class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-[#64748B]">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3" y="6" width="18" height="14" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
                                    <circle cx="12" cy="13" r="3.2" stroke="currentColor" stroke-width="1.7"/>
                                    <path d="M8 6l1.5-2.5h5L16 6" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                </svg>
                                Upload Foto Dokumentasi
                            </label>
                            <div class="rounded-xl border border-dashed border-[#CBD5E1] bg-[#F8FAFC] p-3">
                                <input id="foto" type="file" name="foto" class="{{ $fileField }}">
                                <p class="mt-2 text-[11px] text-[#94A3B8]">JPG/PNG, maksimal 2MB.</p>
                            </div>
                            @error('foto') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="caption" class="mb-1.5 block text-xs font-semibold text-[#64748B]">Caption Foto <span class="font-normal text-[#94A3B8]">(opsional)</span></label>
                            <input id="caption" type="text" name="caption" value="{{ old('caption') }}"
                                   placeholder="Contoh: Momen penerimaan piala"
                                   class="{{ $field }} border-[#E2E8F0]">
                        </div>
                    </div>
                </div>
            </section>

            {{-- AKSI --}}
            <div class="flex flex-wrap items-center gap-3 rounded-2xl border border-[#E8EDF5] bg-white px-5 py-4 sm:px-6">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#2F6FED]/25 transition hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2F6FED] focus-visible:ring-offset-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Simpan &amp; Ajukan Verifikasi
                </button>
                <a href="{{ route('siswa.prestasi.index') }}"
                   class="inline-flex items-center gap-2 rounded-xl border border-[#E2E8F0] px-5 py-2.5 text-sm font-semibold text-[#475569] transition hover:bg-[#F8FAFC]">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
