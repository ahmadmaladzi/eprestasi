<x-app-layout title="Dashboard">
    @php
        $persen = $totalPrestasi > 0 ? (int) round(($totalDisetujui / $totalPrestasi) * 100) : 0;
        $foto = $siswa->foto_profil ? \Illuminate\Support\Facades\Storage::url($siswa->foto_profil) : null;
    @endphp

    <div class="space-y-4">

        {{-- HERO RINGAN --}}
        <section class="relative overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white p-5 sm:p-6">
            <div class="pointer-events-none absolute -right-10 -top-16 h-48 w-48 rounded-full bg-[#2F6FED]/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-20 left-1/3 h-44 w-44 rounded-full bg-[#F97316]/10 blur-3xl"></div>

            <div class="relative flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex min-w-0 items-center gap-4">
                    <span class="h-14 w-14 shrink-0 overflow-hidden rounded-2xl bg-[#EEF4FF] ring-1 ring-[#E8EDF5]">
                        @if($foto)
                            <img src="{{ $foto }}" alt="Foto {{ $siswa->nama }}" class="h-full w-full object-cover">
                        @else
                            <span class="flex h-full w-full items-center justify-center font-display text-xl font-bold text-[#2F6FED]">
                                {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                            </span>
                        @endif
                    </span>
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold uppercase tracking-[0.18em] text-[#2F6FED]">Dashboard Siswa</p>
                        <h1 class="mt-0.5 truncate font-display text-xl font-semibold text-[#0B1E38] sm:text-2xl">Halo, {{ $siswa->nama }} 👋</h1>
                        <p class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-[11.5px] text-[#64748B]">
                            <span class="inline-flex items-center gap-1">
                                <x-icon name="qr" :size="11" class="text-[#94A3B8]" />
                                NIS {{ $siswa->nis }}
                            </span>
                            <span class="text-[#CBD5E1]">&bull;</span>
                            <span>{{ $siswa->kelas }} {{ $siswa->jurusan }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('siswa.prestasi.index') }}"
                       class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-4 py-2.5 text-[13px] font-semibold text-white shadow-lg shadow-[#2F6FED]/20 transition hover:opacity-90">
                        <x-icon name="trophy" :size="15" />
                        Lihat Prestasi
                    </a>
                    <a href="{{ route('siswa.portofolio') }}"
                       class="inline-flex items-center gap-2 rounded-xl border border-[#E8EDF5] bg-white px-4 py-2.5 text-[13px] font-semibold text-[#475569] transition hover:bg-[#F8FAFC]">
                        <x-icon name="qr" :size="15" class="text-[#2F6FED]" />
                        Portofolio
                    </a>
                </div>
            </div>

            {{-- PROGRES --}}
            <div class="relative mt-5 rounded-xl bg-[#F8FAFC] px-4 py-3.5">
                <div class="flex items-center justify-between gap-3">
                    <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.06em] text-[#94A3B8]">
                        <x-icon name="check" :size="12" class="text-[#16A34A]" />
                        Progres verifikasi
                    </p>
                    <p class="text-[11.5px] font-semibold tabular-nums text-[#0B1E38]">
                        {{ $totalDisetujui }} / {{ $totalPrestasi }}
                        <span class="font-normal text-[#94A3B8]">terverifikasi</span>
                    </p>
                </div>
                <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-[#E2E8F0]">
                    <div class="h-full rounded-full bg-gradient-to-r from-[#2F6FED] to-[#F97316] transition-all duration-500"
                         style="width: {{ $persen }}%"></div>
                </div>
            </div>
        </section>

        {{-- STATISTIK --}}
        <div class="grid grid-cols-2 gap-3 xl:grid-cols-4">
            <a href="{{ route('siswa.prestasi.index') }}" class="block transition hover:-translate-y-0.5">
                <x-ui.stat-card label="Total Prestasi" :value="$totalPrestasi" icon="trophy" hint="seluruh pengajuan" tone="bg-[#EEF4FF] text-[#2F6FED]" />
            </a>
            <a href="{{ route('siswa.prestasi.index', ['status' => 'Disetujui']) }}" class="block transition hover:-translate-y-0.5">
                <x-ui.stat-card label="Disetujui" :value="$totalDisetujui" icon="check" hint="lolos verifikasi" tone="bg-[#ECFDF5] text-[#16A34A]" />
            </a>
            <a href="{{ route('siswa.prestasi.index', ['status' => 'Belum']) }}" class="block transition hover:-translate-y-0.5">
                <x-ui.stat-card label="Menunggu" :value="$totalMenunggu" icon="clock" hint="sedang ditinjau" tone="bg-[#FFF7ED] text-[#F97316]" />
            </a>
            <a href="{{ route('siswa.prestasi.index', ['status' => 'Ditolak']) }}" class="block transition hover:-translate-y-0.5">
                <x-ui.stat-card label="Ditolak / Revisi" :value="$totalDitolak" icon="x" hint="perlu diperbaiki" tone="bg-red-50 text-red-500" />
            </a>
        </div>

        {{-- KONTEN --}}
        <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-[minmax(0,1fr)_320px]">
            {{-- PRESTASI TERBARU --}}
            <section class="card overflow-hidden">
                <div class="flex items-center justify-between gap-3 border-b border-[#E8EDF5] px-5 py-4">
                    <div class="flex min-w-0 items-center gap-2.5">
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#EEF4FF] text-[#2F6FED]">
                            <x-icon name="trophy" :size="15" />
                        </span>
                        <div class="min-w-0">
                            <h2 class="truncate font-display text-sm font-semibold text-[#0B1E38]">Prestasi Terbaru</h2>
                            <p class="truncate text-[10.5px] text-[#94A3B8]">Pengajuan yang terakhir kamu kirim.</p>
                        </div>
                    </div>
                    <a href="{{ route('siswa.prestasi.index') }}"
                       class="inline-flex shrink-0 items-center gap-1 text-[11.5px] font-semibold text-[#2F6FED] transition hover:text-[#1B4FC4]">
                        Lihat semua
                        <x-icon name="chevron-right" :size="11" />
                    </a>
                </div>

                <div class="divide-y divide-[#F1F5F9]">
                    @forelse($prestasiTerbaru as $item)
                        <a href="{{ route('siswa.prestasi.show', $item) }}"
                           class="flex items-center gap-3 px-5 py-3.5 transition hover:bg-[#F8FAFC]">
                            <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                                <x-icon name="trophy" :size="15" />
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-[13px] font-semibold text-[#0B1E38]">{{ $item->nama_prestasi }}</p>
                                <p class="mt-0.5 flex items-center gap-1.5 truncate text-[11px] text-[#94A3B8]">
                                    <x-icon name="school" :size="11" class="shrink-0" />
                                    {{ $item->tingkat }}
                                    <span class="text-[#E2E8F0]">&bull;</span>
                                    {{ $item->tanggal->format('d M Y') }}
                                </p>
                            </div>
                            @include('siswa.partials.status-badge', ['prestasi' => $item])
                            <x-icon name="chevron-right" :size="14" class="hidden shrink-0 text-[#CBD5E1] sm:block" />
                        </a>
                    @empty
                        <x-ui.empty-state icon="trophy" title="Belum ada prestasi"
                                          description="Mulai catat pencapaian pertamamu sekarang.">
                            <a href="{{ route('siswa.prestasi.index') }}"
                               class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-4 py-2.5 text-[12px] font-semibold text-white shadow-lg shadow-[#2F6FED]/20 transition hover:opacity-90">
                                Buka Prestasi Saya
                                <x-icon name="chevron-right" :size="12" />
                            </a>
                        </x-ui.empty-state>
                    @endforelse
                </div>
            </section>

            {{-- PANEL KANAN --}}
            <div class="space-y-4">
                <section class="card p-5">
                    <h2 class="mb-3.5 flex items-center gap-2 font-display text-sm font-semibold text-[#0B1E38]">
                        <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#FFF7ED] text-[#F97316]">
                            <x-icon name="sparkles" :size="13" />
                        </span>
                        Aksi Cepat
                    </h2>
                    <div class="space-y-2">
                        <a href="{{ route('siswa.profil') }}"
                           class="group flex items-center gap-3 rounded-xl border border-[#E8EDF5] px-3.5 py-2.5 transition hover:border-[#2F6FED]/30 hover:bg-[#F8FAFC]">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#EEF4FF] text-[#2F6FED]">
                                <x-icon name="user" :size="14" />
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-[12.5px] font-semibold text-[#0B1E38]">Kelola Profil</span>
                                <span class="block truncate text-[10.5px] text-[#94A3B8]">Data pribadi &amp; foto</span>
                            </span>
                            <x-icon name="chevron-right" :size="12" class="shrink-0 text-[#CBD5E1] transition group-hover:text-[#2F6FED]" />
                        </a>

                        <a href="{{ route('akunpassword.edit') }}"
                           class="group flex items-center gap-3 rounded-xl border border-[#E8EDF5] px-3.5 py-2.5 transition hover:border-[#2F6FED]/30 hover:bg-[#F8FAFC]">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#F5F3FF] text-[#8B5CF6]">
                                <x-icon name="lock" :size="14" />
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="block text-[12.5px] font-semibold text-[#0B1E38]">Ganti Password</span>
                                <span class="block truncate text-[10.5px] text-[#94A3B8]">Jaga keamanan akun</span>
                            </span>
                            <x-icon name="chevron-right" :size="12" class="shrink-0 text-[#CBD5E1] transition group-hover:text-[#2F6FED]" />
                        </a>
                    </div>
                </section>

                <section class="rounded-2xl border border-[#BFDBFE] bg-[#EFF6FF] p-5">
                    <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1D4ED8]">
                        <x-icon name="sparkles" :size="13" />
                        Tips
                    </p>
                    <p class="mt-2 text-[11.5px] leading-relaxed text-[#3B82F6]">
                        Lengkapi sertifikat dan foto dokumentasi saat mengajukan prestasi. Data yang lengkap lebih cepat diverifikasi kesiswaan.
                    </p>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
