<x-app-layout title="Profil">
    @php
        $passwordError = $errors->hasAny(['current_password', 'password']);
        $passwordSaved = session('success') === 'Password berhasil diubah.';
        $defaultTab = ($passwordError || $passwordSaved) ? 'keamanan' : 'data';
        $foto = $siswa->foto_profil ? \Illuminate\Support\Facades\Storage::url($siswa->foto_profil) : null;
        $portofolioUrl = route('public.profil', $siswa->qr_code);
    @endphp

    <div class="mx-auto max-w-3xl" x-data="{ tab: '{{ $defaultTab }}' }">
        @php
            $isAktif = ($siswa->status_kelulusan ?? 'Aktif') === 'Aktif';
        @endphp

        {{-- KARTU IDENTITAS + TAB --}}
        <section class="mb-4 overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white">
            <div class="relative h-20 bg-gradient-to-r from-[#EEF4FF] via-white to-[#FFF7ED] sm:h-24">
                <div class="absolute inset-0 bg-gradient-to-r from-[#2F6FED]/10 via-transparent to-[#F97316]/10"></div>
                <div class="absolute -right-10 -top-16 h-40 w-40 rounded-full bg-[#2F6FED]/10 blur-2xl"></div>
                <div class="absolute -bottom-16 left-1/3 h-36 w-36 rounded-full bg-[#F97316]/10 blur-2xl"></div>
            </div>

            <div class="px-5 pb-4">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div class="flex min-w-0 items-start gap-3.5">
                        <div class="relative z-10 -mt-8 h-16 w-16 shrink-0 overflow-hidden rounded-2xl bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] ring-4 ring-white">
                            @if($foto)
                                <img src="{{ $foto }}" alt="Foto {{ $siswa->nama }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center font-display text-xl font-semibold text-white">
                                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0 pt-0.5">
                            <h2 class="truncate font-display text-base font-semibold text-[#0B1E38] sm:text-lg">{{ $siswa->nama }}</h2>
                            <p class="mt-0.5 text-xs text-[#64748B]">
                                {{ $siswa->kelas ?: '—' }} {{ $siswa->jurusan }} &middot; NIS {{ $siswa->nis }}
                            </p>
                        </div>
                    </div>

                    <span class="mt-1 inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $isAktif ? 'bg-[#22C55E]/10 text-[#15803D]' : 'bg-[#EEF4FF] text-[#1B4FC4]' }}">
                        @if($isAktif)
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/>
                                <path d="M16 9l-5 5-2.5-2.5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        @else
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M3 9l9-5 9 5-9 5-9-5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                <path d="M7 11v4.5c0 1.4 2.2 2.5 5 2.5s5-1.1 5-2.5V11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                        @endif
                        {{ $isAktif ? 'Siswa Aktif' : 'Alumni' }}
                    </span>
                </div>

                @if($siswa->email)
                    <p class="mt-2 inline-flex items-center gap-1.5 text-xs text-[#94A3B8]">
                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <rect x="3.5" y="5.5" width="17" height="13" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
                            <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        {{ $siswa->email }}
                    </p>
                @endif
            </div>

            {{-- TAB --}}
            <div class="flex gap-1 border-t border-[#F1F5F9] px-3 py-2">
                <button type="button" @click="tab = 'data'"
                        class="inline-flex items-center gap-1.5 rounded-lg px-3.5 py-2 text-xs font-semibold transition"
                        :class="tab === 'data' ? 'bg-[#2F6FED] text-white' : 'text-[#64748B] hover:bg-[#F8FAFC]'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M4.5 20a7.5 7.5 0 0 1 15 0" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                    Data Pribadi
                </button>
                <button type="button" @click="tab = 'keamanan'"
                        class="inline-flex items-center gap-1.5 rounded-lg px-3.5 py-2 text-xs font-semibold transition"
                        :class="tab === 'keamanan' ? 'bg-[#2F6FED] text-white' : 'text-[#64748B] hover:bg-[#F8FAFC]'">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <rect x="5" y="10" width="14" height="10" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
                        <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                    </svg>
                    Keamanan Akun
                </button>
            </div>
        </section>

        {{-- TAB: DATA PRIBADI --}}
        <div x-show="tab === 'data'" class="space-y-4">
            {{-- PORTOFOLIO --}}
            <section class="overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white">
                <div class="flex items-center gap-3 border-b border-[#F1F5F9] px-5 py-4 sm:px-6">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <rect x="3.5" y="3.5" width="6.5" height="6.5" rx="1.4" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="14" y="3.5" width="6.5" height="6.5" rx="1.4" stroke="currentColor" stroke-width="1.7"/>
                            <rect x="3.5" y="14" width="6.5" height="6.5" rx="1.4" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M14 14h3v3h-3z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Portofolio Publik</h2>
                        <p class="text-xs text-[#64748B]">Bagikan tautan ini atau lewat QR Code saat scan.</p>
                    </div>
                </div>

                <div class="p-5 sm:p-6" x-data="{ copied: false }">
                    <div class="flex flex-col gap-2.5 sm:flex-row">
                        <div class="relative flex-1">
                            <span class="pointer-events-none absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94A3B8]">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M10 13.5a4 4 0 0 0 5.7 0l2.8-2.8a4 4 0 1 0-5.7-5.7L11.5 6.3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                    <path d="M14 10.5a4 4 0 0 0-5.7 0l-2.8 2.8a4 4 0 1 0 5.7 5.7l1.3-1.3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                            </span>
                            <input type="text" readonly value="{{ $portofolioUrl }}"
                                   class="block w-full cursor-text rounded-xl border border-[#E2E8F0] bg-[#F8FAFC] py-2.5 pl-10 pr-3.5 text-sm text-[#475569] focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20">
                        </div>

                        <div class="flex gap-2">
                            <button type="button"
                                    @click="navigator.clipboard.writeText('{{ $portofolioUrl }}').then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
                                    class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl border border-[#E2E8F0] px-4 py-2.5 text-sm font-semibold text-[#475569] transition hover:bg-[#F8FAFC] sm:flex-none">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true" x-show="!copied">
                                    <rect x="8.5" y="8.5" width="11.5" height="11.5" rx="2" stroke="currentColor" stroke-width="1.7"/>
                                    <path d="M15.5 8.5V6A1.5 1.5 0 0 0 14 4.5H6A1.5 1.5 0 0 0 4.5 6v8A1.5 1.5 0 0 0 6 15.5h2.5" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                                </svg>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true" x-show="copied" x-cloak>
                                    <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span x-show="!copied">Salin</span>
                                <span x-show="copied" x-cloak>Disalin</span>
                            </button>

                            <a href="{{ route('public.profil', ['qrCode' => $siswa->qr_code, 'owner' => 1]) }}" target="_blank" rel="noopener"
                               class="inline-flex flex-1 items-center justify-center gap-1.5 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#2F6FED]/20 transition hover:opacity-90 sm:flex-none">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M14 4h6v6M20 4l-7 7M10 20H4v-6M4 20l7-7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Buka
                            </a>
                        </div>
                    </div>

                    <p class="mt-3 flex items-start gap-1.5 text-[11px] leading-relaxed text-[#94A3B8]">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true" class="mt-0.5 shrink-0">
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M12 11v5.5M12 7.5v.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Hanya prestasi berstatus <strong class="font-semibold text-[#64748B]">Disetujui</strong> yang tampil di portofolio publik.
                    </p>
                </div>
            </section>

            {{-- DATA SEKOLAH (TERKUNCI) --}}
            <section class="overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white">
                <div class="flex items-center gap-3 border-b border-[#F1F5F9] px-5 py-4 sm:px-6">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#F5F7FB] text-[#64748B]">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <rect x="5" y="10" width="14" height="10" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
                            <path d="M8 10V7a4 4 0 1 1 8 0v3" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <h2 class="flex items-center gap-2 font-display text-sm font-semibold text-[#0B1E38]">
                            Data Sekolah
                            <span class="rounded-md bg-[#F1F5F9] px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-[#64748B]">Dikunci</span>
                        </h2>
                        <p class="text-xs text-[#64748B]">Perubahan data ini hanya bisa dilakukan Admin.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 p-5 sm:grid-cols-2 sm:p-6">
                    <div class="rounded-xl border border-[#E8EDF5] bg-[#F8FAFC] px-4 py-3">
                        <p class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#94A3B8]">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.8"/>
                                <path d="M4.5 20a7.5 7.5 0 0 1 15 0" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            Nama Lengkap
                        </p>
                        <p class="mt-1 text-sm font-medium text-[#0B1E38]">{{ $siswa->nama }}</p>
                    </div>
                    <div class="rounded-xl border border-[#E8EDF5] bg-[#F8FAFC] px-4 py-3">
                        <p class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#94A3B8]">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <rect x="3" y="5" width="18" height="14" rx="2.5" stroke="currentColor" stroke-width="1.8"/>
                                <path d="M7 9h4M7 13h3M15 9h2M15 13h2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            NIS
                        </p>
                        <p class="mt-1 text-sm font-medium tabular-nums text-[#0B1E38]">{{ $siswa->nis }}</p>
                    </div>
                    <div class="rounded-xl border border-[#E8EDF5] bg-[#F8FAFC] px-4 py-3">
                        <p class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#94A3B8]">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M8 4a4 4 0 0 1 4 4v4a4 4 0 0 1-4 4H4a4 4 0 0 1-4-4V8a4 4 0 0 1 4-4h8Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                <path d="M8 12h.01M12 12h.01M16 12h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            NPSN
                        </p>
                        <p class="mt-1 text-sm font-medium tabular-nums text-[#0B1E38]">{{ $siswa->npsn ?: '—' }}</p>
                    </div>
                    <div class="rounded-xl border border-[#E8EDF5] bg-[#F8FAFC] px-4 py-3">
                        <p class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#94A3B8]">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M3 9l9-5 9 5-9 5-9-5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                                <path d="M7 11v4.5c0 1.4 2.2 2.5 5 2.5s5-1.1 5-2.5V11" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                            </svg>
                            Kelas
                        </p>
                        <p class="mt-1 text-sm font-medium text-[#0B1E38]">{{ $siswa->kelas ?: '—' }}</p>
                    </div>
                    <div class="rounded-xl border border-[#E8EDF5] bg-[#F8FAFC] px-4 py-3">
                        <p class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#94A3B8]">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M4 6.5A1.5 1.5 0 0 1 5.5 5h3l1.5 4-2 1.5a11 11 0 0 0 5.5 5.5l1.5-2 4 1.5v3A1.5 1.5 0 0 1 17.5 20 13.5 13.5 0 0 1 4 6.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                            </svg>
                            Jurusan
                        </p>
                        <p class="mt-1 text-sm font-medium text-[#0B1E38]">{{ $siswa->jurusan ?: '—' }}</p>
                    </div>
                </div>
            </section>

            {{-- DATA PRIBADI (BISA DIEDIT) --}}
            <section class="overflow-hidden rounded-2xl border border-[#E8EDF5] bg-white">
                <div class="flex items-center gap-3 border-b border-[#F1F5F9] px-5 py-4 sm:px-6">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-[#EEF4FF] text-[#2F6FED]">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M18.4 2.6a2 2 0 0 1 2.8 2.8L12 14.6l-3.6 1 1-3.6 9-9.4Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                            <path d="M11 4H5.5A1.5 1.5 0 0 0 4 5.5v13A1.5 1.5 0 0 0 5.5 20h13a1.5 1.5 0 0 0 1.5-1.5V13" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <div class="min-w-0">
                        <h2 class="font-display text-sm font-semibold text-[#0B1E38]">Data Pribadi</h2>
                        <p class="text-xs text-[#64748B]">Kamu bisa memperbarui data ini kapan saja.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('siswa.profil.update') }}" enctype="multipart/form-data"
                      class="space-y-5 p-5 sm:p-6" x-data="{ preview: null }">
                    @csrf
                    @method('PUT')

                    <div class="flex flex-wrap items-center gap-4">
                        <div class="relative">
                            <div class="h-16 w-16 overflow-hidden rounded-2xl bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4]">
                                <img x-show="preview" :src="preview" alt="Pratinjau foto baru" class="h-full w-full object-cover" x-cloak>
                                @if($foto)
                                    <img x-show="!preview" src="{{ $foto }}" alt="Foto {{ $siswa->nama }}" class="h-full w-full object-cover">
                                @else
                                    <div x-show="!preview" class="flex h-full w-full items-center justify-center font-display text-xl font-semibold text-white">
                                        {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <span class="absolute -bottom-1.5 -right-1.5 flex h-6 w-6 items-center justify-center rounded-full border-2 border-white bg-[#2F6FED] text-white">
                                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3" y="6" width="18" height="14" rx="2.5" stroke="currentColor" stroke-width="1.8"/>
                                    <circle cx="12" cy="13" r="3.2" stroke="currentColor" stroke-width="1.8"/>
                                </svg>
                            </span>
                        </div>

                        <div class="min-w-0 flex-1">
                            <label for="foto_profil" class="mb-1.5 block text-xs font-semibold text-[#64748B]">Foto Profil</label>
                            <input id="foto_profil" type="file" name="foto_profil" accept="image/png,image/jpeg"
                                   @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                                   class="block w-full text-sm text-[#64748B] file:mr-4 file:rounded-lg file:border-0 file:bg-[#EEF4FF] file:px-4 file:py-2 file:text-xs file:font-semibold file:text-[#2F6FED] hover:file:bg-[#E0EAFF]">
                            <p class="mt-1.5 text-[11px] text-[#94A3B8]">JPG/PNG, maksimal 2MB.</p>
                            @error('foto_profil') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="email" class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-[#64748B]">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <rect x="3.5" y="5.5" width="17" height="13" rx="2.5" stroke="currentColor" stroke-width="1.7"/>
                                    <path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email', $siswa->email) }}"
                                   class="block w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-[#0B1E38] shadow-sm transition focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 {{ $errors->has('email') ? 'border-red-300' : 'border-[#E2E8F0]' }}">
                            @error('email') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="no_hp" class="mb-1.5 flex items-center gap-1.5 text-xs font-semibold text-[#64748B]">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                    <path d="M4 6.5A1.5 1.5 0 0 1 5.5 5h3l1.5 4-2 1.5a11 11 0 0 0 5.5 5.5l1.5-2 4 1.5v3A1.5 1.5 0 0 1 17.5 20 13.5 13.5 0 0 1 4 6.5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                                </svg>
                                No. HP / WhatsApp
                            </label>
                            <input id="no_hp" type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}" placeholder="08xxxxxxxxxx"
                                   class="block w-full rounded-xl border bg-white px-3.5 py-2.5 text-sm text-[#0B1E38] placeholder:text-[#94A3B8] shadow-sm transition focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 {{ $errors->has('no_hp') ? 'border-red-300' : 'border-[#E2E8F0]' }}">
                            @error('no_hp') <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-3 border-t border-[#F1F5F9] pt-5">
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-[#2F6FED]/25 transition hover:opacity-90 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#2F6FED] focus-visible:ring-offset-2">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <path d="M20 6 9 17l-5-5" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </section>
        </div>

        {{-- TAB: KEAMANAN AKUN --}}
        <div x-show="tab === 'keamanan'" x-cloak>
            @include('partials.password-form')
        </div>
    </div>
</x-app-layout>
