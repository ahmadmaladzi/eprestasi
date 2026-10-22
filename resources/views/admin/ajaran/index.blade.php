<x-app-layout title="Tahun Ajaran">
    <div class="space-y-4">

        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
            <x-ui.stat-card label="Total Tahun Ajaran" :value="$totalAjaran" icon="calendar" hint="terdata di sistem" tone="bg-[#EEF4FF] text-[#2F6FED]" />
            <x-ui.stat-card label="Sedang Aktif" :value="$totalAktif" icon="check" hint="dipakai saat ini" tone="bg-[#ECFDF5] text-[#16A34A]" />
            <x-ui.stat-card label="Total Prestasi" :value="$totalPrestasiKeseluruhan" icon="trophy" hint="semua tahun ajaran" tone="bg-[#FFF7ED] text-[#F97316]" />
        </div>

        <div class="grid grid-cols-1 items-start gap-4 xl:grid-cols-[minmax(0,1fr)_320px]">
            <div class="min-w-0 space-y-4">
                <section class="card overflow-hidden">
                    <div class="flex flex-col gap-3 border-b border-[#E8EDF5] p-4 lg:flex-row lg:items-center lg:justify-between">
                        <form method="GET" class="flex flex-wrap items-center gap-2">
                            <div class="relative w-full sm:w-56">
                                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                                    <x-icon name="search" :size="15" />
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari tahun ajaran..."
                                       class="w-full rounded-xl border-[#E2E8F0] py-2 pl-9 pr-3 text-[13px] text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                            </div>
                            <select name="status" class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                                <option value="">Semua Status</option>
                                <option value="Aktif" @selected(request('status') === 'Aktif')>Aktif</option>
                                <option value="Tidak Aktif" @selected(request('status') === 'Tidak Aktif')>Tidak Aktif</option>
                            </select>
                            <button class="inline-flex items-center gap-1.5 rounded-xl bg-[#2F6FED] px-3.5 py-2 text-[13px] font-semibold text-white transition hover:bg-[#1B4FC4]">
                                <x-icon name="filter" :size="14" />
                                Filter
                            </button>
                            @if(request()->hasAny(['search', 'status']))
                                <a href="{{ route('admin.ajaran.index') }}" class="text-[12px] font-medium text-[#94A3B8] transition hover:text-[#475569]">Reset</a>
                            @endif
                        </form>

                        <span class="shrink-0 rounded-full bg-[#F5F7FB] px-2.5 py-1 text-[10.5px] font-semibold text-[#64748B]">{{ $daftarAjaran->total() }} tahun</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[620px] text-sm">
                            <thead class="border-b border-[#E8EDF5] bg-[#F8FAFC] text-left">
                                <tr>
                                    <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Tahun Ajaran</th>
                                    <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Status</th>
                                    <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Total Prestasi</th>
                                    <th class="px-5 py-3 text-right text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#F1F5F9]">
                                @forelse($daftarAjaran as $ajaran)
                                    <tr class="transition hover:bg-[#F8FAFC]">
                                        <td class="px-5 py-3.5">
                                            <div class="flex items-center gap-2.5">
                                                <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#EEF4FF] text-[#2F6FED]">
                                                    <x-icon name="calendar" :size="14" />
                                                </span>
                                                <span class="font-medium text-[#0B1E38]">{{ $ajaran->tahun }}</span>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3.5">
                                            @if($ajaran->status === 'Aktif')
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#ECFDF5] px-2.5 py-1 text-[10.5px] font-semibold text-[#15803D]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#16A34A]"></span> Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F1F5F9] px-2.5 py-1 text-[10.5px] font-semibold text-[#64748B]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#94A3B8]"></span> Nonaktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $ajaran->prestasi_count ?? $ajaran->prestasi()->count() }} prestasi</td>
                                        <td class="px-5 py-3.5 text-right">
                                            @if($ajaran->status !== 'Aktif')
                                                <form method="POST" action="{{ route('admin.ajaran.update', $ajaran) }}">
                                                    @csrf @method('PUT')
                                                    <input type="hidden" name="status" value="Aktif">
                                                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-[#E8EDF5] px-2.5 py-1.5 text-[11px] font-semibold text-[#2F6FED] transition hover:border-[#2F6FED]/30 hover:bg-[#EEF4FF]">
                                                        <x-icon name="check" :size="12" />
                                                        Jadikan Aktif
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-[11.5px] text-[#CBD5E1]">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <x-ui.empty-state icon="calendar" title="Tidak ada tahun ajaran"
                                                              description="Ubah kata kunci pencarian atau tambahkan tahun ajaran baru." />
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <div>{{ $daftarAjaran->links() }}</div>
            </div>

            <aside class="card overflow-hidden">
                <div class="flex items-start gap-3 border-b border-[#E8EDF5] p-5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                        <x-icon name="plus" :size="18" />
                    </span>
                    <div class="min-w-0">
                        <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Tambah Tahun Ajaran</h2>
                        <p class="mt-0.5 text-[11.5px] text-[#94A3B8]">Tahun baru otomatis nonaktif.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.ajaran.store') }}" class="space-y-4 p-5">
                    @csrf
                    <div>
                        <label class="field-label" for="tahun">Format Tahun</label>
                        <input id="tahun" type="text" name="tahun" value="{{ old('tahun') }}" placeholder="Contoh: 2026/2027" class="input">
                        @error('tahun') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <p class="rounded-xl bg-[#FFFBEB] px-3 py-2.5 text-[10.5px] leading-relaxed text-[#B45309]">
                        Aktifkan manual lewat tabel setelah tahun ajaran siap dipakai.
                    </p>
                    <button type="submit" class="btn-primary w-full">
                        <x-icon name="plus" :size="14" />
                        Tambah
                    </button>
                </form>
            </aside>
        </div>
    </div>
</x-app-layout>
