<x-app-layout title="Tambah User">
    @php $roleAwal = old('role', 'siswa'); @endphp

    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-[minmax(0,1fr)_300px]" x-data="{ role: '{{ $roleAwal }}' }">

        <section class="card overflow-hidden">
            <div class="flex items-start gap-3 border-b border-[#E8EDF5] p-5">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                    <x-icon name="users" :size="18" />
                </span>
                <div class="min-w-0">
                    <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Informasi Akun</h2>
                    <p class="mt-0.5 text-[11.5px] text-[#94A3B8]">Tentukan role lalu isi data pengguna yang akan dibuat.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-5 p-5">
                @csrf

                {{-- ROLE --}}
                <div>
                    <span class="field-label">Role Pengguna</span>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach([['siswa', 'Siswa', 'graduation'], ['kesiswaan', 'Kesiswaan', 'clipboard'], ['admin', 'Admin', 'shield']] as [$value, $label, $icon])
                            <label class="cursor-pointer">
                                <input type="radio" name="role" value="{{ $value }}" x-model="role" class="peer sr-only" @checked($roleAwal === $value)>
                                <span class="flex flex-col items-center gap-1.5 rounded-xl border border-[#E8EDF5] bg-white px-2 py-3 text-[12px] font-semibold text-[#64748B] transition peer-checked:border-[#2F6FED] peer-checked:bg-[#EEF4FF] peer-checked:text-[#2F6FED] peer-focus-visible:ring-2 peer-focus-visible:ring-[#2F6FED]/30">
                                    <x-icon :name="$icon" :size="17" />
                                    {{ $label }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('role') <p class="field-error">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="field-label" for="nama">Nama Lengkap</label>
                        <input id="nama" type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama pengguna" class="input">
                        @error('nama') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="field-label" for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@eprestasi.test" class="input">
                        @error('email') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="field-label" for="password">Password</label>
                        <input id="password" type="text" name="password" placeholder="Default: password123" class="input">
                        @error('password') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- DATA SISWA --}}
                <div x-show="role === 'siswa'" x-cloak class="space-y-4 border-t border-[#E8EDF5] pt-5">
                    <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#2F6FED]">
                        <x-icon name="graduation" :size="13" /> Data Siswa
                    </p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="field-label" for="nis">NIS</label>
                            <input id="nis" type="text" name="nis" value="{{ old('nis') }}" class="input">
                            @error('nis') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="field-label" for="kelas">Kelas</label>
                            <input id="kelas" type="text" name="kelas" value="{{ old('kelas') }}" placeholder="Contoh: XII RPL 1" class="input">
                            @error('kelas') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label class="field-label" for="jurusan">Jurusan</label>
                            <input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan') }}" class="input">
                            @error('jurusan') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- DATA KESISWAAN --}}
                <div x-show="role === 'kesiswaan'" x-cloak class="space-y-4 border-t border-[#E8EDF5] pt-5">
                    <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#F97316]">
                        <x-icon name="clipboard" :size="13" /> Data Kesiswaan
                    </p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="field-label" for="nip">NIP</label>
                            <input id="nip" type="text" name="nip" value="{{ old('nip') }}" class="input">
                            @error('nip') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="field-label" for="jabatan">Jabatan</label>
                            <input id="jabatan" type="text" name="jabatan" value="{{ old('jabatan') }}" placeholder="Contoh: Wakasek Kesiswaan" class="input">
                            @error('jabatan') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 border-t border-[#E8EDF5] pt-5">
                    <button type="submit" class="btn-primary">
                        <x-icon name="check" :size="14" />
                        Buat Akun
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-ghost">Batal</a>
                </div>
            </form>
        </section>

        <aside class="space-y-4">
            <section class="card p-5">
                <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#F97316]">
                    <x-icon name="sparkles" :size="13" /> Panduan
                </p>
                <ul class="mt-3 space-y-2.5">
                    @foreach([
                        'Pilih role agar field yang tampil sesuai kebutuhan.',
                        'Password boleh dikosongkan — sistem memakai password123.',
                        'Siswa otomatis mendapat QR portofolio setelah profil lengkap.',
                    ] as $tips)
                        <li class="flex items-start gap-2 text-[11.5px] leading-relaxed text-[#64748B]">
                            <span class="mt-0.5 flex h-4 w-4 shrink-0 items-center justify-center rounded-full bg-[#ECFDF5] text-[#16A34A]">
                                <x-icon name="check" :size="9" />
                            </span>
                            {{ $tips }}
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="rounded-2xl border border-[#BFDBFE] bg-[#EFF6FF] p-5">
                <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1D4ED8]">
                    <x-icon name="upload" :size="13" /> Banyak akun?
                </p>
                <p class="mt-2 text-[11.5px] leading-relaxed text-[#3B82F6]">Gunakan import Excel untuk membuat banyak akun sekaligus.</p>
                <a href="{{ route('admin.users.import.form') }}" class="mt-3 inline-flex items-center gap-1 text-[11.5px] font-semibold text-[#1D4ED8] hover:text-[#1E40AF]">
                    Buka import
                    <x-icon name="chevron-right" :size="11" />
                </a>
            </section>
        </aside>
    </div>
</x-app-layout>
