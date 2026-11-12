<x-app-layout title="Tandai Kelulusan">
    <div class="space-y-4">

        {{-- TOOLBAR --}}
        <section class="card p-4">
            <div class="flex flex-col gap-3 lg:flex-row lg:items-center lg:justify-between">
                <form method="GET" class="flex flex-wrap items-center gap-2">
                    <div class="relative w-full sm:w-52">
                        <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                            <x-icon name="search" :size="15" />
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa..."
                               class="w-full rounded-xl border-[#E2E8F0] py-2 pl-9 pr-3 text-[13px] text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                    </div>
                    <select name="kelas" class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="">Semua Kelas</option>
                        @foreach($daftarKelas as $kelas)
                            <option value="{{ $kelas }}" @selected(request('kelas') == $kelas)>{{ $kelas }}</option>
                        @endforeach
                    </select>
                    <select name="sort" class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        <option value="nama_az" @selected(request('sort', 'nama_az') === 'nama_az')>Nama A-Z</option>
                        <option value="nama_za" @selected(request('sort') === 'nama_za')>Nama Z-A</option>
                        <option value="kelas" @selected(request('sort') === 'kelas')>Urutkan per Kelas</option>
                    </select>
                    <button class="inline-flex items-center gap-1.5 rounded-xl bg-[#2F6FED] px-3.5 py-2 text-[13px] font-semibold text-white transition hover:bg-[#1B4FC4]">
                        <x-icon name="filter" :size="14" />
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'kelas']))
                        <a href="{{ route('admin.kelulusan.index') }}" class="text-[12px] font-medium text-[#94A3B8] transition hover:text-[#475569]">Reset</a>
                    @endif
                </form>

                <a href="{{ route('admin.kelulusan.alumni') }}"
                   class="inline-flex shrink-0 items-center gap-1.5 rounded-xl border border-[#E8EDF5] bg-white px-3.5 py-2 text-[12.5px] font-semibold text-[#2F6FED] transition hover:bg-[#EEF4FF]">
                    <x-icon name="graduation" :size="14" />
                    Lihat Data Alumni
                </a>
            </div>
        </section>

        <form method="POST" action="{{ route('admin.kelulusan.tandai-bulk') }}"
              x-data="{
                selected: [],
                allIds: [{{ $siswaAktif->pluck('id_siswa')->implode(',') }}],
                toggleAll(checked) { this.selected = checked ? [...this.allIds] : []; },
                toggleOne(id, checked) {
                    if (checked) { if (!this.selected.includes(id)) this.selected.push(id); }
                    else { this.selected = this.selected.filter(i => i !== id); }
                }
              }">
            @csrf
            <template x-for="id in selected" :key="id">
                <input type="hidden" name="siswa_ids[]" :value="id">
            </template>

            <section class="card overflow-hidden">
                {{-- BULK BAR --}}
                <div class="flex flex-col gap-3 border-b border-[#E8EDF5] p-4 sm:flex-row sm:items-center sm:justify-between">
                    <label class="flex cursor-pointer select-none items-center gap-2.5">
                        <input type="checkbox"
                               class="rounded border-[#CBD5E1] text-[#2F6FED] focus:ring-[#2F6FED]/30"
                               :checked="allIds.length > 0 && selected.length === allIds.length"
                               @change="toggleAll($event.target.checked)">
                        <span class="text-[12px] font-medium text-[#64748B]">
                            Pilih semua di halaman ini
                            <span class="text-[#94A3B8]">({{ $siswaAktif->count() }} siswa)</span>
                        </span>
                    </label>

                    <button type="submit"
                            :disabled="selected.length === 0"
                            :class="selected.length === 0 ? 'opacity-40 cursor-not-allowed' : 'hover:opacity-90'"
                            class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-[#16A34A] to-[#15803D] px-4 py-2.5 text-[13px] font-semibold text-white shadow-lg shadow-[#16A34A]/20 transition">
                        <x-icon name="check" :size="14" />
                        Tandai Lulus
                        <span class="rounded-full bg-white/20 px-1.5 text-[11px] font-bold" x-text="selected.length"></span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[680px] text-sm">
                        <thead class="border-b border-[#E8EDF5] bg-[#F8FAFC] text-left">
                            <tr>
                                <th class="w-12 px-5 py-3"></th>
                                <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Nama Siswa</th>
                                <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">NIS</th>
                                <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Kelas</th>
                                <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Jurusan</th>
                                <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F1F5F9]">
                            @forelse($siswaAktif as $siswa)
                                <tr class="transition hover:bg-[#F8FAFC]">
                                    <td class="px-5 py-3">
                                        <input type="checkbox"
                                               class="rounded border-[#CBD5E1] text-[#2F6FED] focus:ring-[#2F6FED]/30"
                                               :checked="selected.includes({{ $siswa->id_siswa }})"
                                               @change="toggleOne({{ $siswa->id_siswa }}, $event.target.checked)">
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-2.5">
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#0B1E38] text-[10px] font-semibold text-white">
                                                {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                            </span>
                                            <span class="font-medium text-[#0B1E38]">{{ $siswa->nama }}</span>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-[13px] text-[#64748B]">{{ $siswa->nis }}</td>
                                    <td class="px-5 py-3 text-[13px] text-[#64748B]">{{ $siswa->kelas }}</td>
                                    <td class="px-5 py-3 text-[13px] text-[#64748B]">{{ $siswa->jurusan }}</td>
                                    <td class="px-5 py-3">
                                        <form method="POST" action="{{ route('admin.kelulusan.keluarkan', $siswa) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-[12px] font-medium text-rose-600 hover:text-rose-700">
                                                Keluarkan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <x-ui.empty-state icon="graduation" title="Tidak ada siswa aktif" description="Tidak ada siswa yang cocok dengan filter saat ini." />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </form>

        <div>{{ $siswaAktif->links() }}</div>
    </div>
</x-app-layout>
