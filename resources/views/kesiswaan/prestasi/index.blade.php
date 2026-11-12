<x-app-layout title="Verifikasi Prestasi">
    @php
        $statusAktif = request('status', '');
        $filterAktif = request()->hasAny(['search', 'tahun_ajaran', 'status', 'tingkat', 'kategori', 'asal', 'jenis_penyelenggara', 'puspresnas', 'sort']);
    @endphp

    <div class="space-y-4">

        {{-- RINGKASAN --}}
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            @foreach([
                ['Belum', 'Menunggu Verifikasi', $totalMenunggu, 'clock', 'bg-[#FFF7ED] text-[#F97316]', 'border-[#F59E0B]/40 ring-1 ring-[#F59E0B]/20'],
                ['Disetujui', 'Disetujui', $totalDisetujui, 'check', 'bg-[#ECFDF5] text-[#16A34A]', 'border-[#22C55E]/40 ring-1 ring-[#22C55E]/20'],
                ['Ditolak', 'Ditolak / Revisi', $totalDitolak, 'x', 'bg-red-50 text-red-500', 'border-red-300 ring-1 ring-red-200'],
            ] as [$status, $label, $jumlah, $icon, $tone, $activeRing])
                <a href="{{ route('kesiswaan.prestasi.index', array_merge(request()->except('status'), ['status' => $status])) }}"
                   class="rounded-2xl border bg-white p-4 transition hover:shadow-sm sm:p-5 {{ $statusAktif === $status ? $activeRing : 'border-[#E8EDF5] hover:border-[#2F6FED]/30' }}">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">{{ $label }}</p>
                            <p class="mt-1.5 font-display text-2xl font-bold leading-none tabular-nums {{ $status === 'Ditolak' ? 'text-red-600' : ($status === 'Disetujui' ? 'text-[#15803D]' : 'text-[#B45309]') }}">{{ $jumlah }}</p>
                            <p class="mt-1.5 text-[10.5px] text-[#94A3B8]">{{ $statusAktif === $status ? 'Filter aktif — klik untuk semua' : 'Klik untuk memfilter' }}</p>
                        </div>
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl {{ $tone }}">
                            <x-icon :name="$icon" :size="16" />
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- FILTER --}}
        <section class="card p-4">
            <form method="GET" class="space-y-3">
                <div class="flex flex-col gap-2 sm:flex-row">
                    <div class="relative flex-1">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                            <x-icon name="search" :size="15" />
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa atau prestasi..."
                               class="w-full rounded-xl border-[#E2E8F0] py-2 pl-9 pr-3 text-[13px] text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                    </div>
                    <select name="tahun_ajaran" class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 sm:w-48">
                        @foreach($daftarAjaran as $ajaran)
                            <option value="{{ $ajaran->id_ajaran }}" @selected((string) request('tahun_ajaran', optional($daftarAjaran->firstWhere('status', 'Aktif'))->id_ajaran) === (string) $ajaran->id_ajaran)>
                                {{ $ajaran->tahun }}{{ $ajaran->status === 'Aktif' ? ' (Aktif)' : '' }}
                            </option>
                        @endforeach
                        <option value="semua" @selected(request('tahun_ajaran') === 'semua')>Semua Tahun</option>
                    </select>
                    <select name="status" class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 sm:w-40">
                        <option value="">Semua Status</option>
                        <option value="Belum" @selected(request('status') === 'Belum')>Menunggu</option>
                        <option value="Disetujui" @selected(request('status') === 'Disetujui')>Disetujui</option>
                        <option value="Ditolak" @selected(request('status') === 'Ditolak')>Ditolak / Revisi</option>
                    </select>
                </div>

                <div class="flex flex-wrap items-center gap-2 border-t border-[#E8EDF5] pt-3">
                    <select name="tingkat" class="rounded-xl border-[#E2E8F0] py-1.5 pl-3 pr-8 text-[12px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Semua Tingkat</option>
                        @foreach(['Sekolah','Kabupaten/Kota','Provinsi','Nasional','Internasional'] as $t)
                            <option value="{{ $t }}" @selected(request('tingkat') === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                    <select name="kategori" class="rounded-xl border-[#E2E8F0] py-1.5 pl-3 pr-8 text-[12px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Semua Kategori</option>
                        @foreach(['Akademik' => 'Akademik', 'Non Akademik' => 'Non-Akademik'] as $value => $label)
                            <option value="{{ $value }}" @selected(request('kategori') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <select name="asal" class="rounded-xl border-[#E2E8F0] py-1.5 pl-3 pr-8 text-[12px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Lingkup Instansi</option>
                        <option value="Dalam Negeri" @selected(request('asal') === 'Dalam Negeri')>Dalam Lingkup Kementerian Pendidikan</option>
                        <option value="Luar Negeri" @selected(request('asal') === 'Luar Negeri')>Di Luar Lingkup Kementerian Pendidikan</option>
                    </select>
                    <select name="jenis_penyelenggara" class="rounded-xl border-[#E2E8F0] py-1.5 pl-3 pr-8 text-[12px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Tipe Penyelenggara</option>
                        <option value="Kementerian" @selected(request('jenis_penyelenggara') === 'Kementerian')>Pemerintah / Negeri</option>
                        <option value="Non Kementerian" @selected(request('jenis_penyelenggara') === 'Non Kementerian')>Swasta / Yayasan</option>
                    </select>
                    <select name="puspresnas" class="rounded-xl border-[#E2E8F0] py-1.5 pl-3 pr-8 text-[12px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Status Puspresnas</option>
                        <option value="ya" @selected(request('puspresnas') === 'ya')>Terhubung</option>
                        <option value="tidak" @selected(request('puspresnas') === 'tidak')>Tidak Terhubung</option>
                    </select>
                    <select name="sort" class="rounded-xl border-[#E2E8F0] py-1.5 pl-3 pr-8 text-[12px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Terbaru</option>
                        <option value="terlama" @selected(request('sort') === 'terlama')>Terlama</option>
                        <option value="nama_az" @selected(request('sort') === 'nama_az')>Prestasi A-Z</option>
                        <option value="nama_za" @selected(request('sort') === 'nama_za')>Prestasi Z-A</option>
                        <option value="siswa_az" @selected(request('sort') === 'siswa_az')>Siswa A-Z</option>
                    </select>

                    <div class="ml-auto flex items-center gap-2">
                        @if($filterAktif)
                            <a href="{{ route('kesiswaan.prestasi.index') }}" class="text-[12px] font-medium text-[#94A3B8] transition hover:text-[#475569]">Reset</a>
                        @endif
                        <button class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-3.5 py-2 text-[12.5px] font-semibold text-white shadow-lg shadow-[#2F6FED]/20 transition hover:opacity-90">
                            <x-icon name="filter" :size="13" />
                            Terapkan
                        </button>
                    </div>
                </div>
            </form>
        </section>

        {{-- TABEL --}}
        <section class="card overflow-hidden">
            <div class="flex items-center justify-between gap-3 px-5 py-3.5">
                <div>
                    <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Daftar Pengajuan</h2>
                    <p class="mt-0.5 text-[11px] text-[#94A3B8]">Klik detail untuk memeriksa berkas dan memberi keputusan.</p>
                </div>
                <span class="shrink-0 rounded-full bg-[#F5F7FB] px-2.5 py-1 text-[10.5px] font-semibold text-[#64748B]">{{ $prestasi->total() }} data</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[860px] text-sm">
                    <thead class="border-y border-[#E8EDF5] bg-[#F8FAFC] text-left">
                        <tr>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Siswa</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Prestasi</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Tingkat</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Tahun</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Tanggal</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Status</th>
                            <th class="px-5 py-3 text-right text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($prestasi as $item)
                            @php
                                $badge = match(true) {
                                    $item->status === 'Disetujui' => 'bg-[#ECFDF5] text-[#15803D]',
                                    $item->status === 'Ditolak' && $item->perlu_revisi => 'bg-[#FFF7ED] text-[#B45309]',
                                    $item->status === 'Ditolak' => 'bg-red-50 text-red-600',
                                    default => 'bg-[#FFF7ED] text-[#B45309]',
                                };
                            @endphp
                            <tr class="transition hover:bg-[#F8FAFC]">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0B1E38] text-[10px] font-semibold text-white">
                                            {{ strtoupper(substr($item->siswa->nama, 0, 1)) }}
                                        </span>
                                        <div class="min-w-0">
                                            <p class="truncate font-medium text-[#0B1E38]">{{ $item->siswa->nama }}</p>
                                            <p class="truncate text-[10.5px] text-[#94A3B8]">{{ $item->siswa->kelas }} {{ $item->siswa->jurusan }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <p class="max-w-[220px] truncate font-medium text-[#0B1E38]">{{ $item->nama_prestasi }}</p>
                                    <p class="text-[10.5px] text-[#94A3B8]">{{ $item->penyelenggara }}</p>
                                </td>
                                <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $item->tingkat }}</td>
                                <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $item->tahunAjaran->tahun }}</td>
                                <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $item->tanggal->format('d M Y') }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[10.5px] font-semibold {{ $badge }}">{{ $item->label_status }}</span>
                                </td>
                                <td class="px-5 py-3.5 text-right">
                                    <a href="{{ route('kesiswaan.prestasi.show', $item) }}"
                                       class="inline-flex items-center gap-1.5 rounded-lg border border-[#E8EDF5] px-2.5 py-1.5 text-[11px] font-semibold text-[#2F6FED] transition hover:border-[#2F6FED]/30 hover:bg-[#EEF4FF]">
                                        Detail
                                        <x-icon name="chevron-right" :size="11" />
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <x-ui.empty-state icon="clipboard" title="Tidak ada pengajuan"
                                                      description="Belum ada prestasi yang cocok dengan filter saat ini." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div>{{ $prestasi->links() }}</div>
    </div>
</x-app-layout>
