<x-app-layout title="Profil Saya">
    <div class="max-w-2xl">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="p-7 border-b border-slate-100">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] flex items-center justify-center text-white text-xl font-bold shrink-0">
                        {{ strtoupper(substr($kesiswaan->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-bold text-slate-900">{{ $kesiswaan->nama }}</h2>
                        <p class="text-sm text-slate-400">{{ $kesiswaan->jabatan }} &middot; NIP {{ $kesiswaan->nip }}</p>
                    </div>
                </div>
            </div>

            <div class="p-7 bg-slate-50/70 border-b border-slate-100">
                <div class="flex items-center gap-2 mb-3.5">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><rect x="5" y="10" width="14" height="10" rx="2" stroke="#94A3B8" stroke-width="1.6"/><path d="M8 10V7a4 4 0 118 0v3" stroke="#94A3B8" stroke-width="1.6"/></svg>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">NIP &middot; Dikunci Admin</p>
                </div>
                <input type="text" value="{{ $kesiswaan->nip }}" disabled
                       class="block w-full rounded-xl border-slate-200 bg-slate-100 text-sm text-slate-500 cursor-not-allowed">
                <p class="text-xs text-slate-400 mt-2">NIP tidak dapat diubah sendiri. Hubungi admin jika perlu diperbarui.</p>
            </div>

            <form method="POST" action="{{ route('kesiswaan.profil.update') }}" class="p-7 space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama</label>
                    <input type="text" name="nama" value="{{ old('nama', $kesiswaan->nama) }}"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    @error('nama') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jabatan</label>
                    <input type="text" name="jabatan" value="{{ old('jabatan', $kesiswaan->jabatan) }}"
                           class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                    @error('jabatan') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email', $kesiswaan->email) }}"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                        @error('email') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">No. HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $kesiswaan->no_hp) }}" placeholder="08xxxxxxxxxx"
                               class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                        @error('no_hp') <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p> @enderror
                    </div>
                </div>

                <button class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</x-app-layout>