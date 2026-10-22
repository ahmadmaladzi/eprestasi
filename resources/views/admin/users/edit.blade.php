<x-app-layout title="Edit User">
    @php
        $roleBadge = match($user->role) {
            'admin' => 'bg-[#F1F5F9] text-[#0B1E38]',
            'kesiswaan' => 'bg-[#FFF7ED] text-[#C2410C]',
            default => 'bg-[#EEF4FF] text-[#1B4FC4]',
        };
    @endphp

    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-[minmax(0,1fr)_300px]">

        <section class="card overflow-hidden">
            <div class="flex flex-wrap items-center gap-3 border-b border-[#E8EDF5] p-5">
                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] text-sm font-semibold text-white">
                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                </span>
                <div class="min-w-0 flex-1">
                    <h2 class="truncate font-display text-sm font-semibold text-[#0B1E38]">{{ $user->nama }}</h2>
                    <p class="mt-0.5 truncate text-[11.5px] text-[#94A3B8]">{{ $user->email }}</p>
                </div>
                <span class="inline-flex shrink-0 items-center rounded-full px-2.5 py-1 text-[10.5px] font-semibold capitalize {{ $roleBadge }}">{{ $user->role }}</span>
            </div>

            <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-5 p-5">
                @csrf
                @method('PUT')
                <input type="hidden" name="role" value="{{ $user->role }}">

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="field-label" for="nama">Nama Lengkap</label>
                        <input id="nama" type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="input">
                        @error('nama') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="field-label" for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" class="input">
                        @error('email') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="field-label" for="password">Password Baru</label>
                        <input id="password" type="text" name="password" placeholder="Kosongkan jika tidak diganti" class="input">
                        @error('password') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                @if($user->role === 'siswa')
                    <div class="space-y-4 border-t border-[#E8EDF5] pt-5">
                        <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#2F6FED]">
                            <x-icon name="graduation" :size="13" /> Data Siswa
                        </p>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="field-label" for="nis">NIS</label>
                                <input id="nis" type="text" name="nis" value="{{ old('nis', $siswa->nis ?? '') }}" class="input">
                                @error('nis') <p class="field-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="field-label" for="kelas">Kelas</label>
                                <input id="kelas" type="text" name="kelas" value="{{ old('kelas', $siswa->kelas ?? '') }}" class="input">
                                @error('kelas') <p class="field-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="field-label" for="jurusan">Jurusan</label>
                                <input id="jurusan" type="text" name="jurusan" value="{{ old('jurusan', $siswa->jurusan ?? '') }}" class="input">
                                @error('jurusan') <p class="field-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="field-label" for="no_hp">No. HP</label>
                                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp ?? '') }}" class="input">
                            </div>
                        </div>
                    </div>
                @elseif($user->role === 'kesiswaan')
                    <div class="space-y-4 border-t border-[#E8EDF5] pt-5">
                        <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#F97316]">
                            <x-icon name="clipboard" :size="13" /> Data Kesiswaan
                        </p>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label class="field-label" for="nip">NIP</label>
                                <input id="nip" type="text" name="nip" value="{{ old('nip', $kesiswaan->nip ?? '') }}" class="input">
                                @error('nip') <p class="field-error">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="field-label" for="jabatan">Jabatan</label>
                                <input id="jabatan" type="text" name="jabatan" value="{{ old('jabatan', $kesiswaan->jabatan ?? '') }}" class="input">
                                @error('jabatan') <p class="field-error">{{ $message }}</p> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="field-label" for="no_hp">No. HP</label>
                                <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $kesiswaan->no_hp ?? '') }}" class="input">
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-2 border-t border-[#E8EDF5] pt-5">
                    <button type="submit" class="btn-primary">
                        <x-icon name="check" :size="14" />
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-ghost">Batal</a>
                </div>
            </form>
        </section>

        <aside class="space-y-4">
            <section class="card p-5">
                <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Informasi Akun</p>
                <dl class="mt-3 space-y-3">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-[11.5px] text-[#94A3B8]">Role</dt>
                        <dd class="text-[11.5px] font-semibold capitalize text-[#0B1E38]">{{ $user->role }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-[11.5px] text-[#94A3B8]">Dibuat</dt>
                        <dd class="text-[11.5px] font-semibold text-[#0B1E38]">{{ $user->created_at?->format('d M Y') ?? '—' }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-[11.5px] text-[#94A3B8]">Terakhir diubah</dt>
                        <dd class="text-[11.5px] font-semibold text-[#0B1E38]">{{ $user->updated_at?->locale('id')->diffForHumans() ?? '—' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-2xl border border-[#FDE68A] bg-[#FFFBEB] p-5">
                <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#B45309]">
                    <x-icon name="lock" :size="13" /> Keamanan
                </p>
                <p class="mt-2 text-[11.5px] leading-relaxed text-[#B45309]/80">Hanya isi password bila ingin menggantinya. Pengguna akan memakai password baru pada login berikutnya.</p>
            </section>
        </aside>
    </div>
</x-app-layout>
