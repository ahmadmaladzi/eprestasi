<x-app-layout title="Kenaikan Kelas">
    <div class="space-y-4">

        {{-- LANGKAH 1 --}}
        <section class="card overflow-hidden">
            <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-end sm:justify-between">
                <div class="min-w-0">
                    <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#2F6FED]">
                        <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#EEF4FF] text-[10px] font-bold">1</span>
                        Langkah Pertama
                    </p>
                    <h2 class="mt-1.5 font-display text-sm font-semibold text-[#0B1E38]">Pilih Kelas Asal</h2>
                    <p class="mt-0.5 text-[11.5px] text-[#94A3B8]">Pilih kelas yang mau dinaikkan atau dipindahkan siswanya.</p>
                </div>

                <form method="GET" class="w-full sm:w-72">
                    <label class="field-label" for="kelas_asal">Kelas Asal</label>
                    <select id="kelas_asal" name="kelas_asal" onchange="this.form.submit()" class="input">
                        <option value="">— Pilih Kelas Asal —</option>
                        @foreach($daftarKelas as $k)
                            <option value="{{ $k->id_kelas }}" @selected($kelasAsal && $kelasAsal->id_kelas === $k->id_kelas)>
                                {{ $k->nama_kelas }} ({{ $k->jurusan }})
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        </section>

        @if($kelasAsal)
            <section class="card overflow-hidden" x-data="{ selectAll: false }">
                <form method="POST" action="{{ route('admin.kenaikan-kelas.proses') }}">
                    @csrf
                    <input type="hidden" name="kelas_asal" value="{{ $kelasAsal->id_kelas }}">

                    <div class="flex flex-col gap-3 border-b border-[#E8EDF5] p-5 lg:flex-row lg:items-end lg:justify-between">
                        <div class="min-w-0">
                            <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#F97316]">
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#FFF7ED] text-[10px] font-bold">2</span>
                                Pilih Tujuan
                            </p>
                            <h2 class="mt-1.5 font-display text-sm font-semibold text-[#0B1E38]">
                                Siswa di {{ $kelasAsal->nama_kelas }}
                                <span class="font-normal text-[#94A3B8]">({{ $siswaDiKelas->count() }} siswa)</span>
                            </h2>
                        </div>

                        <div class="flex flex-wrap items-end gap-2">
                            <div class="w-full sm:w-56">
                                <label class="field-label" for="kelas_tujuan">Kelas Tujuan</label>
                                <select id="kelas_tujuan" name="kelas_tujuan" required class="input">
                                    <option value="">— Pilih Kelas Tujuan —</option>
                                    @foreach($daftarKelas as $k)
                                        @if($k->id_kelas !== $kelasAsal->id_kelas)
                                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} ({{ $k->jurusan }})</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn-primary"
                                    onclick="return confirm('Pindahkan siswa yang dicentang ke kelas tujuan?')">
                                <x-icon name="arrow-up" :size="14" />
                                Pindahkan
                            </button>
                        </div>
                    </div>

                    @if($siswaDiKelas->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[640px] text-sm">
                                <thead class="border-b border-[#E8EDF5] bg-[#F8FAFC] text-left">
                                    <tr>
                                        <th class="w-12 px-5 py-3">
                                            <input type="checkbox" x-model="selectAll" aria-label="Pilih semua siswa"
                                                   @change="document.querySelectorAll('.siswa-checkbox').forEach(cb => cb.checked = selectAll)"
                                                   class="rounded border-[#CBD5E1] text-[#2F6FED] focus:ring-[#2F6FED]/30">
                                        </th>
                                        <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Nama Siswa</th>
                                        <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">NIS</th>
                                        <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Jurusan Saat Ini</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#F1F5F9]">
                                    @foreach($siswaDiKelas as $siswa)
                                        <tr class="transition hover:bg-[#F8FAFC]">
                                            <td class="px-5 py-3.5">
                                                <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id_siswa }}"
                                                       class="siswa-checkbox rounded border-[#CBD5E1] text-[#2F6FED] focus:ring-[#2F6FED]/30">
                                            </td>
                                            <td class="px-5 py-3.5">
                                                <div class="flex items-center gap-2.5">
                                                    <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#0B1E38] text-[9px] font-semibold text-white">
                                                        {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                                    </span>
                                                    <span class="font-medium text-[#0B1E38]">{{ $siswa->nama }}</span>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $siswa->nis }}</td>
                                            <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $siswa->jurusan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <x-ui.empty-state icon="users" title="Tidak ada siswa aktif"
                                          description="Kelas ini belum memiliki siswa aktif yang bisa dipindahkan." />
                    @endif
                </form>
            </section>
        @endif
    </div>
</x-app-layout>
