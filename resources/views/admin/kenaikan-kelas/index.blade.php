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
            <section class="card overflow-hidden" x-data="kenaikanForm()">
                <form method="POST" action="{{ route('admin.kenaikan-kelas.proses') }}">
                    @csrf
                    <input type="hidden" name="kelas_asal" value="{{ $kelasAsal->id_kelas }}">

                    {{-- TAHUN AJARAN --}}
                    <div class="border-b border-[#E8EDF5] p-5">
                        <div class="mb-4">
                            <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#F97316]">
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#FFF7ED] text-[10px] font-bold">2</span>
                                Tahun Ajaran Tujuan
                            </p>
                        </div>

                        <div class="grid gap-3 lg:grid-cols-2">
                            <div>
                                <label class="field-label" for="tahun_pilihan">Pilih atau Buat Tahun Ajaran</label>
                                <select id="tahun_pilihan" name="tahun_pilihan" x-model="tahunPilihan" @change="onTahunChange()" required class="input">
                                    <option value="">— Pilih Tahun Ajaran —</option>
                                    @foreach($daftarTahunAjaran as $tahun)
                                        <option value="{{ $tahun->id_ajaran }}">{{ $tahun->tahun }} ({{ $tahun->status }})</option>
                                    @endforeach
                                    <option value="NEW">+ Buat Tahun Ajaran Baru</option>
                                </select>
                                @error('tahun_pilihan') <p class="field-error">{{ $message }}</p> @enderror
                            </div>

                            <div x-show="tahunPilihan === 'NEW'" x-transition>
                                <label class="field-label" for="tahun_baru">Format Tahun Ajaran Baru</label>
                                <input id="tahun_baru" type="text" name="tahun_baru" x-model="tahunBaru"
                                       placeholder="Contoh: 2027/2028" class="input">
                                @error('tahun_baru') <p class="field-error">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div x-show="tahunPilihan === 'NEW'" x-transition class="mt-4">
                            <label class="field-label">Status Tahun Ajaran Baru</label>
                            <div class="flex flex-wrap gap-3">
                                <label class="inline-flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="tahun_status" value="Aktif" x-model="tahunStatus" required
                                           class="rounded-full border-[#CBD5E1] text-[#2F6FED] focus:ring-[#2F6FED]/30">
                                    <span class="text-[13px] text-[#0B1E38]">Aktif (langsung digunakan)</span>
                                </label>
                                <label class="inline-flex cursor-pointer items-center gap-2">
                                    <input type="radio" name="tahun_status" value="Tidak Aktif" x-model="tahunStatus" required
                                           class="rounded-full border-[#CBD5E1] text-[#2F6FED] focus:ring-[#2F6FED]/30">
                                    <span class="text-[13px] text-[#0B1E38]">Tidak Aktif (aktifkan manual nanti)</span>
                                </label>
                            </div>
                            @error('tahun_status') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- SISWA & KELAS TUJUAN --}}
                    <div class="border-b border-[#E8EDF5] p-5">
                        <div class="mb-4">
                            <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#F97316]">
                                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#FFF7ED] text-[10px] font-bold">3</span>
                                Pilih Siswa & Kelas Tujuan
                            </p>
                            <h2 class="mt-1.5 font-display text-sm font-semibold text-[#0B1E38]">
                                Siswa di {{ $kelasAsal->nama_kelas }}
                                <span class="font-normal text-[#94A3B8]">({{ $siswaDiKelas->count() }} siswa)</span>
                            </h2>
                        </div>

                        <div class="mb-4">
                            <label class="field-label" for="kelas_tujuan_default">Set Kelas Tujuan Default (Opsional)</label>
                            <select id="kelas_tujuan_default" name="kelas_tujuan_default" x-model="kelasTujuanDefault" @change="setAllDropdowns()" class="input">
                                <option value="">— Tidak ada default, atur per siswa —</option>
                                @foreach($daftarKelas as $k)
                                    @if($k->id_kelas !== $kelasAsal->id_kelas)
                                        <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }} ({{ $k->jurusan }})</option>
                                    @endif
                                @endforeach
                            </select>
                            <p class="mt-1.5 text-[11px] text-[#64748B]">Jika dipilih, semua dropdown siswa akan terisi. Atur ulang per siswa kalau ada yang berbeda.</p>
                        </div>
                    </div>

                    @if($siswaDiKelas->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full min-w-[800px] text-sm">
                                <thead class="border-b border-[#E8EDF5] bg-[#F8FAFC] text-left">
                                    <tr>
                                        <th class="w-12 px-5 py-3">
                                            <input type="checkbox" x-ref="selectAllCheckbox" @change="toggleSelectAll()" aria-label="Pilih semua siswa"
                                                   class="rounded border-[#CBD5E1] text-[#2F6FED] focus:ring-[#2F6FED]/30">
                                        </th>
                                        <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Nama Siswa</th>
                                        <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">NIS</th>
                                        <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Jurusan Saat Ini</th>
                                        <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Kelas Tujuan</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#F1F5F9]">
                                    @foreach($siswaDiKelas as $siswa)
                                        <tr class="transition hover:bg-[#F8FAFC]">
                                            <td class="px-5 py-3.5">
                                                <input type="checkbox" name="siswa_ids[]" value="{{ $siswa->id_siswa }}"
                                                       x-ref="siswaCb{{ $siswa->id_siswa }}" @change="updateSelectAll()"
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
                                            <td class="px-5 py-3.5">
                                                <select name="kelas_tujuan_per_siswa[{{ $siswa->id_siswa }}]"
                                                        x-ref="kelasSiswa{{ $siswa->id_siswa }}"
                                                        class="input text-[13px]">
                                                    <option value="">— Pilih Kelas —</option>
                                                    @foreach($daftarKelas as $k)
                                                        @if($k->id_kelas !== $kelasAsal->id_kelas)
                                                            <option value="{{ $k->id_kelas }}">{{ $k->nama_kelas }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="border-t border-[#E8EDF5] p-5">
                            <button type="submit" class="btn-primary">
                                <x-icon name="arrow-up" :size="14" />
                                Proses Kenaikan
                            </button>
                        </div>
                    @else
                        <x-ui.empty-state icon="users" title="Tidak ada siswa aktif"
                                          description="Kelas ini belum memiliki siswa aktif yang bisa dipindahkan." />
                    @endif
                </form>
            </section>
        @endif
    </div>

    <script>
        function kenaikanForm() {
            return {
                tahunPilihan: '{{ old('tahun_pilihan') }}',
                tahunBaru: '{{ old('tahun_baru') }}',
                tahunStatus: 'Tidak Aktif',
                kelasTujuanDefault: '{{ old('kelas_tujuan_default') }}',

                onTahunChange() {
                    if (this.tahunPilihan !== 'NEW') {
                        this.tahunBaru = '';
                        this.tahunStatus = 'Tidak Aktif';
                    }
                },

                setAllDropdowns() {
                    if (this.kelasTujuanDefault) {
                        @foreach($siswaDiKelas as $siswa)
                            this.$refs.kelasSiswa{{ $siswa->id_siswa }}.value = this.kelasTujuanDefault;
                        @endforeach
                    }
                },

                toggleSelectAll() {
                    const isChecked = this.$refs.selectAllCheckbox.checked;
                    @foreach($siswaDiKelas as $siswa)
                        this.$refs.siswaCb{{ $siswa->id_siswa }}.checked = isChecked;
                    @endforeach
                },

                updateSelectAll() {
                    const allCheckboxes = document.querySelectorAll('.siswa-checkbox');
                    const checkedCount = document.querySelectorAll('.siswa-checkbox:checked').length;
                    this.$refs.selectAllCheckbox.checked = checkedCount === allCheckboxes.length;
                    this.$refs.selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount < allCheckboxes.length;
                }
            }
        }
    </script>
</x-app-layout>
