<x-app-layout title="Profil Saya">
    <div class="grid grid-cols-1 items-start gap-4 lg:grid-cols-[minmax(0,1fr)_320px]">

        <section class="card overflow-hidden">
            {{-- BANNER --}}
            <div class="relative overflow-hidden border-b border-[#E8EDF5] bg-gradient-to-r from-[#EEF4FF] via-white to-[#FFF7ED] px-5 py-6 sm:px-7">
                <div class="pointer-events-none absolute -right-8 -top-14 h-40 w-40 rounded-full bg-[#2F6FED]/10 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-16 left-1/3 h-36 w-36 rounded-full bg-[#F97316]/10 blur-2xl"></div>

                <div class="relative flex flex-wrap items-center gap-4">
                    <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] font-display text-xl font-bold text-white shadow-lg shadow-[#2F6FED]/25">
                        {{ strtoupper(substr($kesiswaan->nama, 0, 1)) }}
                    </span>
                    <div class="min-w-0 flex-1">
                        <h2 class="truncate font-display text-lg font-semibold text-[#0B1E38]">{{ $kesiswaan->nama }}</h2>
                        <p class="mt-0.5 truncate text-[12px] text-[#64748B]">
                            {{ $kesiswaan->jabatan ?: 'Kesiswaan' }}
                            <span class="text-[#CBD5E1]">&middot;</span>
                            NIP {{ $kesiswaan->nip ?: '—' }}
                        </p>
                        <span class="mt-2 inline-flex items-center gap-1.5 rounded-full bg-white px-2.5 py-1 text-[10.5px] font-semibold text-[#2F6FED] ring-1 ring-[#E8EDF5]">
                            <x-icon name="shield" :size="11" />
                            Akun Kesiswaan
                        </span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('kesiswaan.profil.update') }}" class="space-y-5 p-5 sm:p-7">
                @csrf
                @method('PUT')

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="field-label" for="nama">Nama Lengkap</label>
                        <input id="nama" type="text" name="nama" value="{{ old('nama', $kesiswaan->nama) }}" class="input">
                        @error('nama') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="field-label" for="jabatan">Jabatan</label>
                        <input id="jabatan" type="text" name="jabatan" value="{{ old('jabatan', $kesiswaan->jabatan) }}" class="input">
                        @error('jabatan') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="field-label" for="no_hp">No. HP</label>
                        <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $kesiswaan->no_hp) }}" placeholder="08xxxxxxxxxx" class="input">
                        @error('no_hp') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="field-label" for="email">Gmail Aktif <span class="text-red-500">*</span></label>
                        <input id="email" type="email" name="email" value="{{ old('email', $kesiswaan->email) }}" required autocomplete="email" class="input">
                        @error('email') <p class="field-error">{{ $message }}</p> @enderror
                        <p class="mt-1.5 text-[11px] leading-relaxed text-[#94A3B8]">Alamat ini dipakai untuk login dan menerima kode OTP saat lupa password.</p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 border-t border-[#E8EDF5] pt-5">
                    <button type="submit" class="btn-primary">
                        <x-icon name="check" :size="14" />
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('kesiswaan.dashboard') }}" class="btn-ghost">Batal</a>
                </div>
            </form>
        </section>

        <aside class="space-y-4">
            <section class="card p-5">
                <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">
                    <x-icon name="lock" :size="13" />
                    NIP Dikunci Admin
                </p>
                <input type="text" value="{{ $kesiswaan->nip }}" disabled
                       class="mt-2.5 block w-full cursor-not-allowed rounded-xl border-[#E2E8F0] bg-[#F5F7FB] py-2.5 text-[13px] text-[#64748B]">
                <p class="mt-2 text-[10.5px] leading-relaxed text-[#94A3B8]">NIP tidak dapat diubah sendiri. Hubungi admin jika perlu diperbarui.</p>
            </section>

            <section class="card p-5">
                <p class="text-[11px] font-semibold uppercase tracking-[0.08em] text-[#94A3B8]">Informasi Akun</p>
                <dl class="mt-3 space-y-3">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-[11.5px] text-[#94A3B8]">Role</dt>
                        <dd class="text-[11.5px] font-semibold text-[#0B1E38]">Kesiswaan</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-[11.5px] text-[#94A3B8]">Email</dt>
                        <dd class="truncate text-[11.5px] font-semibold text-[#0B1E38]">{{ $kesiswaan->email }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-[11.5px] text-[#94A3B8]">No. HP</dt>
                        <dd class="text-[11.5px] font-semibold text-[#0B1E38]">{{ $kesiswaan->no_hp ?: '—' }}</dd>
                    </div>
                </dl>
            </section>

            <section class="rounded-2xl border border-[#BFDBFE] bg-[#EFF6FF] p-5">
                <p class="flex items-center gap-1.5 text-[11px] font-semibold uppercase tracking-[0.08em] text-[#1D4ED8]">
                    <x-icon name="lock" :size="13" />
                    Keamanan Akun
                </p>
                <p class="mt-2 text-[11.5px] leading-relaxed text-[#3B82F6]">Ganti password secara berkala untuk menjaga keamanan akun verifikasi.</p>
                <a href="{{ route('akunpassword.edit') }}" class="mt-3 inline-flex items-center gap-1 text-[11.5px] font-semibold text-[#1D4ED8] hover:text-[#1E40AF]">
                    Ganti password
                    <x-icon name="chevron-right" :size="11" />
                </a>
            </section>
        </aside>
    </div>
</x-app-layout>
