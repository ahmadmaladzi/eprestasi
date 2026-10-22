<x-app-layout title="Dashboard Kesiswaan">
    @php
        $user = auth()->user();
        $tanggal = now()->locale('id')->translatedFormat('l, j F Y');
        $totalVerifikasi = $totalMenunggu + $totalDisetujui + $totalDitolak;
        $persenSelesai = $totalVerifikasi > 0 ? round($totalDisetujui / $totalVerifikasi * 100) : 0;

        $radius = 42;
        $keliling = 2 * M_PI * $radius;
        $statusData = [
            ['label' => 'Disetujui', 'value' => $totalDisetujui, 'color' => '#22C55E'],
            ['label' => 'Menunggu', 'value' => $totalMenunggu, 'color' => '#F59E0B'],
            ['label' => 'Ditolak', 'value' => $totalDitolak, 'color' => '#EF4444'],
        ];
        $offset = 0;
        foreach ($statusData as $key => $row) {
            $len = $totalVerifikasi > 0 ? ($row['value'] / $totalVerifikasi) * $keliling : 0;
            $statusData[$key]['len'] = $len;
            $statusData[$key]['offset'] = $offset;
            $statusData[$key]['pct'] = $totalVerifikasi > 0 ? round($row['value'] / $totalVerifikasi * 100) : 0;
            $offset += $len;
        }

        $statTiles = [
            ['label' => 'Menunggu Verifikasi', 'value' => $totalMenunggu, 'hint' => 'antrean masuk', 'icon' => 'clock'],
            ['label' => 'Disetujui', 'value' => $totalDisetujui, 'hint' => $persenSelesai . '% dari antrean', 'icon' => 'check'],
            ['label' => 'Ditolak', 'value' => $totalDitolak, 'hint' => 'termasuk revisi', 'icon' => 'x'],
            ['label' => 'Siswa Aktif', 'value' => $totalSiswaAktif, 'hint' => 'terdaftar', 'icon' => 'users'],
        ];

        $aksiCepat = [
            ['label' => 'Verifikasi Antrean', 'icon' => 'clipboard', 'href' => route('kesiswaan.prestasi.index', ['status' => 'Belum']), 'tone' => 'bg-[#FFF7ED] text-[#F97316]'],
            ['label' => 'Data Prestasi', 'icon' => 'trophy', 'href' => route('kesiswaan.prestasi.index'), 'tone' => 'bg-[#EEF4FF] text-[#2F6FED]'],
            ['label' => 'Statistik', 'icon' => 'chart', 'href' => route('kesiswaan.statistik'), 'tone' => 'bg-[#ECFDF5] text-[#16A34A]'],
            ['label' => 'Profil Saya', 'icon' => 'user', 'href' => route('kesiswaan.profil'), 'tone' => 'bg-[#F5F3FF] text-[#8B5CF6]'],
        ];
    @endphp

    <div class="space-y-5">

        {{-- HERO --}}
        <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#2F6FED] via-[#1B4FC4] to-[#F97316] p-5 text-white shadow-xl shadow-[#2F6FED]/[0.15] sm:p-6 lg:p-7">
            <div class="pointer-events-none absolute -right-16 -top-24 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 left-1/3 h-56 w-56 rounded-full bg-[#F97316]/20 blur-3xl"></div>

            <div class="relative min-w-0">
                <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/55">Dashboard Kesiswaan</p>
                <h2 class="mt-1 truncate font-display text-xl font-semibold sm:text-2xl">Halo, {{ $user->nama }} 👋</h2>
                <p class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-white/65 sm:text-[13px]">
                    <span class="inline-flex items-center gap-1.5">
                        <x-icon name="calendar" :size="13" />
                        {{ $tanggal }}
                    </span>
                    @if($ajaranAktif)
                        <span class="inline-flex items-center gap-1.5">
                            <span class="h-1 w-1 rounded-full bg-white/40"></span>
                            Tahun ajaran {{ $ajaranAktif->tahun }}
                        </span>
                    @endif
                </p>
            </div>

            <div class="relative mt-5 grid grid-cols-2 gap-2.5 lg:grid-cols-4 lg:gap-3">
                @foreach($statTiles as $tile)
                    <div class="rounded-xl border border-white/15 bg-white/10 p-3.5 backdrop-blur-sm transition hover:bg-white/[0.16]">
                        <div class="flex items-center justify-between gap-2">
                            <p class="text-[11px] font-medium text-white/70">{{ $tile['label'] }}</p>
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-white/15 text-white">
                                <x-icon :name="$tile['icon']" :size="14" />
                            </span>
                        </div>
                        <p class="mt-1.5 font-display text-2xl font-bold leading-none tabular-nums">{{ number_format($tile['value'], 0, ',', '.') }}</p>
                        <p class="mt-1 truncate text-[10px] text-white/55">{{ $tile['hint'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- AKSI CEPAT --}}
        <section class="rounded-2xl border border-[#E8EDF5] bg-white p-4 sm:p-5">
            <div class="flex items-center gap-2">
                <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-[#FFF7ED] text-[#F97316]">
                    <x-icon name="sparkles" :size="14" />
                </span>
                <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Aksi Cepat</h2>
            </div>
            <div class="mt-3.5 grid grid-cols-2 gap-1.5 sm:grid-cols-4">
                @foreach($aksiCepat as $aksi)
                    <a href="{{ $aksi['href'] }}"
                       class="group flex flex-col items-center justify-center gap-2.5 rounded-xl border border-transparent px-3 py-4 text-center transition hover:border-[#E8EDF5] hover:bg-[#F8FAFC]">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl {{ $aksi['tone'] }} transition group-hover:scale-105">
                            <x-icon :name="$aksi['icon']" :size="19" />
                        </span>
                        <span class="text-[11.5px] font-semibold leading-tight text-[#475569] group-hover:text-[#0B1E38] sm:text-[12px]">{{ $aksi['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-12">
            {{-- AKTIVITAS --}}
            <section class="rounded-2xl border border-[#E8EDF5] bg-white p-5 lg:col-span-7">
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Aktivitas Terbaru</h2>
                        <p class="mt-0.5 text-[11px] text-[#94A3B8]">Pengajuan dan hasil verifikasi terakhir.</p>
                    </div>
                    <a href="{{ route('kesiswaan.prestasi.index') }}"
                       class="inline-flex items-center gap-1 rounded-lg border border-[#E8EDF5] px-2.5 py-1.5 text-[10.5px] font-semibold text-[#2F6FED] transition hover:bg-[#EEF4FF]">
                        Lihat semua
                        <x-icon name="chevron-right" :size="10" />
                    </a>
                </div>

                <div class="mt-3 space-y-1">
                    @forelse($aktivitasTerbaru as $item)
                        <div class="flex items-start gap-3 rounded-xl px-1.5 py-2.5 transition hover:bg-[#F8FAFC]">
                            @if($item['icon'] === 'diajukan')
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                                    <x-icon name="trophy" :size="15" />
                                </span>
                            @elseif($item['icon'] === 'disetujui')
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#ECFDF5] text-[#16A34A]">
                                    <x-icon name="check" :size="15" />
                                </span>
                            @else
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-red-50 text-red-500">
                                    <x-icon name="x" :size="15" />
                                </span>
                            @endif
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-[12.5px] font-semibold text-[#0B1E38]">{{ $item['judul'] }}</p>
                                <p class="truncate text-[11px] text-[#64748B]">{{ $item['deskripsi'] }}</p>
                            </div>
                            <span class="shrink-0 whitespace-nowrap pt-0.5 text-[10px] font-medium text-[#94A3B8]">
                                {{ $item['waktu']->locale('id')->diffForHumans() }}
                            </span>
                        </div>
                    @empty
                        <x-ui.empty-state icon="clock" title="Belum ada aktivitas"
                                          description="Pengajuan prestasi siswa akan muncul di sini." />
                    @endforelse
                </div>
            </section>

            {{-- STATUS --}}
            <section class="rounded-2xl border border-[#E8EDF5] bg-white p-5 lg:col-span-5">
                <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Status Verifikasi</h2>
                <p class="mt-0.5 text-[11px] text-[#94A3B8]">{{ $ajaranAktif ? 'Tahun ajaran ' . $ajaranAktif->tahun : 'Belum ada tahun ajaran aktif' }}</p>

                <div class="relative mx-auto mt-4 h-36 w-36">
                    <svg viewBox="0 0 120 120" class="h-full w-full -rotate-90" role="img" aria-label="Distribusi status verifikasi">
                        <circle cx="60" cy="60" r="{{ $radius }}" fill="none" stroke="#F1F5F9" stroke-width="14" />
                        @foreach($statusData as $row)
                            @if($row['value'] > 0)
                                <circle cx="60" cy="60" r="{{ $radius }}" fill="none"
                                        stroke="{{ $row['color'] }}" stroke-width="14"
                                        stroke-dasharray="{{ $row['len'] }} {{ $keliling - $row['len'] }}"
                                        stroke-dashoffset="{{ -$row['offset'] }}">
                                    <title>{{ $row['label'] }}: {{ $row['value'] }}</title>
                                </circle>
                            @endif
                        @endforeach
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="font-display text-2xl font-bold leading-none text-[#0B1E38]">{{ $totalVerifikasi }}</span>
                        <span class="mt-1 text-[10px] font-medium uppercase tracking-wider text-[#94A3B8]">Antrean</span>
                    </div>
                </div>

                <div class="mt-4 space-y-2.5">
                    @foreach($statusData as $row)
                        <div class="flex items-center gap-2.5">
                            <span class="h-2 w-2 shrink-0 rounded-full" style="background-color: {{ $row['color'] }}"></span>
                            <span class="flex-1 text-[12px] text-[#64748B]">{{ $row['label'] }}</span>
                            <span class="text-[12px] font-bold tabular-nums text-[#0B1E38]">{{ $row['value'] }}</span>
                            <span class="w-9 text-right text-[10.5px] tabular-nums text-[#94A3B8]">{{ $row['pct'] }}%</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 rounded-xl bg-[#F8FAFC] px-3.5 py-3">
                    <div class="flex items-center justify-between gap-2">
                        <p class="text-[10.5px] font-semibold uppercase tracking-wider text-[#94A3B8]">Progres verifikasi</p>
                        <p class="text-[11px] font-bold text-[#0B1E38]">{{ $persenSelesai }}%</p>
                    </div>
                    <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-[#E2E8F0]">
                        <div class="h-full rounded-full bg-gradient-to-r from-[#22C55E] to-[#16A34A]" style="width: {{ $persenSelesai }}%"></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
