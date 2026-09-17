<x-app-layout title="Detail Prestasi">
    <a href="{{ route('siswa.prestasi.index') }}" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-700 font-medium mb-5">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Kembali ke Prestasi Saya
    </a>

    <div class="grid lg:grid-cols-[1fr_300px] gap-6 items-start">
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
            <div class="p-7 border-b border-slate-100">
                <div class="flex items-start justify-between gap-4 mb-4">
                    <div class="flex gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-[#2F6FED]/10 flex items-center justify-center shrink-0">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 8.5L21 9L16 13.5L17.5 20L12 16.5L6.5 20L8 13.5L3 9L9.5 8.5L12 2Z" fill="#2F6FED"/></svg>
                        </div>
                        <div>
                            <h1 class="text-lg font-bold text-slate-900">{{ $prestasi->nama_prestasi }}</h1>
                            <p class="text-sm text-slate-400 mt-0.5">{{ $prestasi->penyelenggara }}</p>
                        </div>
                    </div>
                    @php
                        $badge = match($prestasi->status) {
                            'Disetujui' => 'bg-[#22C55E]/10 text-[#16A34A]',
                            'Ditolak' => 'bg-red-50 text-red-600',
                            default => 'bg-[#F59E0B]/10 text-[#D97706]',
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-semibold shrink-0 {{ $badge }}">{{ $prestasi->status }}</span>
                </div>

                <div class="flex flex-wrap gap-2">
                    <span class="text-xs font-medium text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">{{ $prestasi->tingkat }}</span>
                    <span class="text-xs font-medium text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">{{ $prestasi->tanggal->format('d M Y') }}</span>
                    @if($prestasi->kategori)
                        <span class="text-xs font-medium text-[#2F6FED] bg-[#2F6FED]/10 px-2.5 py-1 rounded-full">{{ $prestasi->kategori }}</span>
                    @endif
                    @if($prestasi->asal)
                        <span class="text-xs font-medium text-slate-600 bg-slate-100 px-2.5 py-1 rounded-full">{{ $prestasi->asal }}</span>
                    @endif
                    @if($prestasi->terhubung_puspresnas)
                        <span class="text-xs font-medium text-[#16A34A] bg-[#22C55E]/10 px-2.5 py-1 rounded-full">Terhubung Puspresnas</span>
                    @endif
                </div>
            </div>

            @if($prestasi->status === 'Ditolak' && $prestasi->catatan)
                <div class="mx-7 mt-6 bg-red-50 border border-red-100 rounded-xl p-4">
                    <p class="text-xs font-semibold text-red-700 mb-1">Catatan Penolakan</p>
                    <p class="text-sm text-red-600 leading-relaxed">{{ $prestasi->catatan }}</p>
                </div>
            @endif

            <div class="p-7 space-y-6">
                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Deskripsi</h3>
                    <p class="text-sm text-slate-600 leading-relaxed">{{ $prestasi->deskripsi ?: 'Tidak ada deskripsi.' }}</p>
                </div>

                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2.5">Sertifikat</h3>
                    <div class="space-y-2">
                        @forelse($prestasi->sertifikat as $s)
                            <a href="{{ Storage::url($s->file_path) }}" target="_blank"
                               class="flex items-center gap-2.5 text-[#2F6FED] hover:text-[#1B4FC4] bg-[#2F6FED]/5 hover:bg-[#2F6FED]/10 px-3.5 py-2.5 rounded-xl transition text-sm">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M4 4H20V17L12 21L4 17V4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                                {{ $s->nama_file ?? 'Lihat Sertifikat' }}
                            </a>
                        @empty
                            <p class="text-sm text-slate-400">Belum ada sertifikat diunggah.</p>
                        @endforelse
                    </div>
                </div>

                <div>
                    <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2.5">Dokumentasi Foto</h3>
                    @if($prestasi->dokumentasi->count() > 0)
                        <div class="grid grid-cols-3 gap-2.5">
                            @foreach($prestasi->dokumentasi as $d)
                                <img src="{{ Storage::url($d->foto) }}" class="rounded-xl border border-slate-200 w-full h-24 object-cover">
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-slate-400">Belum ada dokumentasi foto.</p>
                    @endif
                </div>
            </div>

            @if(in_array($prestasi->status, ['Belum', 'Ditolak']))
                <div class="px-7 py-5 bg-slate-50 border-t border-slate-100 flex gap-3">
                    <a href="{{ route('siswa.prestasi.edit', $prestasi) }}"
                       class="inline-flex items-center gap-2 bg-white border border-slate-200 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-slate-50 transition">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M11 4H4V20H20V13" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M18.5 2.5A2.12 2.12 0 0 1 21 5L12 14L8 15L9 11L18.5 2.5Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        Edit Prestasi
                    </a>
                    <form method="POST" action="{{ route('siswa.prestasi.destroy', $prestasi) }}" onsubmit="return confirm('Yakin hapus prestasi ini? Tindakan ini tidak bisa dibatalkan.')">
                        @csrf @method('DELETE')
                        <button class="inline-flex items-center gap-2 bg-white border border-red-200 text-red-600 px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-red-50 transition">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M3 6H21M8 6V4C8 3.4 8.4 3 9 3H15C15.6 3 16 3.4 16 4V6M19 6V20C19 20.6 18.6 21 18 21H6C5.4 21 5 20.6 5 20V6H19Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            Hapus
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-slate-200 p-5">
                <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-4">Riwayat</h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-6 h-6 rounded-full bg-[#2F6FED] flex items-center justify-center shrink-0 mt-0.5">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-700">Diajukan</p>
                            <p class="text-xs text-slate-400 mt-0.5">{{ $prestasi->created_at->translatedFormat('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    @if($prestasi->status !== 'Belum')
                        <div class="flex gap-3">
                            <div class="w-6 h-6 rounded-full {{ $prestasi->status === 'Disetujui' ? 'bg-[#16A34A]' : 'bg-red-500' }} flex items-center justify-center shrink-0 mt-0.5">
                                @if($prestasi->status === 'Disetujui')
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                @else
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M6 6L18 18M18 6L6 18" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-700">{{ $prestasi->status }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">
                                    {{ $prestasi->tanggal_verifikasi ? $prestasi->tanggal_verifikasi->translatedFormat('d M Y, H:i') : $prestasi->updated_at->translatedFormat('d M Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="flex gap-3 opacity-40">
                            <div class="w-6 h-6 rounded-full border-2 border-dashed border-slate-300 shrink-0 mt-0.5"></div>
                            <div>
                                <p class="text-xs font-semibold text-slate-500">Menunggu verifikasi</p>
                                <p class="text-xs text-slate-400 mt-0.5">Belum diproses kesiswaan</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-[#2F6FED]/5 border border-[#2F6FED]/15 rounded-2xl p-5">
                <p class="text-xs font-semibold text-[#2F6FED] mb-1.5">💡 Tips</p>
                <p class="text-xs text-slate-600 leading-relaxed">
                    @if($prestasi->status === 'Ditolak')
                        Perbaiki data sesuai catatan penolakan, lalu ajukan ulang lewat tombol Edit.
                    @elseif($prestasi->status === 'Belum')
                        Prestasi kamu sedang diperiksa kesiswaan. Proses biasanya 1-3 hari kerja.
                    @else
                        Prestasi ini sudah terverifikasi dan tampil di portofolio publik kamu.
                    @endif
                </p>
            </div>
        </div>
    </div>
</x-app-layout>