<x-app-layout title="Profil Saya">
    <div class="max-w-2xl space-y-5">
        <div class="bg-[#2F6FED]/5 border border-[#2F6FED]/15 rounded-xl px-4 py-3.5 flex items-center gap-3">
            <svg width="16" height="16" class="shrink-0" viewBox="0 0 24 24" fill="none"><rect x="4" y="4" width="7" height="7" rx="1" stroke="#2F6FED" stroke-width="1.6"/><rect x="13" y="4" width="7" height="7" rx="1" stroke="#2F6FED" stroke-width="1.6"/><rect x="4" y="13" width="7" height="7" rx="1" stroke="#2F6FED" stroke-width="1.6"/></svg>
            <p class="text-sm text-[#2F6FED]">Link portofolio publik kamu:
                <a href="{{ route('public.profil', ['qrCode' => $siswa->qr_code, 'owner' => 1]) }}" target="_blank" class="font-semibold underline hover:text-[#1B4FC4]">
                    {{ route('public.profil', $siswa->qr_code) }}
                </a>
            </p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="p-7 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="relative shrink-0">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] flex items-center justify-center text-white text-xl font-bold">
                            {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                        </div>
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900">{{ $siswa->nama }}</h2>
                        <p class="text-sm text-slate-400">{{ $siswa->kelas }} {{ $siswa->jurusan }} &middot; NIS {{ $siswa->nis }}</p>
                    </div>
                </div>
            </div>

            <div class="p-7 bg-slate-50/70 border-b border-slate-100">
                <div class="flex items-center gap-2 mb-3.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="5" y="10" width="14" height="10" rx="2" stroke="#94A3B8" stroke-width="1.6"/><path d="M8 10V7a4 4 0 118 0v3" stroke="#94A3B8" stroke-width="1.6"/></svg>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Data Sekolah &middot; Dikunci Admin</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5">Nama Lengkap</label>
                        <input type="text" value="{{ $siswa->nama }}" disabled
                               class="block w-full rounded-xl border-slate-200 bg-slate-100 text-sm text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5">NIS</label>
                        <input type="text" value="{{ $siswa->nis }}" disabled
                               class="block w-full rounded-xl border-slate-200 bg-slate-100 text-sm text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5">Kelas</label>
                        <input type="text" value="{{ $siswa->kelas }}" disabled
                               class="block w-full rounded-xl border-slate-200 bg-slate-100 text-sm text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5">Jurusan</label>
                        <input type="text" value="{{ $siswa->jurusan }}" disabled
                               class="block w-full rounded-xl border-slate-200 bg-slate-100 text-sm text-slate-500 cursor-not-allowed">
                    </div>
                </div>
                <p class="text-xs text-slate-400 mt-3">Data di atas hanya bisa diubah oleh Admin. Hubungi admin sekolah kalau ada kesalahan data.</p>
            </div>

            <form method="POST" action="{{ route('siswa.profil.update') }}" enctype="multipart/form-data" class="p-7 space-y-5">
                @csrf
                @method('PUT')

                <div class="flex items-center gap-2 mb-1">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="#2F6FED" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <p class="text-xs font-semibold text-[#2F6FED] uppercase tracking-wide">Data Pribadi &middot; Bisa Diedit</p>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Foto Profil</label>
                    <input type="file" name="foto"
                           class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#2F6FED]/10 file:text-[#2F6FED] hover:file:bg-[#2F6FED]/20 transition">
                    @error('foto') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $siswa->email) }}"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    @error('email') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. HP / WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}" placeholder="08xxxxxxxxxx"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    @error('no_hp') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <button class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</x-app-layout>