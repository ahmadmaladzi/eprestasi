<x-app-layout title="Detail Verifikasi">
    <div class="max-w-2xl bg-white rounded-2xl border border-slate-200 p-7 space-y-6" x-data="{ status: '{{ $prestasi->status === 'Belum' ? '' : $prestasi->status }}' }">
        <div>
            <h2 class="text-xl font-extrabold text-slate-900">{{ $prestasi->nama_prestasi }}</h2>
            <p class="text-sm text-slate-500 mt-1.5">
                Diajukan oleh <strong class="text-slate-700">{{ $prestasi->siswa->nama }}</strong> ({{ $prestasi->siswa->nis }}) &middot;
                {{ $prestasi->penyelenggara }} &middot; {{ $prestasi->tingkat }} &middot; {{ $prestasi->tanggal->format('d M Y') }}
            </p>
        </div>

        <div>
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Deskripsi</h3>
            <p class="text-sm text-slate-600 leading-relaxed">{{ $prestasi->deskripsi ?: '—' }}</p>
        </div>

        <div>
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2.5">Sertifikat</h3>
            <ul class="space-y-2 text-sm">
                @forelse($prestasi->sertifikat as $s)
                    <li>
                        <a href="{{ Storage::url($s->file_path) }}" target="_blank"
                           class="inline-flex items-center gap-2 text-[#2F6FED] hover:text-[#1B4FC4] bg-[#2F6FED]/5 hover:bg-[#2F6FED]/10 px-3 py-2 rounded-lg transition">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M4 4H20V17L12 21L4 17V4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                            {{ $s->nama_file }}
                        </a>
                    </li>
                @empty
                    <li class="text-slate-400">Tidak ada sertifikat.</li>
                @endforelse
            </ul>
        </div>

        <div>
            <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2.5">Dokumentasi Foto</h3>
            <div class="grid grid-cols-3 gap-2.5">
                @forelse($prestasi->dokumentasi as $d)
                    <img src="{{ Storage::url($d->foto) }}" class="rounded-xl border border-slate-200 w-full h-24 object-cover">
                @empty
                    <p class="text-slate-400 text-sm">Tidak ada dokumentasi foto.</p>
                @endforelse
            </div>
        </div>

        @if($prestasi->status === 'Belum')
            <form method="POST" action="{{ route('kesiswaan.prestasi.verifikasi', $prestasi) }}" class="space-y-4 pt-5 border-t border-slate-100">
                @csrf
                <input type="hidden" name="status" x-model="status">

                <div class="flex gap-3">
                    <button type="button" @click="status = 'Disetujui'"
                            :class="status === 'Disetujui' ? 'bg-[#16A34A] text-white shadow-lg shadow-green-500/25' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold transition">✓ Setujui</button>
                    <button type="button" @click="status = 'Ditolak'"
                            :class="status === 'Ditolak' ? 'bg-red-600 text-white shadow-lg shadow-red-500/25' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'"
                            class="px-5 py-2.5 rounded-xl text-sm font-semibold transition">✕ Tolak</button>
                </div>

                <div x-show="status === 'Disetujui'" x-cloak>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kategori Prestasi</label>
                    <select name="kategori" class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="Akademik">Akademik</option>
                        <option value="Non Akademik">Non Akademik</option>
                        <option value="Kejuaraan">Kejuaraan</option>
                    </select>
                </div>

                <div x-show="status === 'Ditolak'" x-cloak>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Catatan Penolakan</label>
                    <textarea name="catatan" rows="2" class="block w-full rounded-xl border-slate-200 text-sm shadow-sm focus:border-[#2F6FED] focus:ring-2 focus:ring-[#2F6FED]/20 transition" placeholder="Contoh: sertifikat kurang jelas, mohon upload ulang"></textarea>
                </div>

                <button type="submit" x-show="status" x-cloak
                        class="bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25">
                    Kirim Verifikasi
                </button>
            </form>
        @else
            <div class="pt-5 border-t border-slate-100 text-sm">
                @php
                    $badge = match($prestasi->status) {
                        'Disetujui' => 'bg-[#22C55E]/10 text-[#16A34A]',
                        default => 'bg-red-50 text-red-600',
                    };
                @endphp
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }}">{{ $prestasi->status }}</span>
                @if($prestasi->kategori) <span class="text-slate-500 ml-2">Kategori: <strong class="text-slate-700">{{ $prestasi->kategori }}</strong></span> @endif
                @if($prestasi->catatan)<p class="mt-2.5 text-slate-500">Catatan: {{ $prestasi->catatan }}</p>@endif
            </div>
        @endif

        <a href="{{ route('kesiswaan.prestasi.index') }}" class="inline-block text-sm text-slate-500 hover:text-slate-700 font-medium">&larr; Kembali</a>
    </div>
</x-app-layout>