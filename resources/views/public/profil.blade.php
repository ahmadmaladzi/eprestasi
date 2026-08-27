<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portofolio - {{ $siswa->nama }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-3xl mx-auto py-10 px-4">
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6 flex items-center justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">{{ $siswa->nama }}</h1>
                <p class="text-sm text-gray-500">{{ $siswa->nis }} &middot; {{ $siswa->kelas }} {{ $siswa->jurusan }}</p>
            </div>
            <div class="text-center">
                {!! $qrImage !!}
                <a href="{{ route('public.profil.pdf', $siswa->qr_code) }}" class="block mt-2 text-xs text-blue-600 hover:underline">Unduh Portofolio PDF</a>
            </div>
        </div>

        <h2 class="text-lg font-semibold text-slate-800 mb-3">Prestasi Terverifikasi ({{ $prestasi->count() }})</h2>

        <div class="space-y-3">
            @forelse($prestasi as $item)
                <div class="bg-white rounded-lg shadow-sm p-4">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium text-slate-800">{{ $item->nama_prestasi }}</h3>
                            <p class="text-sm text-gray-500">{{ $item->penyelenggara }} &middot; {{ $item->tingkat }} &middot; {{ $item->tanggal->format('d M Y') }}</p>
                            @if($item->kategori)<p class="text-xs text-slate-500 mt-1">Kategori: {{ $item->kategori }}</p>@endif
                            @if($item->deskripsi)<p class="text-sm text-gray-600 mt-1">{{ $item->deskripsi }}</p>@endif
                        </div>
                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Terverifikasi</span>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Belum ada prestasi yang terverifikasi.</p>
            @endforelse
        </div>

        <p class="text-center text-xs text-gray-400 mt-8">Portofolio ini dibagikan melalui sistem E-Prestasi</p>
    </div>
</body>
</html>
