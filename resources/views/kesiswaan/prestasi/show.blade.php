<x-app-layout title="Detail Verifikasi">
    @php
        $badge = match(true) {
            $prestasi->status === 'Disetujui' => 'bg-[#ECFDF5] text-[#15803D]',
            $prestasi->perlu_revisi => 'bg-[#FFF7ED] text-[#B45309]',
            default => 'bg-red-50 text-red-600',
        };
    @endphp

    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-[minmax(0,1fr)_330px]" x-data="{ status: '{{ old('status', '') }}' }">

        <div class="space-y-4">
            {{-- HEADER --}}
            <section class="card overflow-hidden">
                <div class="flex flex-wrap items-start gap-3 border-b border-[#E8EDF5] p-5">
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                        <x-icon name="trophy" :size="20" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="font-display text-base font-semibold text-[#0B1E38] sm:text-lg">{{ $prestasi->nama_prestasi }}</h2>
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $badge }}">{{ $prestasi->label_status }}</span>
                        </div>
                        <p class="mt-1 text-[12px] text-[#64748B]">
                            Diajukan oleh <strong class="font-semibold text-[#0B1E38]">{{ $prestasi->siswa->nama }}</strong>
                            ({{ $prestasi->siswa->nis }}) &middot; {{ $prestasi->siswa->kelas }} {{ $prestasi->siswa->jurusan }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2.5 p-5 sm:grid-cols-4">
                    <div class="rounded-xl bg-[#F8FAFC] px-3.5 py-3">
                        <p class="text-[9.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Penyelenggara</p>
                        <p class="mt-1 truncate text-[12px] font-semibold text-[#0B1E38]">{{ $prestasi->penyelenggara }}</p>
                    </div>
                    <div class="rounded-xl bg-[#F8FAFC] px-3.5 py-3">
                        <p class="text-[9.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Tingkat</p>
                        <p class="mt-1 truncate text-[12px] font-semibold text-[#0B1E38]">{{ $prestasi->tingkat }}</p>
                    </div>
                    <div class="rounded-xl bg-[#F8FAFC] px-3.5 py-3">
                        <p class="text-[9.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Tanggal</p>
                        <p class="mt-1 truncate text-[12px] font-semibold text-[#0B1E38]">{{ $prestasi->tanggal->format('d M Y') }}</p>
                    </div>
                    <div class="rounded-xl bg-[#F8FAFC] px-3.5 py-3">
                        <p class="text-[9.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Tahun Ajaran</p>
                        <p class="mt-1 truncate text-[12px] font-semibold text-[#0B1E38]">{{ $prestasi->tahunAjaran->tahun }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2.5 border-t border-[#E8EDF5] p-5 sm:grid-cols-3">
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#F5F7FB] text-[#64748B]">
                            <x-icon name="school" :size="14" />
                        </span>
                        <div class="min-w-0">
                            <p class="text-[9.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Asal</p>
                            <p class="truncate text-[12px] font-medium text-[#0B1E38]">{{ $prestasi->asal ?: '—' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#F5F7FB] text-[#64748B]">
                            <x-icon name="users" :size="14" />
                        </span>
                        <div class="min-w-0">
                            <p class="text-[9.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Penyelenggara</p>
                            <p class="truncate text-[12px] font-medium text-[#0B1E38]">{{ $prestasi->jenis_penyelenggara ?: '—' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg {{ $prestasi->terhubung_puspresnas ? 'bg-[#ECFDF5] text-[#16A34A]' : 'bg-[#F5F7FB] text-[#94A3B8]' }}">
                            <x-icon name="shield" :size="14" />
                        </span>
                        <div class="min-w-0">
                            <p class="text-[9.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Puspresnas</p>
                            <p class="truncate text-[12px] font-medium {{ $prestasi->terhubung_puspresnas ? 'text-[#15803D]' : 'text-[#94A3B8]' }}">
                                {{ $prestasi->terhubung_puspresnas ? 'Terhubung' : 'Tidak terhubung' }}
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- DESKRIPSI --}}
            <section class="card p-5">
                <h3 class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">
                    <x-icon name="clipboard" :size="13" /> Deskripsi
                </h3>
                <p class="mt-2 text-[13px] leading-relaxed text-[#475569]">{{ $prestasi->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
            </section>

            {{-- BERKAS --}}
            <section class="card p-5">
                <h3 class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">
                    <x-icon name="download" :size="13" /> Sertifikat
                </h3>
                <div class="mt-3 space-y-2">
                    @forelse($prestasi->sertifikat as $s)
                        <a href="{{ Storage::url($s->file_path) }}" target="_blank" rel="noopener"
                           class="flex items-center gap-3 rounded-xl border border-[#E8EDF5] px-3.5 py-2.5 transition hover:border-[#2F6FED]/30 hover:bg-[#F8FAFC]">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#EEF4FF] text-[#2F6FED]">
                                <x-icon name="download" :size="14" />
                            </span>
                            <span class="min-w-0 flex-1 truncate text-[12.5px] font-medium text-[#0B1E38]">{{ $s->nama_file }}</span>
                            <x-icon name="chevron-right" :size="13" class="shrink-0 text-[#94A3B8]" />
                        </a>
                    @empty
                        <p class="rounded-xl bg-[#F8FAFC] px-3.5 py-3 text-[12px] text-[#94A3B8]">Tidak ada sertifikat diunggah.</p>
                    @endforelse
                </div>

                <h3 class="mt-5 flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">
                    <x-icon name="image" :size="13" /> Dokumentasi Foto
                </h3>
                <div class="mt-3 grid grid-cols-3 gap-2.5">
                    @forelse($prestasi->dokumentasi as $d)
                        <a href="{{ Storage::url($d->foto) }}" target="_blank" rel="noopener" class="group overflow-hidden rounded-xl border border-[#E8EDF5]">
                            <img src="{{ Storage::url($d->foto) }}" alt="Dokumentasi {{ $prestasi->nama_prestasi }}" loading="lazy"
                                 class="h-24 w-full object-cover transition group-hover:scale-105">
                        </a>
                    @empty
                        <p class="col-span-3 rounded-xl bg-[#F8FAFC] px-3.5 py-3 text-[12px] text-[#94A3B8]">Tidak ada dokumentasi foto.</p>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- PANEL KEPUTUSAN --}}
        <aside class="space-y-4 lg:sticky lg:top-20">
            @if($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                    <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.06em] text-red-700">
                        <x-icon name="x" :size="13" /> Gagal mengirim verifikasi
                    </p>
                    <ul class="mt-2 list-disc space-y-0.5 pl-4 text-[11.5px] text-red-600">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($prestasi->status === 'Belum')
                <form method="POST" action="{{ route('kesiswaan.prestasi.verifikasi', $prestasi) }}" class="card overflow-hidden">
                    @csrf
                    <input type="hidden" name="status" x-model="status">

                    <div class="flex items-start gap-3 border-b border-[#E8EDF5] p-5">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#FFF7ED] text-[#F97316]">
                            <x-icon name="clipboard" :size="16" />
                        </span>
                        <div class="min-w-0">
                            <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Keputusan Verifikasi</h2>
                            <p class="mt-0.5 text-[11px] text-[#94A3B8]">Pilih salah satu keputusan.</p>
                        </div>
                    </div>

                    <div class="space-y-3 p-5">
                        <div class="grid grid-cols-3 gap-2">
                            <button type="button" @click="status = 'Disetujui'"
                                    :class="status === 'Disetujui' ? 'border-[#16A34A] bg-[#ECFDF5] text-[#15803D]' : 'border-[#E8EDF5] bg-white text-[#64748B] hover:bg-[#F8FAFC]'"
                                    class="flex flex-col items-center gap-1.5 rounded-xl border px-2 py-3 text-[11px] font-semibold transition">
                                <x-icon name="check" :size="16" />
                                Setujui
                            </button>
                            <button type="button" @click="status = 'Revisi'"
                                    :class="status === 'Revisi' ? 'border-[#F59E0B] bg-[#FFFBEB] text-[#B45309]' : 'border-[#E8EDF5] bg-white text-[#64748B] hover:bg-[#F8FAFC]'"
                                    class="flex flex-col items-center gap-1.5 rounded-xl border px-2 py-3 text-[11px] font-semibold transition">
                                <x-icon name="edit" :size="16" />
                                Revisi
                            </button>
                            <button type="button" @click="status = 'Ditolak'"
                                    :class="status === 'Ditolak' ? 'border-red-400 bg-red-50 text-red-600' : 'border-[#E8EDF5] bg-white text-[#64748B] hover:bg-[#F8FAFC]'"
                                    class="flex flex-col items-center gap-1.5 rounded-xl border px-2 py-3 text-[11px] font-semibold transition">
                                <x-icon name="x" :size="16" />
                                Tolak
                            </button>
                        </div>

                        <div x-show="status === 'Disetujui'" x-cloak>
                            <label class="field-label" for="kategori">Kategori Prestasi</label>
                            <select id="kategori" name="kategori" class="input">
                                <option value="">— Pilih Kategori —</option>
                                <option value="Akademik" @selected(old('kategori') === 'Akademik')>Akademik</option>
                                <option value="Non Akademik" @selected(old('kategori') === 'Non Akademik')>Non Akademik</option>
                                <option value="Kejuaraan" @selected(old('kategori') === 'Kejuaraan')>Kejuaraan</option>
                            </select>
                        </div>

                        {{-- Satu textarea untuk Revisi maupun Ditolak (hindari dobel name). --}}
                        <div x-show="status === 'Revisi' || status === 'Ditolak'" x-cloak>
                            <label class="field-label" for="catatan" x-text="status === 'Revisi' ? 'Catatan Revisi' : 'Catatan Penolakan'"></label>
                            <textarea id="catatan" name="catatan" rows="3" class="input"
                                      :placeholder="status === 'Revisi' ? 'Contoh: sertifikat kurang jelas, mohon unggah ulang foto yang lebih terang' : 'Jelaskan alasan penolakan'">{{ old('catatan') }}</textarea>
                            <p class="mt-1.5 text-[10.5px] leading-relaxed text-[#94A3B8]" x-show="status === 'Revisi'">
                                Siswa bisa memperbaiki dan mengajukan ulang setelah membaca catatan ini.
                            </p>
                            <p class="mt-1.5 text-[10.5px] leading-relaxed text-[#94A3B8]" x-show="status === 'Ditolak'">
                                Siswa tetap bisa mengedit dan mengajukan ulang setelah membaca catatan.
                            </p>
                        </div>

                        <button type="submit" x-show="status" x-cloak class="btn-primary w-full">
                            <x-icon name="check" :size="14" />
                            Kirim Verifikasi
                        </button>

                        <p x-show="!status" class="rounded-xl bg-[#F8FAFC] px-3 py-2.5 text-center text-[10.5px] text-[#94A3B8]">
                            Pilih keputusan untuk melanjutkan.
                        </p>
                    </div>
                </form>
            @else
                <section class="card overflow-hidden">
                    <div class="flex items-start gap-3 border-b border-[#E8EDF5] p-5">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $prestasi->status === 'Disetujui' ? 'bg-[#ECFDF5] text-[#16A34A]' : 'bg-[#FFF7ED] text-[#B45309]' }}">
                            <x-icon :name="$prestasi->status === 'Disetujui' ? 'check' : 'x'" :size="16" />
                        </span>
                        <div class="min-w-0">
                            <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Sudah Diverifikasi</h2>
                            <p class="mt-0.5 text-[11px] text-[#94A3B8]">Tidak ada tindakan lanjutan.</p>
                        </div>
                    </div>
                    <div class="space-y-3 p-5">
                        <div class="flex items-center justify-between gap-2">
                            <span class="text-[11.5px] text-[#94A3B8]">Status</span>
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $badge }}">{{ $prestasi->label_status }}</span>
                        </div>
                        @if($prestasi->kategori)
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11.5px] text-[#94A3B8]">Kategori</span>
                                <span class="text-[11.5px] font-semibold text-[#0B1E38]">{{ $prestasi->kategori }}</span>
                            </div>
                        @endif
                        @if($prestasi->tanggal_verifikasi)
                            <div class="flex items-center justify-between gap-2">
                                <span class="text-[11.5px] text-[#94A3B8]">Diverifikasi</span>
                                <span class="text-[11.5px] font-semibold text-[#0B1E38]">{{ $prestasi->tanggal_verifikasi->format('d M Y') }}</span>
                            </div>
                        @endif
                        @if($prestasi->catatan)
                            <div class="rounded-xl bg-[#F8FAFC] p-3">
                                <p class="text-[9.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Catatan</p>
                                <p class="mt-1 text-[11.5px] leading-relaxed text-[#475569]">{{ $prestasi->catatan }}</p>
                            </div>
                        @endif
                    </div>
                </section>
            @endif

            <a href="{{ route('kesiswaan.prestasi.index') }}" class="btn-ghost w-full">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M19 12H5M5 12l6-6M5 12l6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Kembali ke daftar
            </a>
        </aside>
    </div>
</x-app-layout>
