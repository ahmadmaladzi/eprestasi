<x-app-layout title="Prestasi Saya">
    @php
        $activeStatus = request('status', '');
        $baseQuery = request()->except('status', 'page');
        $adaFilter = request()->filled('search') || request()->filled('status') || request()->filled('sort');
        $statusTabs = [
            '' => 'Semua',
            'Belum' => 'Menunggu',
            'Disetujui' => 'Disetujui',
            'Ditolak' => 'Ditolak',
        ];
        // Saat daftar masih kosong, CTA di header disembunyikan karena
        // empty state sudah punya tombol sendiri (biar tidak dobel).
        $hideHeaderCta = $prestasi->isEmpty() && ! $adaFilter;
    @endphp

    {{-- HEADER --}}
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div class="flex min-w-0 items-center gap-3">
            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-[#EEF4FF] text-[#2F6FED]">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M6 4h12v5a6 6 0 0 1-12 0V4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                    <path d="M6 5.5H4.5a2.5 2.5 0 0 0 0 5H6M18 5.5h1.5a2.5 2.5 0 0 1 0 5H18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    <path d="M12 15v3M9 21h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                </svg>
            </span>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-[#0B1E38]">Kelola pencapaianmu</p>
                <p class="mt-0.5 text-xs text-[#64748B] sm:text-sm">Pantau status verifikasi dan lengkapi portofoliomu di sini.</p>
            </div>
        </div>

        @if(! $hideHeaderCta)
            <a href="{{ route('siswa.prestasi.create') }}"
               class="inline-flex shrink-0 items-center gap-2 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#2F6FED]/25 transition hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2F6FED] focus-visible:ring-offset-2">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                </svg>
                Ajukan Prestasi
            </a>
        @endif
    </div>

    {{-- FILTER --}}
    <div class="mb-5 overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white">
        <form method="GET" class="flex flex-col gap-3 p-3 sm:flex-row sm:items-center sm:p-4">
            <input type="hidden" name="status" value="{{ $activeStatus }}">

            <div class="relative flex-1">
                <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="1.7"/>
                        <path d="m16 16 4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama prestasi..."
                       class="block w-full rounded-xl border border-[#E2E8F0] bg-white py-2.5 pl-10 pr-3.5 text-sm text-[#0B1E38] placeholder:text-[#94A3B8] shadow-sm transition focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
            </div>

            <div class="flex items-center gap-2">
                <div class="relative flex-1 sm:flex-none">
                    <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M7 4v16M7 20l-3-3M7 20l3-3M17 20V4M17 4l-3 3M17 4l3 3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <select name="sort" onchange="this.form.submit()"
                            class="block w-full rounded-xl border border-[#E2E8F0] bg-white py-2.5 pl-10 pr-8 text-sm text-[#0B1E38] shadow-sm transition focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 sm:w-52">
                        <option value="terbaru" {{ request('sort', 'terbaru') === 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                        <option value="terlama" {{ request('sort') === 'terlama' ? 'selected' : '' }}>Terlama</option>
                        <option value="nama_az" {{ request('sort') === 'nama_az' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="nama_za" {{ request('sort') === 'nama_za' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>
                </div>

                <button type="submit"
                        class="inline-flex shrink-0 items-center gap-1.5 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#2F6FED]/20 transition hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2F6FED] focus-visible:ring-offset-2">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="1.8"/>
                        <path d="m16 16 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    Cari
                </button>
            </div>
        </form>

        <div class="flex flex-wrap items-center gap-1.5 border-t border-[#F1F5F9] px-3 py-3 sm:px-4">
            @foreach($statusTabs as $key => $label)
                @php
                    $isActive = $activeStatus === $key;
                    $href = $key === ''
                        ? route('siswa.prestasi.index', $baseQuery)
                        : route('siswa.prestasi.index', array_merge($baseQuery, ['status' => $key]));
                @endphp
                <a href="{{ $href }}"
                   class="inline-flex items-center rounded-lg px-3 py-1.5 text-xs font-semibold transition {{ $isActive ? 'bg-[#2F6FED] text-white shadow-sm shadow-[#2F6FED]/25' : 'bg-[#F8FAFC] text-[#64748B] hover:bg-[#0B1E38]/5 hover:text-[#0B1E38]' }}">
                    {{ $label }}
                </a>
            @endforeach

            @if($adaFilter)
                <a href="{{ route('siswa.prestasi.index') }}"
                   class="ml-auto inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-medium text-[#64748B] transition hover:text-red-600">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M18 6 6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Reset
                </a>
            @endif
        </div>
    </div>

    {{-- DAFTAR --}}
    @if($prestasi->isEmpty())
        <div class="rounded-2xl border border-dashed border-[#E2E8F0] bg-white px-5 py-12 text-center sm:px-6">
            <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#EEF4FF] text-[#2F6FED]">
                @if($adaFilter)
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="1.7"/>
                        <path d="m16 16 4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                @else
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M6 4h12v5a6 6 0 0 1-12 0V4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                        <path d="M12 15v3M9 21h6M10 18h4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                @endif
            </span>

            @if($adaFilter)
                <p class="mt-4 font-display text-base font-semibold text-[#0B1E38]">Tidak ada yang cocok</p>
                <p class="mx-auto mt-1 max-w-sm text-sm text-[#64748B]">Coba ubah kata kunci atau filter status yang kamu pilih.</p>
                <a href="{{ route('siswa.prestasi.index') }}"
                   class="mt-5 inline-flex items-center gap-1.5 rounded-xl border border-[#E2E8F0] px-4 py-2.5 text-sm font-semibold text-[#475569] transition hover:bg-[#F8FAFC]">
                    Tampilkan semua prestasi
                </a>
            @else
                <p class="mt-4 font-display text-base font-semibold text-[#0B1E38]">Belum ada prestasi</p>
                <p class="mx-auto mt-1 max-w-md text-sm text-[#64748B]">
                    Prestasi yang kamu ajukan akan muncul di sini. Begini alurnya:
                </p>

                <div class="mx-auto mt-6 grid max-w-2xl gap-2.5 text-left sm:grid-cols-3">
                    <div class="rounded-xl border border-[#E8EDF5] bg-[#F8FAFC] p-3.5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white text-[#2F6FED] shadow-sm">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                            </svg>
                        </span>
                        <p class="mt-2 text-xs font-semibold text-[#0B1E38]">1. Ajukan</p>
                        <p class="mt-0.5 text-[11px] leading-relaxed text-[#64748B]">Isi data prestasi dan unggah sertifikat.</p>
                    </div>
                    <div class="rounded-xl border border-[#E8EDF5] bg-[#F8FAFC] p-3.5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white text-[#B45309] shadow-sm">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.9"/>
                                <path d="M12 7.5V12l3 2" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <p class="mt-2 text-xs font-semibold text-[#0B1E38]">2. Diverifikasi</p>
                        <p class="mt-0.5 text-[11px] leading-relaxed text-[#64748B]">Kesiswaan memeriksa data dan berkasmu.</p>
                    </div>
                    <div class="rounded-xl border border-[#E8EDF5] bg-[#F8FAFC] p-3.5">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white text-[#15803D] shadow-sm">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <p class="mt-2 text-xs font-semibold text-[#0B1E38]">3. Tampil</p>
                        <p class="mt-0.5 text-[11px] leading-relaxed text-[#64748B]">Prestasi masuk ke portofolio publikmu.</p>
                    </div>
                </div>

                <a href="{{ route('siswa.prestasi.create') }}"
                   class="mt-6 inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#2F6FED]/25 transition hover:opacity-90">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                    </svg>
                    Ajukan Prestasi Pertama
                </a>
            @endif
        </div>
    @else
        <div class="grid grid-cols-1 gap-3.5 sm:grid-cols-2">
            @foreach($prestasi as $item)
                <article class="flex flex-col rounded-2xl border border-[#E8EDF5] bg-white p-4 transition hover:border-[#2F6FED]/25 hover:shadow-[0_10px_30px_-18px_rgba(47,111,237,0.25)] sm:p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex min-w-0 gap-3">
                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M6 4h12v5a6 6 0 0 1-12 0V4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                    <path d="M6 5.5H4.5a2.5 2.5 0 0 0 0 5H6M18 5.5h1.5a2.5 2.5 0 0 1 0 5H18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                    <path d="M12 15v3M9 21h6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <h2 class="text-sm font-semibold leading-snug text-[#0B1E38]">{{ $item->nama_prestasi }}</h2>
                                <p class="mt-0.5 truncate text-xs text-[#64748B]">{{ $item->penyelenggara ?: 'Penyelenggara belum diisi' }}</p>
                            </div>
                        </div>
                        <div class="shrink-0">
                            @include('siswa.partials.status-badge', ['prestasi' => $item])
                        </div>
                    </div>

                    <div class="mt-3.5 flex flex-wrap gap-1.5">
                        <span class="inline-flex items-center gap-1 rounded-md bg-[#F8FAFC] px-2 py-1 text-[11px] font-medium text-[#64748B]">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M12 3l2.2 5.4 5.8.5-4.4 3.8 1.3 5.7L12 15.5 7.1 18.4l1.3-5.7L4 8.9l5.8-.5L12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                            </svg>
                            {{ $item->tingkat }}
                        </span>
                        <span class="inline-flex items-center gap-1 rounded-md bg-[#F8FAFC] px-2 py-1 text-[11px] font-medium text-[#64748B]">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="4" y="5.5" width="16" height="14" rx="2.5" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M4 10h16M8.5 3.5v4M15.5 3.5v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                            </svg>
                            {{ $item->tanggal->format('d M Y') }}
                        </span>
                        @if($item->kategori)
                            <span class="inline-flex items-center gap-1 rounded-md bg-[#EEF4FF] px-2 py-1 text-[11px] font-medium text-[#2F6FED]">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M4 11.5V5.5A1.5 1.5 0 0 1 5.5 4h6l8.5 8.5-7.5 7.5L4 11.5Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
                                    <circle cx="8.5" cy="8.5" r="1.3" fill="currentColor"/>
                                </svg>
                                {{ $item->kategori }}
                            </span>
                        @endif
                    </div>

                    <div class="mt-4 flex items-center justify-between gap-2 border-t border-[#F1F5F9] pt-3.5">
                        <a href="{{ route('siswa.prestasi.show', $item) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#2F6FED] transition hover:text-[#1B4FC4]">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M2.5 12S6 5.5 12 5.5 21.5 12 21.5 12 18 18.5 12 18.5 2.5 12 2.5 12Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="2.8" stroke="currentColor" stroke-width="1.7"/>
                            </svg>
                            Lihat Detail
                        </a>

                        <div class="flex items-center gap-1">
                            @if($item->status !== 'Disetujui')
                                <a href="{{ route('siswa.prestasi.edit', $item) }}" title="Edit prestasi" aria-label="Edit prestasi"
                                   class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#64748B] transition hover:bg-[#EEF4FF] hover:text-[#2F6FED]">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <path d="M11 4H5.5A1.5 1.5 0 0 0 4 5.5v13A1.5 1.5 0 0 0 5.5 20h13a1.5 1.5 0 0 0 1.5-1.5V13" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                        <path d="M18.4 2.6a2 2 0 0 1 2.8 2.8L12 14.6l-3.6 1 1-3.6 9-9.4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                                <form method="POST" action="{{ route('siswa.prestasi.destroy', $item) }}" class="inline"
                                      onsubmit="return confirm('Yakin hapus prestasi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus prestasi" aria-label="Hapus prestasi"
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#64748B] transition hover:bg-red-50 hover:text-red-600">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                            <path d="M4 7h16M9 7V5.5A1.5 1.5 0 0 1 10.5 4h3A1.5 1.5 0 0 1 15 5.5V7M6 7v12.5A1.5 1.5 0 0 0 7.5 21h9a1.5 1.5 0 0 0 1.5-1.5V7M10 11v6M14 11v6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </form>
                            @else
                                <span class="inline-flex items-center gap-1 text-[11px] font-medium text-[#94A3B8]">
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                        <rect x="5" y="10" width="14" height="10" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
                                        <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                    </svg>
                                    Terkunci
                                </span>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-5">{{ $prestasi->links() }}</div>
    @endif
</x-app-layout>
