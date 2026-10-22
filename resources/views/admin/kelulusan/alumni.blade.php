<x-app-layout title="Data Alumni">
    <div class="space-y-4">

        <section class="card p-4">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <form method="GET" class="flex flex-wrap items-center gap-2">
                    <div class="relative w-full sm:w-48">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                            <x-icon name="search" :size="15" />
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama alumni..."
                               class="w-full rounded-xl border-[#E2E8F0] py-2 pl-9 pr-3 text-[13px] text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                    </div>
                    <select name="tahun" class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Semua Tahun</option>
                        @foreach($daftarTahun as $tahun)
                            <option value="{{ $tahun }}" @selected(request('tahun') == $tahun)>{{ $tahun }}</option>
                        @endforeach
                    </select>
                    <select name="kelas" class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Semua Kelas</option>
                        @foreach($daftarKelas as $kelas)
                            <option value="{{ $kelas }}" @selected(request('kelas') == $kelas)>{{ $kelas }}</option>
                        @endforeach
                    </select>
                    <select name="sort" class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Lulus Terbaru</option>
                        <option value="terlama" @selected(request('sort') === 'terlama')>Lulus Terlama</option>
                        <option value="nama_az" @selected(request('sort') === 'nama_az')>Nama A-Z</option>
                        <option value="nama_za" @selected(request('sort') === 'nama_za')>Nama Z-A</option>
                    </select>
                    <button class="inline-flex items-center gap-1.5 rounded-xl bg-[#2F6FED] px-3.5 py-2 text-[13px] font-semibold text-white transition hover:bg-[#1B4FC4]">
                        <x-icon name="filter" :size="14" />
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'tahun', 'kelas']))
                        <a href="{{ route('admin.kelulusan.alumni') }}" class="text-[12px] font-medium text-[#94A3B8] transition hover:text-[#475569]">Reset</a>
                    @endif
                </form>

                <a href="{{ route('admin.kelulusan.index') }}"
                   class="inline-flex shrink-0 items-center gap-1.5 rounded-xl border border-[#E8EDF5] bg-white px-3.5 py-2 text-[12.5px] font-semibold text-[#475569] transition hover:bg-[#F8FAFC]">
                    <x-icon name="clipboard" :size="14" class="text-[#2F6FED]" />
                    Tandai Kelulusan
                </a>
            </div>
        </section>

        <section class="card overflow-hidden">
            <div class="flex items-center justify-between gap-3 px-5 py-3.5">
                <div>
                    <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Daftar Alumni</h2>
                    <p class="mt-0.5 text-[11px] text-[#94A3B8]">Siswa yang sudah ditandai lulus.</p>
                </div>
                <span class="shrink-0 rounded-full bg-[#FFF7ED] px-2.5 py-1 text-[10.5px] font-semibold text-[#C2410C]">{{ $alumni->total() }} alumni</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[760px] text-sm">
                    <thead class="border-y border-[#E8EDF5] bg-[#F8FAFC] text-left">
                        <tr>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Nama Alumni</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">NIS</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Kelas Terakhir</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Jurusan</th>
                            <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Tanggal Lulus</th>
                            <th class="px-5 py-3 text-right text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F1F5F9]">
                        @forelse($alumni as $siswa)
                            <tr class="transition hover:bg-[#F8FAFC]">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#FFF7ED] text-[10px] font-semibold text-[#C2410C]">
                                            {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                        </span>
                                        <span class="font-medium text-[#0B1E38]">{{ $siswa->nama }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $siswa->nis }}</td>
                                <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $siswa->kelas }}</td>
                                <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $siswa->jurusan }}</td>
                                <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $siswa->tanggal_lulus?->format('d M Y') }}</td>
                                <td class="px-5 py-3.5 text-right">
                                    <form method="POST" action="{{ route('admin.kelulusan.batalkan', $siswa) }}">
                                        @csrf @method('PUT')
                                        <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-[#E8EDF5] px-2.5 py-1.5 text-[11px] font-semibold text-red-600 transition hover:border-red-200 hover:bg-red-50">
                                            <x-icon name="x" :size="12" />
                                            Batalkan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    <x-ui.empty-state icon="graduation" title="Belum ada alumni"
                                                      description="Alumni akan muncul setelah siswa ditandai lulus." />
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <div>{{ $alumni->links() }}</div>
    </div>
</x-app-layout>
