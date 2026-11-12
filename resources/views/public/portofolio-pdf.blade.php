<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #1e293b; }
        h1 { font-size: 20px; margin-bottom: 0; }
        .sub { color: #64748b; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px; text-align: left; font-size: 11px; }
        th { background: #f1f5f9; }

        .item { border: 1px solid #cbd5e1; border-radius: 6px; padding: 12px; margin-top: 14px; page-break-inside: avoid; }
        .item h3 { margin: 0 0 2px 0; font-size: 13px; }
        .item .meta { color: #64748b; font-size: 10.5px; margin-bottom: 8px; }
        .item h4 { font-size: 10px; text-transform: uppercase; letter-spacing: 0.4px; color: #64748b; margin: 8px 0 4px 0; }
        .file-grid { width: 100%; }
        .file-grid td { border: none; padding: 3px; text-align: center; vertical-align: top; }
        .file-grid img { width: 100px; height: 75px; object-fit: cover; border: 1px solid #cbd5e1; border-radius: 4px; }
        .file-box { width: 100px; height: 75px; border: 1px solid #cbd5e1; border-radius: 4px; background: #f8fafc; display: block; }
        .file-name { font-size: 8.5px; color: #64748b; width: 100px; margin-top: 2px; word-wrap: break-word; }
        .empty-note { color: #94a3b8; font-size: 10.5px; }
        .brand-table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        .brand-table td { border: none; padding: 0; vertical-align: middle; }
        .brand-title { font-size: 18px; font-weight: bold; color: #0B1E38; }
        .brand-sub { color: #64748b; font-size: 9px; margin-top: 2px; }
    </style>
</head>
<body>
    <table class="brand-table">
        <tr>
            <td style="width: 48px;">
                <img src="{{ public_path('images/logo-eprestasi.png') }}" style="width: 44px; height: 44px;" alt="E-Prestasi">
            </td>
            <td style="padding-left: 10px;">
                <div class="brand-title">E-Prestasi</div>
                <div class="brand-sub">Sistem Informasi Prestasi Siswa</div>
            </td>
        </tr>
    </table>

    <h1>Portofolio Prestasi</h1>
    <p class="sub">{{ $siswa->nama }} &middot; {{ $siswa->npsn ?: '—' }} &middot; {{ $siswa->nis }} &middot; {{ $siswa->kelas }} {{ $siswa->jurusan }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Prestasi</th>
                <th>Penyelenggara</th>
                <th>Tingkat</th>
                <th>Kategori</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($prestasi as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->nama_prestasi }}</td>
                    <td>{{ $item->penyelenggara }}</td>
                    <td>{{ $item->tingkat }}</td>
                    <td>{{ $item->kategori }}</td>
                    <td>{{ $item->tanggal->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="6">Belum ada prestasi terverifikasi.</td></tr>
            @endforelse
        </tbody>
    </table>

    @forelse($prestasi as $i => $item)
        <div class="item">
            <h3>{{ $i + 1 }}. {{ $item->nama_prestasi }}</h3>
            <p class="meta">{{ $item->penyelenggara }} &middot; {{ $item->tingkat }} &middot; {{ $item->tanggal->format('d M Y') }}</p>

            <h4>Sertifikat</h4>
            @if($item->sertifikat->count())
                <table class="file-grid">
                    <tr>
                        @foreach($item->sertifikat as $s)
                            <td>
                                @php
                                    $ext = strtolower(pathinfo($s->file_path, PATHINFO_EXTENSION));
                                    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'jfif']);
                                    $filePath = storage_path('app/public/' . $s->file_path);
                                @endphp
                                @if($isImage && file_exists($filePath))
                                    <img src="{{ $filePath }}">
                                @else
                                    <div class="file-box"></div>
                                @endif
                                <div class="file-name">{{ $s->nama_file }}</div>
                            </td>
                        @endforeach
                    </tr>
                </table>
            @else
                <p class="empty-note">Tidak ada sertifikat.</p>
            @endif

            <h4>Dokumentasi Foto</h4>
            @if($item->dokumentasi->count())
                <table class="file-grid">
                    <tr>
                        @foreach($item->dokumentasi as $d)
                            <td>
                                @php
                                    $fotoPath = storage_path('app/public/' . $d->foto);
                                @endphp
                                @if(file_exists($fotoPath))
                                    <img src="{{ $fotoPath }}">
                                @endif
                            </td>
                        @endforeach
                    </tr>
                </table>
            @else
                <p class="empty-note">Tidak ada dokumentasi foto.</p>
            @endif
        </div>
    @empty
    @endforelse

    <p style="margin-top: 30px; font-size: 10px; color: #94a3b8;">
        Dokumen ini dihasilkan otomatis oleh sistem E-Prestasi pada {{ now()->format('d M Y H:i') }}.
    </p>
</body>
</html>