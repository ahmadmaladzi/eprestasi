<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portofolio - {{ $siswa->nama }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#FAFBFF] antialiased">
    <div class="bg-gradient-to-b from-[#0B1E38] to-[#0F2540] pb-20 pt-10 px-4 relative overflow-hidden">
        <div class="absolute left-1/2 top-0 -translate-x-1/2 w-[500px] h-[300px] bg-[#2F6FED]/20 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="max-w-3xl mx-auto relative">
            <div class="inline-flex items-center gap-2 bg-white/10 border border-white/10 rounded-full px-3 py-1.5 mb-4">
                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M4 4H20V17L12 21L4 17V4Z" stroke="white" stroke-width="1.8" stroke-linejoin="round"/><path d="M9 11L11 13L15 9" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="text-xs font-medium text-white/80">Portofolio Terverifikasi Resmi</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white">{{ $siswa->nama }}</h1>
            <p class="text-sm text-white/50 mt-1">{{ $siswa->nis }} &middot; {{ $siswa->kelas }} {{ $siswa->jurusan }}</p>
        </div>
    </div>

    <div class="max-w-3xl mx-auto px-4 -mt-12 relative">
        <div class="bg-white rounded-2xl shadow-xl shadow-black/5 border border-slate-100 p-6 mb-6 flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#2F6FED] to-[#1B4FC4] flex items-center justify-center text-white text-lg font-bold shrink-0">
                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">{{ $prestasi->count() }} Prestasi Terverifikasi</p>
                    <p class="text-xs text-slate-400 mt-0.5">Diperiksa langsung oleh pihak kesiswaan sekolah</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if(request('owner'))
                    <div class="text-center bg-slate-50 rounded-xl p-3">
                        {!! $qrImage !!}
                        <p class="text-[10px] text-slate-400 mt-1.5">QR kamu — tunjukkan ini ke orang lain</p>
                    </div>
                @endif
                <a href="{{ route('public.profil.pdf', $siswa->qr_code) }}"
                   class="inline-flex items-center gap-2 bg-gradient-to-r from-[#2F6FED] to-[#1B4FC4] text-white px-5 py-3 rounded-xl text-sm font-semibold hover:opacity-90 transition shadow-lg shadow-[#2F6FED]/25 shrink-0">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M12 3V15M12 15L8 11M12 15L16 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M4 17V19C4 20.1 4.9 21 6 21H18C19.1 21 20 20.1 20 19V17" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>
                    Unduh PDF
                </a>
            </div>
        </div>

        <h2 class="text-base font-bold text-slate-900 mb-3.5 px-1">Prestasi Terverifikasi ({{ $prestasi->count() }})</h2>

        <div class="space-y-3 mb-10">
            @forelse($prestasi as $item)
                <div class="bg-white rounded-2xl border border-slate-200 p-5">
                    <div class="flex justify-between items-start gap-4">
                        <div class="flex gap-3.5">
                            <div class="w-9 h-9 rounded-lg bg-[#2F6FED]/10 flex items-center justify-center shrink-0 mt-0.5">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M12 2L14.5 8.5L21 9L16 13.5L17.5 20L12 16.5L6.5 20L8 13.5L3 9L9.5 8.5L12 2Z" fill="#2F6FED"/></svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-slate-800">{{ $item->nama_prestasi }}</h3>
                                <p class="text-sm text-slate-400 mt-0.5">{{ $item->penyelenggara }} &middot; {{ $item->tingkat }} &middot; {{ $item->tanggal->format('d M Y') }}</p>
                                @if($item->kategori)<p class="text-xs text-[#2F6FED] font-medium mt-1.5">{{ $item->kategori }}</p>@endif
                                @if($item->deskripsi)<p class="text-sm text-slate-500 mt-2 leading-relaxed">{{ $item->deskripsi }}</p>@endif
                            </div>
                        </div>
                        <span class="text-xs font-semibold bg-[#22C55E]/10 text-[#16A34A] px-2.5 py-1 rounded-full shrink-0">Terverifikasi</span>
                    </div>

                    @if($item->sertifikat->count())
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Sertifikat</p>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach($item->sertifikat as $s)
                                    @php
                                        $ext = strtolower(pathinfo($s->file_path, PATHINFO_EXTENSION));
                                        $isImage = in_array($ext, ['jpg', 'jpeg', 'png']);
                                    @endphp
                                    <a href="{{ Storage::url($s->file_path) }}" target="_blank" class="block">
                                        @if($isImage)
                                            <img src="{{ Storage::url($s->file_path) }}" class="w-24 h-24 object-cover rounded-lg border border-slate-200 hover:opacity-80 transition">
                                        @else
                                            <span class="w-24 h-24 flex flex-col items-center justify-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 text-slate-400 hover:bg-slate-100 transition px-2 text-center">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M4 4H20V17L12 21L4 17V4Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/></svg>
                                                <span class="text-[10px] leading-tight line-clamp-2">{{ $s->nama_file }}</span>
                                            </span>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($item->dokumentasi->count())
                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Dokumentasi Foto</p>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach($item->dokumentasi as $d)
                                    <a href="{{ Storage::url($d->foto) }}" target="_blank">
                                        <img src="{{ Storage::url($d->foto) }}" class="w-24 h-24 object-cover rounded-lg border border-slate-200 hover:opacity-80 transition">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white rounded-2xl border border-slate-200 p-8 text-center">
                    <p class="text-slate-400 text-sm">Belum ada prestasi yang terverifikasi.</p>
                </div>
            @endforelse
        </div>

        <p class="text-center text-xs text-slate-400 pb-10">Portofolio ini dibagikan melalui sistem E-Prestasi</p>
    </div>
</body>
</html>