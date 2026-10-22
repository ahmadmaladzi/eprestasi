<x-app-layout title="Dashboard">
    @php
        $user = auth()->user();
        $tanggal = now()->locale('id')->translatedFormat('l, j F Y');
        $periodeLabel = $tampilkanSemua ? 'Semua tahun ajaran' : ($selectedAjaran?->tahun ?? 'Tahun ajaran aktif');
        $persenDisetujui = $totalPrestasi > 0 ? round($totalDisetujui / $totalPrestasi * 100) : 0;
        $rataPerSiswa = $totalSiswa > 0 ? round($totalPrestasi / $totalSiswa, 1) : 0;
        $leaderboardTampil = $leaderboard->filter(fn ($s) => $s->prestasi_disetujui_count > 0)->values();

        // Data bar chart per tingkat (urutan tetap, termasuk yang kosong)
        $urutanTingkat = ['Sekolah', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional'];
        $labelSingkat = [
            'Sekolah' => 'Sekolah',
            'Kabupaten/Kota' => 'Kab/Kota',
            'Provinsi' => 'Provinsi',
            'Nasional' => 'Nasional',
            'Internasional' => 'Internasional',
        ];
        $bars = collect($urutanTingkat)->mapWithKeys(fn ($t) => [$t => (int) ($perTingkat[$t] ?? 0)]);
        foreach ($perTingkat as $k => $v) {
            if (! $bars->has($k)) {
                $bars->put($k, (int) $v);
            }
        }
        $maxBar = max(1, (int) $bars->max());

        // Data donut per kategori
        $kategoriTotal = (int) $perKategori->sum();
        $palette = ['#2F6FED', '#F97316', '#22C55E', '#8B5CF6', '#06B6D4', '#F43F5E', '#F59E0B'];
        $radius = 42;
        $keliling = 2 * M_PI * $radius;
        $offset = 0;
        $segments = [];
        $i = 0;
        foreach ($perKategori as $nama => $jumlah) {
            $jumlah = (int) $jumlah;
            $panjang = $kategoriTotal > 0 ? ($jumlah / $kategoriTotal) * $keliling : 0;
            $segments[] = [
                'label' => $nama,
                'value' => $jumlah,
                'color' => $palette[$i % count($palette)],
                'len' => $panjang,
                'offset' => $offset,
                'pct' => $kategoriTotal > 0 ? round($jumlah / $kategoriTotal * 100) : 0,
            ];
            $offset += $panjang;
            $i++;
        }

        $statTiles = [
            ['label' => 'Total Siswa', 'value' => $totalSiswa, 'hint' => 'terdaftar di sistem', 'icon' => 'users'],
            ['label' => 'Total Prestasi', 'value' => $totalPrestasi, 'hint' => $periodeLabel, 'icon' => 'trophy'],
            ['label' => 'Menunggu Verifikasi', 'value' => $totalBelum, 'hint' => 'perlu ditinjau', 'icon' => 'clock'],
            ['label' => 'Disetujui', 'value' => $totalDisetujui, 'hint' => $persenDisetujui . '% dari total', 'icon' => 'check'],
        ];

        $aksiCepat = [
            ['label' => 'Tambah Pengguna', 'icon' => 'plus', 'href' => route('admin.users.create'), 'tone' => 'bg-[#EEF4FF] text-[#2F6FED]'],
            ['label' => 'Import Excel', 'icon' => 'upload', 'href' => route('admin.users.import.form'), 'tone' => 'bg-[#ECFDF5] text-[#16A34A]'],
            ['label' => 'Kelola Kelas', 'icon' => 'school', 'href' => route('admin.kelas.index'), 'tone' => 'bg-[#FFF7ED] text-[#F97316]'],
            ['label' => 'Tahun Ajaran', 'icon' => 'calendar', 'href' => route('admin.ajaran.index'), 'tone' => 'bg-[#F5F3FF] text-[#8B5CF6]'],
            ['label' => 'Kelulusan', 'icon' => 'graduation', 'href' => route('admin.kelulusan.index'), 'tone' => 'bg-[#ECFEFF] text-[#0891B2]'],
            ['label' => 'Kenaikan Kelas', 'icon' => 'arrow-up', 'href' => route('admin.kenaikan-kelas.index'), 'tone' => 'bg-[#FFF1F2] text-[#E11D48]'],
        ];
    @endphp

    <div class="space-y-5">

        {{-- HERO --}}
        <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#2F6FED] via-[#1B4FC4] to-[#F97316] p-5 text-white shadow-xl shadow-[#2F6FED]/[0.15] sm:p-6 lg:p-7">
            <div class="pointer-events-none absolute -right-16 -top-24 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 left-1/3 h-56 w-56 rounded-full bg-[#F97316]/20 blur-3xl"></div>

            <div class="relative flex flex-wrap items-start justify-between gap-4">
                <div class="min-w-0">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.2em] text-white/55">Dashboard Admin</p>
                    <h2 class="mt-1 truncate font-display text-xl font-semibold sm:text-2xl">Selamat datang, {{ $user->nama }} 👋</h2>
                    <p class="mt-1 flex items-center gap-1.5 text-xs text-white/65 sm:text-[13px]">
                        <x-icon name="calendar" :size="13" class="shrink-0" />
                        {{ $tanggal }}
                    </p>
                </div>

                @if($semuaTahunAjaran->isNotEmpty())
                    <form method="GET" class="relative shrink-0">
                        <label for="tahun_ajaran" class="sr-only">Tahun ajaran</label>
                        <select id="tahun_ajaran" name="tahun_ajaran" onchange="this.form.submit()"
                                class="appearance-none rounded-xl border border-white/20 bg-white/15 py-2 pl-3 pr-8 text-xs font-semibold text-white backdrop-blur transition hover:bg-white/20 focus:border-white/40 focus:outline-none focus:ring-2 focus:ring-white/30">
                            @foreach($semuaTahunAjaran as $ta)
                                <option value="{{ $ta->id_ajaran }}" class="text-[#0B1E38]" @selected(! $tampilkanSemua && $selectedAjaran && $selectedAjaran->id_ajaran === $ta->id_ajaran)>
                                    {{ $ta->tahun }}{{ $ta->status === 'Aktif' ? ' (Aktif)' : '' }}
                                </option>
                            @endforeach
                            <option value="semua" class="text-[#0B1E38]" @selected($tampilkanSemua)>Semua Tahun Ajaran</option>
                        </select>
                        <svg class="pointer-events-none absolute right-2.5 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-white/70" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="m6 9 6 6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </form>
                @endif
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
            <div class="mt-3.5 grid grid-cols-3 gap-1.5 sm:grid-cols-6">
                @foreach($aksiCepat as $aksi)
                    <a href="{{ $aksi['href'] }}"
                       class="group flex flex-col items-center justify-center gap-2.5 rounded-xl border border-transparent px-2 py-3.5 text-center transition hover:border-[#E8EDF5] hover:bg-[#F8FAFC]">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl {{ $aksi['tone'] }} transition group-hover:scale-105">
                            <x-icon :name="$aksi['icon']" :size="19" />
                        </span>
                        <span class="text-[11px] font-semibold leading-tight text-[#475569] group-hover:text-[#0B1E38] sm:text-[12px]">{{ $aksi['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </section>

        {{-- CHART + AKTIVITAS --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-12">
            {{-- BAR --}}
            <section class="rounded-2xl border border-[#E8EDF5] bg-white p-5 lg:col-span-1 xl:col-span-4">
                <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Prestasi per Tingkat</h2>
                <p class="mt-0.5 text-[11px] text-[#94A3B8]">{{ $periodeLabel }}</p>

                @if($bars->sum() > 0)
                    <div class="mt-5 flex h-40 items-end gap-2">
                        @foreach($bars as $nama => $jumlah)
                            @php $tinggi = max(4, (int) round($jumlah / $maxBar * 118)); @endphp
                            <div class="flex flex-1 flex-col items-center justify-end gap-1.5" title="{{ $nama }}: {{ $jumlah }} prestasi">
                                <span class="text-[11px] font-semibold tabular-nums {{ $jumlah > 0 ? 'text-[#0B1E38]' : 'text-[#CBD5E1]' }}">{{ $jumlah }}</span>
                                <div class="w-full max-w-[38px] rounded-t-md {{ $jumlah > 0 ? 'bg-gradient-to-t from-[#2F6FED] to-[#6B9AF8]' : 'bg-[#F1F5F9]' }}"
                                     style="height: {{ $tinggi }}px"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2 flex gap-2 border-t border-dashed border-[#E8EDF5] pt-2">
                        @foreach($bars as $nama => $jumlah)
                            <span class="flex-1 text-center text-[9px] font-medium leading-tight text-[#94A3B8] sm:text-[10px]">{{ $labelSingkat[$nama] ?? $nama }}</span>
                        @endforeach
                    </div>
                @else
                    <div class="mt-6 flex h-40 flex-col items-center justify-center text-center">
                        <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F5F7FB] text-[#94A3B8]">
                            <x-icon name="chart" :size="18" />
                        </span>
                        <p class="mt-3 text-xs font-medium text-[#64748B]">Belum ada data prestasi</p>
                        <p class="mt-0.5 text-[11px] text-[#94A3B8]">Data akan muncul setelah siswa mengajukan prestasi.</p>
                    </div>
                @endif
            </section>

            {{-- DONUT --}}
            <section class="rounded-2xl border border-[#E8EDF5] bg-white p-5 lg:col-span-1 xl:col-span-3">
                <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Per Kategori</h2>
                <p class="mt-0.5 text-[11px] text-[#94A3B8]">Semua status prestasi</p>

                <div class="relative mx-auto mt-4 h-36 w-36">
                    <svg viewBox="0 0 120 120" class="h-full w-full -rotate-90" role="img" aria-label="Distribusi prestasi per kategori">
                        <circle cx="60" cy="60" r="{{ $radius }}" fill="none" stroke="#F1F5F9" stroke-width="14" />
                        @foreach($segments as $seg)
                            <circle cx="60" cy="60" r="{{ $radius }}" fill="none"
                                    stroke="{{ $seg['color'] }}" stroke-width="14"
                                    stroke-dasharray="{{ $seg['len'] }} {{ $keliling - $seg['len'] }}"
                                    stroke-dashoffset="{{ -$seg['offset'] }}">
                                <title>{{ $seg['label'] }}: {{ $seg['value'] }}</title>
                            </circle>
                        @endforeach
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="font-display text-2xl font-bold leading-none text-[#0B1E38]">{{ $kategoriTotal }}</span>
                        <span class="mt-1 text-[10px] font-medium uppercase tracking-wider text-[#94A3B8]">Total</span>
                    </div>
                </div>

                @if($segments)
                    <div class="mt-4 max-h-32 space-y-1.5 overflow-y-auto pr-1 scrollbar-slim">
                        @foreach($segments as $seg)
                            <div class="flex items-center gap-2 text-[11px]">
                                <span class="h-2 w-2 shrink-0 rounded-full" style="background-color: {{ $seg['color'] }}"></span>
                                <span class="min-w-0 flex-1 truncate text-[#64748B]">{{ $seg['label'] }}</span>
                                <span class="font-semibold tabular-nums text-[#0B1E38]">{{ $seg['value'] }}</span>
                                <span class="w-8 text-right tabular-nums text-[#94A3B8]">{{ $seg['pct'] }}%</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="mt-4 text-center text-[11px] text-[#94A3B8]">Belum ada kategori terisi.</p>
                @endif
            </section>

            {{-- AKTIVITAS --}}
            <section class="rounded-2xl border border-[#E8EDF5] bg-white p-5 lg:col-span-2 xl:col-span-5">
                <div class="flex items-center justify-between gap-2">
                    <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Aktivitas Terbaru</h2>
                    <span class="rounded-full bg-[#F5F7FB] px-2.5 py-1 text-[10px] font-semibold text-[#64748B]">{{ $aktivitasTerbaru->count() }} terbaru</span>
                </div>

                <div class="mt-3 max-h-[280px] space-y-1 overflow-y-auto pr-1 scrollbar-slim">
                    @forelse($aktivitasTerbaru as $item)
                        <div class="flex items-start gap-3 rounded-xl px-1.5 py-2.5 transition hover:bg-[#F8FAFC]">
                            @if($item['icon'] === 'prestasi')
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                                    <x-icon name="trophy" :size="15" />
                                </span>
                            @else
                                <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F5F3FF] text-[#8B5CF6]">
                                    <x-icon name="user" :size="15" />
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
                        <div class="flex flex-col items-center justify-center py-10 text-center">
                            <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#F5F7FB] text-[#94A3B8]">
                                <x-icon name="clock" :size="18" />
                            </span>
                            <p class="mt-3 text-xs font-medium text-[#64748B]">Belum ada aktivitas</p>
                            <p class="mt-0.5 text-[11px] text-[#94A3B8]">Aktivitas pengguna akan tampil di sini.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- LEADERBOARD + STATUS --}}
        <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-2 xl:grid-cols-12">
            <section class="rounded-2xl border border-[#E8EDF5] bg-white p-5 lg:col-span-1 xl:col-span-7">
                <div class="flex items-center justify-between gap-2">
                    <div>
                        <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Leaderboard Siswa</h2>
                        <p class="mt-0.5 text-[11px] text-[#94A3B8]">Prestasi disetujui terbanyak</p>
                    </div>
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#FFF7ED] text-[#F97316]">
                        <x-icon name="trophy" :size="15" />
                    </span>
                </div>

                <div class="mt-3 space-y-1">
                    @forelse($leaderboardTampil as $index => $s)
                        @php
                            $rankTone = match ($index) {
                                0 => 'bg-[#FEF3C7] text-[#B45309]',
                                1 => 'bg-[#F1F5F9] text-[#475569]',
                                2 => 'bg-[#FFEDD5] text-[#C2410C]',
                                default => 'bg-[#F8FAFC] text-[#94A3B8]',
                            };
                        @endphp
                        <div class="flex items-center gap-3 rounded-xl px-1.5 py-2 transition hover:bg-[#F8FAFC]">
                            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-[11px] font-bold {{ $rankTone }}">{{ $index + 1 }}</span>
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0B1E38] text-[10px] font-semibold text-white">
                                {{ strtoupper(substr($s->nama, 0, 1)) }}
                            </span>
                            <div class="min-w-0 flex-1">
                                <p class="truncate text-[12.5px] font-semibold text-[#0B1E38]">{{ $s->nama }}</p>
                                <p class="truncate text-[10.5px] text-[#94A3B8]">{{ $s->kelas ?: '—' }} {{ $s->jurusan }}</p>
                            </div>
                            <span class="shrink-0 rounded-full bg-[#EEF4FF] px-2.5 py-1 text-[10.5px] font-bold text-[#2F6FED]">
                                {{ $s->prestasi_disetujui_count }} prestasi
                            </span>
                        </div>
                    @empty
                        <div class="py-8 text-center text-xs text-[#94A3B8]">Belum ada data prestasi yang disetujui.</div>
                    @endforelse
                </div>
            </section>

            <section class="rounded-2xl border border-[#E8EDF5] bg-white p-5 lg:col-span-1 xl:col-span-5">
                <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Distribusi Status</h2>
                <p class="mt-0.5 text-[11px] text-[#94A3B8]">{{ $periodeLabel }}</p>

                @php
                    $totalStatus = max(1, $totalPrestasi);
                    $statusRows = [
                        ['label' => 'Disetujui', 'value' => $totalDisetujui, 'color' => 'bg-[#22C55E]', 'dot' => 'bg-[#22C55E]', 'text' => 'text-[#15803D]'],
                        ['label' => 'Menunggu', 'value' => $totalBelum, 'color' => 'bg-[#F59E0B]', 'dot' => 'bg-[#F59E0B]', 'text' => 'text-[#B45309]'],
                        ['label' => 'Ditolak', 'value' => $totalDitolak, 'color' => 'bg-[#EF4444]', 'dot' => 'bg-[#EF4444]', 'text' => 'text-[#B91C1C]'],
                    ];
                @endphp

                <div class="mt-4 flex h-2.5 overflow-hidden rounded-full bg-[#F1F5F9]">
                    @foreach($statusRows as $row)
                        @if($row['value'] > 0)
                            <div class="{{ $row['color'] }}" style="width: {{ round($row['value'] / $totalStatus * 100, 2) }}%" title="{{ $row['label'] }}: {{ $row['value'] }}"></div>
                        @endif
                    @endforeach
                </div>

                <div class="mt-4 space-y-2.5">
                    @foreach($statusRows as $row)
                        <div class="flex items-center gap-2.5">
                            <span class="h-2 w-2 shrink-0 rounded-full {{ $row['dot'] }}"></span>
                            <span class="flex-1 text-[12px] text-[#64748B]">{{ $row['label'] }}</span>
                            <span class="text-[12px] font-bold tabular-nums {{ $row['text'] }}">{{ $row['value'] }}</span>
                            <span class="w-9 text-right text-[10.5px] tabular-nums text-[#94A3B8]">{{ round($row['value'] / $totalStatus * 100) }}%</span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 grid grid-cols-2 gap-2.5">
                    <div class="rounded-xl bg-[#F8FAFC] px-3.5 py-2.5">
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-[#94A3B8]">Rata-rata / Siswa</p>
                        <p class="mt-0.5 font-display text-base font-bold leading-none text-[#0B1E38]">{{ $rataPerSiswa }}</p>
                    </div>
                    <div class="rounded-xl bg-[#F8FAFC] px-3.5 py-2.5">
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-[#94A3B8]">Siswa Terdaftar</p>
                        <p class="mt-0.5 font-display text-base font-bold leading-none text-[#0B1E38]">{{ $totalSiswa }}</p>
                    </div>
                </div>

                <div class="mt-3 flex items-center justify-between rounded-xl bg-[#F8FAFC] px-3.5 py-3">
                    <div>
                        <p class="text-[10px] font-semibold uppercase tracking-wider text-[#94A3B8]">Total Prestasi</p>
                        <p class="mt-0.5 font-display text-lg font-bold leading-none text-[#0B1E38]">{{ $totalPrestasi }}</p>
                    </div>
                    <a href="{{ route('admin.users.index', ['role' => 'siswa']) }}"
                       class="inline-flex items-center gap-1 rounded-lg bg-white px-3 py-1.5 text-[11px] font-semibold text-[#2F6FED] ring-1 ring-[#E8EDF5] transition hover:ring-[#2F6FED]/30">
                        Lihat siswa
                        <x-icon name="chevron-right" :size="11" />
                    </a>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
