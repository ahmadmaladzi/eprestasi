<x-app-layout title="Import Akun dari Excel">
    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-[minmax(0,1fr)_320px]">

        <section class="card overflow-hidden">
            <div class="flex items-start gap-3 border-b border-[#E8EDF5] p-5">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#ECFDF5] text-[#16A34A]">
                    <x-icon name="upload" :size="18" />
                </span>
                <div class="min-w-0">
                    <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Import Akun Massal</h2>
                    <p class="mt-0.5 text-[11.5px] text-[#94A3B8]">Upload file Excel/CSV berisi banyak akun sekaligus.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.import') }}" enctype="multipart/form-data" class="space-y-5 p-5">
                @csrf

                <div>
                    <label class="field-label" for="file">File Excel / CSV</label>
                    <input id="file" type="file" name="file" required accept=".xlsx,.xls,.csv"
                           class="block w-full cursor-pointer rounded-xl border border-dashed border-[#CBD5E1] bg-[#F8FAFC] px-4 py-3 text-[12.5px] text-[#64748B] transition file:mr-3 file:rounded-lg file:border-0 file:bg-[#EEF4FF] file:px-3 file:py-1.5 file:text-[11.5px] file:font-semibold file:text-[#2F6FED] hover:border-[#2F6FED]/40 hover:file:bg-[#E0EAFF]">
                    <p class="mt-1.5 text-[10.5px] text-[#94A3B8]">Format .xlsx, .xls, atau .csv — maksimal 5MB.</p>
                    @error('file') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                @if(session('gagalImport') && count(session('gagalImport')) > 0)
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4">
                        <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.06em] text-red-700">
                            <x-icon name="x" :size="13" /> Baris yang gagal diimpor
                        </p>
                        <ul class="mt-2 space-y-1">
                            @foreach(session('gagalImport') as $g)
                                <li class="text-[11.5px] text-red-600">Baris {{ $g['baris'] }}: {{ $g['pesan'] }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-2 border-t border-[#E8EDF5] pt-5">
                    <button type="submit" class="btn-primary">
                        <x-icon name="upload" :size="14" />
                        Import Sekarang
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-ghost">Batal</a>
                </div>
            </form>
        </section>

        <aside class="space-y-4">
            <section class="card p-5">
                <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#2F6FED]">
                    <x-icon name="download" :size="13" /> Template
                </p>
                <p class="mt-2 text-[11.5px] leading-relaxed text-[#64748B]">Gunakan template resmi agar urutan kolom sesuai dan proses import berjalan lancar.</p>
                <a href="{{ asset('templates/template-import-akun.xlsx') }}" download class="btn-ghost mt-3 w-full">
                    <x-icon name="download" :size="14" class="text-[#2F6FED]" />
                    Download Template
                </a>
            </section>

            <section class="card p-5">
                <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Kolom Wajib</p>
                <ul class="mt-3 space-y-2">
                    @foreach([
                        ['nama', 'Nama lengkap pengguna'],
                        ['email', 'Email unik untuk login'],
                        ['role', 'siswa atau kesiswaan'],
                    ] as [$kolom, $ket])
                        <li class="flex items-start gap-2">
                            <code class="mt-0.5 shrink-0 rounded-md bg-[#F5F7FB] px-1.5 py-0.5 text-[10.5px] font-semibold text-[#2F6FED]">{{ $kolom }}</code>
                            <span class="text-[11.5px] leading-relaxed text-[#64748B]">{{ $ket }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="mt-4 space-y-1.5 border-t border-[#E8EDF5] pt-3 text-[11px] text-[#94A3B8]">
                    <p><strong class="text-[#64748B]">Siswa:</strong> nis, kelas, jurusan wajib.</p>
                    <p><strong class="text-[#64748B]">Kesiswaan:</strong> nip wajib.</p>
                    <p><strong class="text-[#64748B]">Password:</strong> opsional (default password123).</p>
                </div>
            </section>
        </aside>
    </div>
</x-app-layout>
