<x-app-layout title="Detail Prestasi">
    <div class="mx-auto max-w-5xl">
        <a href="{{ route('siswa.prestasi.index') }}" class="mb-5 inline-flex items-center gap-1.5 text-sm font-medium text-[#64748B] transition hover:text-[#0B1E38]">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                <path d="M19 12H5M5 12l7 7M5 12l7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali ke Prestasi Saya
        </a>

        <div class="grid grid-cols-1 items-start gap-5 lg:grid-cols-[1fr_320px]">
            {{-- KONTEN UTAMA --}}
            <div class="overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white">
                <div class="border-b border-[#F1F5F9] p-5 sm:p-6">
                    <div class="mb-4 flex flex-wrap items-start justify-between gap-3">
                        <div class="flex min-w-0 gap-3.5">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M6 4h12v5a6 6 0 0 1-12 0V4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                    <path d="M6 5.5H4.5a2.5 2.5 0 0 0 0 5H6M18 5.5h1.5a2.5 2.5 0 0 1 0 5H18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                    <path d="M12 15v3M9 21h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h1 class="font-display text-lg font-semibold leading-snug text-[#0B1E38] sm:text-xl">{{ $prestasi->nama_prestasi }}</h1>
                                <p class="mt-0.5 text-sm text-[#64748B]">{{ $prestasi->penyelenggara ?: 'Penyelenggara belum diisi' }}</p>
                            </div>
                        </div>
                        <div class="shrink-0">
                            @include('siswa.partials.status-badge', ['prestasi' => $prestasi, 'size' => 'md'])
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-1.5">
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#F8FAFC] px-2.5 py-1.5 text-xs font-medium text-[#64748B]">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 3l2.2 5.4 5.8.5-4.4 3.8 1.3 5.7L12 15.5 7.1 18.4l1.3-5.7L4 8.9l5.8-.5L12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            </svg>
                            {{ $prestasi->tingkat }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#F8FAFC] px-2.5 py-1.5 text-xs font-medium text-[#64748B]">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="4" y="5.5" width="16" height="14" rx="2.5" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M4 10h16M8.5 3.5v4M15.5 3.5v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                            {{ $prestasi->tanggal->format('d M Y') }}
                        </span>
                        @if($prestasi->kategori)
                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#EEF4FF] px-2.5 py-1.5 text-xs font-medium text-[#2F6FED]">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M4 11.5V5.5A1.5 1.5 0 0 1 5.5 4h6l8.5 8.5-7.5 7.5L4 11.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                    <circle cx="8.5" cy="8.5" r="1.3" fill="currentColor"/>
                                </svg>
                                {{ $prestasi->kategori }}
                            </span>
                        @endif
                        @if($prestasi->asal)
                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#F8FAFC] px-2.5 py-1.5 text-xs font-medium text-[#64748B]">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.6"/>
                                    <path d="M3 12h18M12 3c2.5 2.5 3.8 5.6 3.8 9S14.5 18.5 12 21c-2.5-2.5-3.8-5.6-3.8-9S9.5 5.5 12 3Z" stroke="currentColor" stroke-width="1.6"/>
                                </svg>
                                {{ $prestasi->asal }}
                            </span>
                        @endif
                        @if($prestasi->terhubung_puspresnas)
                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-[#22C55E]/10 px-2.5 py-1.5 text-xs font-semibold text-[#15803D]">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Terhubung Puspresnas
                            </span>
                        @endif
                    </div>
                </div>

                @if($prestasi->status === 'Ditolak' && $prestasi->catatan)
                    <div class="px-5 pt-5 sm:px-6">
                        @if($prestasi->perlu_revisi)
                            <div class="rounded-xl border border-[#F59E0B]/25 bg-[#F59E0B]/5 p-4">
                                <p class="flex items-center gap-2 text-xs font-semibold text-[#B45309]">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/>
                                        <path d="M12 7.5v5M12 16.5v.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                    Perlu Direvisi &mdash; Begini yang Perlu Diperbaiki
                                </p>
                                <p class="mt-1.5 text-sm leading-relaxed text-[#475569]">{{ $prestasi->catatan }}</p>
                                <p class="mt-2 text-xs text-[#B45309]/70">
                                    Klik "Edit Prestasi" di bawah, perbaiki sesuai catatan, lalu simpan &mdash; otomatis diajukan ulang ke kesiswaan.
                                </p>
                            </div>
                        @else
                            <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                                <p class="flex items-center gap-2 text-xs font-semibold text-red-700">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/>
                                        <path d="M15 9l-6 6M9 9l6 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                    Catatan Penolakan
                                </p>
                                <p class="mt-1.5 text-sm leading-relaxed text-red-700/80">{{ $prestasi->catatan }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="space-y-6 p-5 sm:p-6">
                    <div>
                        <h2 class="mb-2 flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-[#64748B]">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 6h16M4 12h16M4 18h10" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            Deskripsi
                        </h2>
                        <p class="text-sm leading-relaxed text-[#475569]">{{ $prestasi->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                    </div>

                    <div>
                        <h2 class="mb-2.5 flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-[#64748B]">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 4h16v13l-8 4-8-4V4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            </svg>
                            Sertifikat
                        </h2>
                        <div class="space-y-2">
                            @forelse($prestasi->sertifikat as $s)
                                <a href="{{ Storage::url($s->file_path) }}" target="_blank" rel="noopener"
                                   class="group flex items-center gap-3 rounded-xl border border-[#E8EDF5] px-3.5 py-3 transition hover:border-[#2F6FED]/25 hover:bg-[#F8FAFC]">
                                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-[#EEF4FF] text-[#2F6FED]">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M13 3.5H7a1.5 1.5 0 0 0-1.5 1.5v14A1.5 1.5 0 0 0 7 20.5h10a1.5 1.5 0 0 0 1.5-1.5V9L13 3.5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                            <path d="M13 3.5V9h5.5" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                    <span class="min-w-0 flex-1">
                                        <span class="block truncate text-sm font-medium text-[#0B1E38]">{{ $s->nama_file ?? 'Lihat Sertifikat' }}</span>
                                        <span class="block text-[11px] text-[#94A3B8]">
                                            {{ $s->deskripsi ?: 'Dokumen sertifikat' }}
                                            @if($s->ukuran_file) &middot; {{ $s->ukuran_file }} KB @endif
                                        </span>
                                    </span>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="shrink-0 text-[#CBD5E1] transition group-hover:text-[#2F6FED]">
                                        <path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                            @empty
                                <div class="rounded-xl border border-dashed border-[#E2E8F0] px-4 py-5 text-center">
                                    <p class="text-sm text-[#94A3B8]">Belum ada sertifikat diunggah.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <h2 class="mb-2.5 flex items-center gap-1.5 text-xs font-semibold uppercase tracking-wide text-[#64748B]">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="3" y="6" width="18" height="14" rx="2.5" stroke="currentColor" stroke-width="1.6"/>
                                <circle cx="12" cy="13" r="3.2" stroke="currentColor" stroke-width="1.6"/>
                            </svg>
                            Dokumentasi Foto
                        </h2>
                        @if($prestasi->dokumentasi->count() > 0)
                            <div class="grid grid-cols-2 gap-2.5 sm:grid-cols-3">
                                @foreach($prestasi->dokumentasi as $d)
                                    <figure class="group relative overflow-hidden rounded-xl border border-[#E8EDF5]">
                                        <img src="{{ Storage::url($d->foto) }}" alt="{{ $d->caption ?: 'Dokumentasi prestasi' }}"
                                             class="h-28 w-full object-cover transition duration-300 group-hover:scale-[1.03]">
                                        @if($d->caption)
                                            <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-[#0B1E38]/80 to-transparent px-2.5 pb-2 pt-6 text-[10px] font-medium text-white">
                                                {{ $d->caption }}
                                            </figcaption>
                                        @endif
                                    </figure>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-xl border border-dashed border-[#E2E8F0] px-4 py-5 text-center">
                                <p class="text-sm text-[#94A3B8]">Belum ada dokumentasi foto.</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if(in_array($prestasi->status, ['Belum', 'Ditolak']))
                    <div class="flex flex-wrap gap-3 border-t border-[#F1F5F9] bg-[#F8FAFC] px-5 py-4 sm:px-6">
                        <a href="{{ route('siswa.prestasi.edit', $prestasi) }}"
                           class="inline-flex items-center gap-2 rounded-xl border border-[#E2E8F0] bg-white px-4 py-2.5 text-sm font-semibold text-[#0B1E38]/75 transition hover:bg-[#F8FAFC]">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M11 4H5.5A1.5 1.5 0 0 0 4 5.5v13A1.5 1.5 0 0 0 5.5 20h13a1.5 1.5 0 0 0 1.5-1.5V13" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                <path d="M18.4 2.6a2 2 0 0 1 2.8 2.8L12 14.6l-3.6 1 1-3.6 9-9.4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            </svg>
                            Edit Prestasi
                        </a>
                        <form method="POST" action="{{ route('siswa.prestasi.destroy', $prestasi) }}"
                              onsubmit="return confirm('Yakin hapus prestasi ini? Tindakan ini tidak bisa dibatalkan.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M4 7h16M9 7V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7M6 7v12.5A1.5 1.5 0 0 0 7.5 21h9a1.5 1.5 0 0 0 1.5-1.5V7" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- PANEL KANAN --}}
            <div class="space-y-4">
                <div class="rounded-2xl border border-[#E8EDF5] bg-white p-5">
                    <h2 class="mb-4 flex items-center gap-1.5 font-display text-sm font-semibold text-[#0B1E38]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="text-[#2F6FED]">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M12 7.5V12l3 2" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Riwayat
                    </h2>

                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-[#2F6FED] text-white">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-xs font-semibold text-[#0B1E38]">Diajukan</p>
                                <p class="mt-0.5 text-xs text-[#64748B]">{{ $prestasi->created_at->translatedFormat('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        @if($prestasi->status !== 'Belum')
                            <div class="flex gap-3">
                                @php
                                    $titikWarna = match(true) {
                                        $prestasi->status === 'Disetujui' => 'bg-[#16A34A]',
                                        $prestasi->perlu_revisi => 'bg-[#D97706]',
                                        default => 'bg-red-500',
                                    };
                                @endphp
                                <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full text-white {{ $titikWarna }}">
                                    @if($prestasi->status === 'Disetujui')
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    @elseif($prestasi->perlu_revisi)
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M12 7v6M12 16.5v.01" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                                        </svg>
                                    @else
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2.6" stroke-linecap="round"/>
                                        </svg>
                                    @endif
                                </span>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-[#0B1E38]">{{ $prestasi->label_status }}</p>
                                    <p class="mt-0.5 text-xs text-[#64748B]">
                                        {{ $prestasi->tanggal_verifikasi ? $prestasi->tanggal_verifikasi->translatedFormat('d M Y, H:i') : $prestasi->updated_at->translatedFormat('d M Y, H:i') }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="flex gap-3 opacity-40">
                                <span class="mt-0.5 h-6 w-6 shrink-0 rounded-full border-2 border-dashed border-[#CBD5E1]"></span>
                                <div class="min-w-0">
                                    <p class="text-xs font-semibold text-[#475569]">Menunggu verifikasi</p>
                                    <p class="mt-0.5 text-xs text-[#64748B]">Belum diproses kesiswaan</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="rounded-2xl border border-[#BFDBFE] bg-[#EFF6FF] p-5">
                    <p class="flex items-center gap-1.5 text-xs font-semibold text-[#2F6FED]">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3a6 6 0 0 0-3.5 10.9c.6.4 1 1 1 1.7v.4h5v-.4c0-.7.4-1.3 1-1.7A6 6 0 0 0 12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            <path d="M9.5 19h5M10 21.5h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                        </svg>
                        Tips
                    </p>
                    <p class="mt-2 text-xs leading-relaxed text-[#64748B]">
                        @if($prestasi->status === 'Ditolak' && $prestasi->perlu_revisi)
                            Baca catatan revisi, perbaiki datanya, lalu klik "Edit Prestasi" untuk mengajukan ulang.
                        @elseif($prestasi->status === 'Ditolak')
                            Prestasi ini ditolak. Kamu masih bisa edit &amp; ajukan ulang kalau ingin mencoba lagi.
                        @elseif($prestasi->status === 'Belum')
                            Prestasi kamu sedang diperiksa kesiswaan. Proses biasanya 1&ndash;3 hari kerja.
                        @else
                            Prestasi ini sudah terverifikasi dan tampil di portofolio publik kamu.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
