<x-app-layout title="Kelola Kelas">
    <div class="grid grid-cols-1 items-start gap-4 xl:grid-cols-[minmax(0,1fr)_320px]"
         x-data="{
            editOpen: false,
            editNama: '',
            editTingkat: '10',
            editJurusan: '',
            editAction: ''
         }">

        <div class="min-w-0 space-y-4">
            <section class="card overflow-hidden">
                {{-- TOOLBAR --}}
                <div class="flex flex-col gap-3 border-b border-[#E8EDF5] p-4 lg:flex-row lg:items-center lg:justify-between">
                    <form method="GET" class="flex flex-wrap items-center gap-2">
                        <div class="relative w-full sm:w-56">
                            <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                                <x-icon name="search" :size="15" />
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kelas..."
                                   class="w-full rounded-xl border-[#E2E8F0] py-2 pl-9 pr-3 text-[13px] text-[#0B1E38] placeholder:text-[#94A3B8] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        </div>
                        <select name="tingkat" class="rounded-xl border-[#E2E8F0] py-2 pl-3 pr-8 text-[13px] text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                            <option value="">Semua Tingkat</option>
                            @foreach([10, 11, 12] as $t)
                                <option value="{{ $t }}" @selected((string) request('tingkat') === (string) $t)>Kelas {{ $t }}</option>
                            @endforeach
                        </select>
                        <button class="inline-flex items-center gap-1.5 rounded-xl bg-[#2F6FED] px-3.5 py-2 text-[13px] font-semibold text-white transition hover:bg-[#1B4FC4]">
                            <x-icon name="filter" :size="14" />
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'tingkat']))
                            <a href="{{ route('admin.kelas.index') }}" class="text-[12px] font-medium text-[#94A3B8] transition hover:text-[#475569]">Reset</a>
                        @endif
                    </form>

                    <span class="shrink-0 rounded-full bg-[#F5F7FB] px-2.5 py-1 text-[10.5px] font-semibold text-[#64748B]">{{ $daftarKelas->total() }} kelas</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[720px] text-sm">
                        <thead class="border-b border-[#E8EDF5] bg-[#F8FAFC] text-left">
                            <tr>
                                <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Nama Kelas</th>
                                <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Tingkat</th>
                                <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Jurusan</th>
                                <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Siswa</th>
                                <th class="px-5 py-3 text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Status</th>
                                <th class="px-5 py-3 text-right text-[10.5px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#F1F5F9]">
                            @forelse($daftarKelas as $kelas)
                                <tr class="transition hover:bg-[#F8FAFC]">
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center gap-2.5">
                                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#EEF4FF] text-[#2F6FED]">
                                                <x-icon name="school" :size="14" />
                                            </span>
                                            <a href="{{ route('admin.kelas.show', $kelas) }}" class="font-medium text-[#0B1E38] hover:text-[#2F6FED] transition">{{ $kelas->nama_kelas }}</a>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3.5 text-[13px] text-[#64748B]">Kelas {{ $kelas->tingkat }}</td>
                                    <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $kelas->jurusan }}</td>
                                    <td class="px-5 py-3.5 text-[13px] text-[#64748B]">{{ $kelas->siswa_count }} siswa</td>
                                    <td class="px-5 py-3.5">
                                        @if($kelas->status === 'Aktif')
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#ECFDF5] px-2.5 py-1 text-[10.5px] font-semibold text-[#15803D]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#16A34A]"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 rounded-full bg-[#F1F5F9] px-2.5 py-1 text-[10.5px] font-semibold text-[#64748B]">
                                                <span class="h-1.5 w-1.5 rounded-full bg-[#94A3B8]"></span> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <div class="flex items-center justify-end gap-1.5">
                                            <a href="{{ route('admin.kelas.show', $kelas) }}"
                                               title="Lihat siswa"
                                               class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] text-[#64748B] transition hover:border-[#2F6FED]/30 hover:bg-[#EEF4FF] hover:text-[#2F6FED]">
                                                <x-icon name="users" :size="14" />
                                            </a>
                                            <button type="button"
                                                    @click="editOpen = true; editNama = '{{ $kelas->nama_kelas }}'; editTingkat = '{{ $kelas->tingkat }}'; editJurusan = '{{ $kelas->jurusan }}'; editAction = '{{ route('admin.kelas.update', $kelas) }}'"
                                                    title="Edit kelas"
                                                    class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] text-[#64748B] transition hover:border-[#2F6FED]/30 hover:bg-[#EEF4FF] hover:text-[#2F6FED]">
                                                <x-icon name="edit" :size="14" />
                                            </button>
                                            <form method="POST" action="{{ route('admin.kelas.toggle', $kelas) }}">
                                                @csrf @method('PUT')
                                                <button type="submit" title="{{ $kelas->status === 'Aktif' ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                        class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] text-[#64748B] transition hover:border-[#F59E0B]/40 hover:bg-[#FFFBEB] hover:text-[#B45309]">
                                                    <x-icon :name="$kelas->status === 'Aktif' ? 'x' : 'check'" :size="14" />
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.kelas.destroy', $kelas) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" title="Hapus kelas"
                                                        class="flex h-8 w-8 items-center justify-center rounded-lg border border-[#E8EDF5] text-[#94A3B8] transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                                                    <x-icon name="trash" :size="14" />
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <x-ui.empty-state icon="school" title="Belum ada kelas"
                                                          description="Tambahkan kelas baru lewat form di samping." />
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <div>{{ $daftarKelas->links() }}</div>
        </div>

        {{-- FORM TAMBAH --}}
        <aside class="card overflow-hidden">
            <div class="flex items-start gap-3 border-b border-[#E8EDF5] p-5">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#FFF7ED] text-[#F97316]">
                    <x-icon name="plus" :size="18" />
                </span>
                <div class="min-w-0">
                    <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Tambah Kelas</h2>
                    <p class="mt-0.5 text-[11.5px] text-[#94A3B8]">Sesuaikan penamaan dengan data sekolah.</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.kelas.store') }}" class="space-y-4 p-5">
                @csrf
                <div>
                    <label class="field-label" for="nama_kelas">Nama Kelas</label>
                    <input id="nama_kelas" type="text" name="nama_kelas" value="{{ old('nama_kelas') }}" placeholder="Contoh: XI RPL 1" class="input">
                    @error('nama_kelas') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="field-label" for="tingkat">Tingkat</label>
                    <select id="tingkat" name="tingkat" class="input">
                        @foreach([10, 11, 12] as $t)
                            <option value="{{ $t }}" @selected((string) old('tingkat') === (string) $t)>Kelas {{ $t }}</option>
                        @endforeach
                    </select>
                    @error('tingkat') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="field-label" for="jurusan">Jurusan (kode)</label>
                    <input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan') }}" placeholder="Contoh: RPL, AKL, DKV" class="input">
                    @error('jurusan') <p class="field-error">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="btn-primary w-full">
                    <x-icon name="plus" :size="14" />
                    Tambah Kelas
                </button>
            </form>
        </aside>

        {{-- MODAL EDIT --}}
        <div x-show="editOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-[#0B1E38]/[0.45] px-4 backdrop-blur-[2px]" style="display: none;">
            <div @click.outside="editOpen = false" class="w-full max-w-sm rounded-2xl bg-white p-5 shadow-xl">
                <div class="flex items-center gap-2.5">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                        <x-icon name="edit" :size="16" />
                    </span>
                    <h3 class="font-display text-sm font-semibold text-[#0B1E38]">Edit Kelas</h3>
                </div>
                <form :action="editAction" method="POST" class="mt-4 space-y-4">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="field-label">Nama Kelas</label>
                        <input type="text" name="nama_kelas" x-model="editNama" class="input">
                    </div>
                    <div>
                        <label class="field-label">Tingkat</label>
                        <select name="tingkat" x-model="editTingkat" class="input">
                            <option value="10">Kelas 10</option>
                            <option value="11">Kelas 11</option>
                            <option value="12">Kelas 12</option>
                        </select>
                    </div>
                    <div>
                        <label class="field-label">Jurusan (kode)</label>
                        <input type="text" name="jurusan" x-model="editJurusan" class="input">
                    </div>
                    <div class="flex gap-2 pt-1">
                        <button type="button" @click="editOpen = false" class="btn-ghost flex-1">Batal</button>
                        <button type="submit" class="btn-primary flex-1">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
