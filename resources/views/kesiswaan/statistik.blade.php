<x-app-layout title="Statistik Prestasi">
    @php
        $periodeLabel = $tampilkanSemua ? 'Semua tahun ajaran' : ($selectedAjaran?->tahun ?? 'Tahun ajaran aktif');

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
    @endphp

    <div class="space-y-4">

        {{-- FILTER --}}
        <section class="card p-4">
            <form method="GET" class="flex flex-wrap items-end gap-3">
                <div>
                    <label class="field-label" for="tahun_ajaran">Tahun Ajaran</label>
                    <select id="tahun_ajaran" name="tahun_ajaran" onchange="this.form.submit()"
                            class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        @foreach($semuaTahunAjaran as $ta)
                            <option value="{{ $ta->id_ajaran }}" @selected(! $tampilkanSemua && $selectedAjaran && $selectedAjaran->id_ajaran === $ta->id_ajaran)>
                                {{ $ta->tahun }}{{ $ta->status === 'Aktif' ? ' (Aktif)' : '' }}
                            </option>
                        @endforeach
                        <option value="semua" @selected($tampilkanSemua)>Semua Tahun Ajaran</option>
                    </select>
                </div>
                <div>
                    <label class="field-label" for="jurusan">Jurusan</label>
                    <select id="jurusan" name="jurusan" onchange="this.form.submit()"
                            class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Semua Jurusan</option>
                        @foreach($daftarJurusan as $jurusan)
                            <option value="{{ $jurusan }}" @selected($jurusanDipilih === $jurusan)>{{ $jurusan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center gap-2 pb-0.5">
                    @if($jurusanDipilih)
                        <a href="{{ route('kesiswaan.statistik', request()->except('jurusan')) }}" class="btn-ghost py-2">Reset Jurusan</a>
                    @endif
                    <span class="rounded-full bg-[#EEF4FF] px-3 py-1.5 text-[11px] font-semibold text-[#2F6FED]">{{ $periodeLabel }}{{ $jurusanDipilih ? ' · ' . $jurusanDipilih : '' }}</span>
                </div>
            </form>
        </section>

        {{-- ANGKA --}}
        <div class="grid grid-cols-2 gap-3 xl:grid-cols-4">
            <x-ui.stat-card label="Total Prestasi" :value="$totalPrestasi" icon="trophy" hint="seluruh pengajuan" tone="bg-[#EEF4FF] text-[#2F6FED]" />
            <x-ui.stat-card label="Belum Diverifikasi" :value="$totalBelum" icon="clock" hint="menunggu tindakan" tone="bg-[#FFF7ED] text-[#F97316]" />
            <x-ui.stat-card label="Disetujui" :value="$totalDisetujui" icon="check" hint="lolos verifikasi" tone="bg-[#ECFDF5] text-[#16A34A]" />
            <x-ui.stat-card label="Ditolak" :value="$totalDitolak" icon="x" hint="termasuk revisi" tone="bg-red-50 text-red-500" />
        </div>

        {{-- CHART --}}
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-12">
            <section class="card p-5 lg:col-span-7">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Prestasi per Tingkat</h2>
                        <p class="mt-0.5 text-[11px] text-[#94A3B8]">{{ $periodeLabel }}</p>
                    </div>
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#EEF4FF] text-[#2F6FED]">
                        <x-icon name="chart" :size="15" />
                    </span>
                </div>

                @if($bars->sum() > 0)
                    <div class="mt-5 flex h-44 items-end gap-2">
                        @foreach($bars as $nama => $jumlah)
                            @php $tinggi = max(4, (int) round($jumlah / $maxBar * 130)); @endphp
                            <div class="flex flex-1 flex-col items-center justify-end gap-1.5" title="{{ $nama }}: {{ $jumlah }} prestasi">
                                <span class="text-[11px] font-semibold tabular-nums {{ $jumlah > 0 ? 'text-[#0B1E38]' : 'text-[#CBD5E1]' }}">{{ $jumlah }}</span>
                                <div class="w-full max-w-[46px] rounded-t-lg {{ $jumlah > 0 ? 'bg-gradient-to-t from-[#2F6FED] to-[#6B9AF8]' : 'bg-[#F1F5F9]' }}"
                                     style="height: {{ $tinggi }}px"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-2 flex gap-2 border-t border-dashed border-[#E8EDF5] pt-2">
                        @foreach($bars as $nama => $jumlah)
                            <span class="flex-1 text-center text-[9.5px] font-medium leading-tight text-[#94A3B8] sm:text-[10.5px]">{{ $labelSingkat[$nama] ?? $nama }}</span>
                        @endforeach
                    </div>
                @else
                    <x-ui.empty-state icon="chart" title="Belum ada data prestasi" description="Data akan muncul setelah siswa mengajukan prestasi." />
                @endif
            </section>

            <section class="card p-5 lg:col-span-5">
                <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Per Kategori</h2>
                <p class="mt-0.5 text-[11px] text-[#94A3B8]">Prestasi yang sudah memiliki kategori</p>

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
                    <div class="mt-4 space-y-1.5">
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
        </div>

        {{-- LEADERBOARD --}}
        <section class="card p-5">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Leaderboard Siswa</h2>
                    <p class="mt-0.5 text-[11px] text-[#94A3B8]">Prestasi disetujui terbanyak · {{ $periodeLabel }}</p>
                </div>
                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#FFF7ED] text-[#F97316]">
                    <x-icon name="trophy" :size="15" />
                </span>
            </div>

            <div class="mt-3 grid gap-1.5 sm:grid-cols-2">
                @forelse($leaderboard as $index => $s)
                    @php
                        $rankTone = match ($index) {
                            0 => 'bg-[#FEF3C7] text-[#B45309]',
                            1 => 'bg-[#F1F5F9] text-[#475569]',
                            2 => 'bg-[#FFEDD5] text-[#C2410C]',
                            default => 'bg-[#F8FAFC] text-[#94A3B8]',
                        };
                    @endphp
                    <div class="flex items-center gap-3 rounded-xl px-2 py-2.5 transition hover:bg-[#F8FAFC]">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-[11px] font-bold {{ $rankTone }}">{{ $index + 1 }}</span>
                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0B1E38] text-[10px] font-semibold text-white">
                            {{ strtoupper(substr($s->nama, 0, 1)) }}
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-[12.5px] font-semibold text-[#0B1E38]">{{ $s->nama }}</p>
                            <p class="truncate text-[10.5px] text-[#94A3B8]">{{ $s->kelas ?: '—' }} {{ $s->jurusan }}</p>
                        </div>
                        <span class="shrink-0 rounded-full bg-[#EEF4FF] px-2.5 py-1 text-[10.5px] font-bold text-[#2F6FED]">{{ $s->prestasi_disetujui_count }} prestasi</span>
                    </div>
                @empty
                    <div class="sm:col-span-2">
                        <x-ui.empty-state icon="trophy" title="Belum ada data" description="Leaderboard diisi setelah ada prestasi yang disetujui." />
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
