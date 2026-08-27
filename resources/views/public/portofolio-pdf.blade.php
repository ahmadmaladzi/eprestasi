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
    </style>
</head>
<body>
    <h1>Portofolio Prestasi</h1>
    <p class="sub">{{ $siswa->nama }} &middot; {{ $siswa->nis }} &middot; {{ $siswa->kelas }} {{ $siswa->jurusan }}</p>

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

    <p style="margin-top: 30px; font-size: 10px; color: #94a3b8;">
        Dokumen ini dihasilkan otomatis oleh sistem E-Prestasi pada {{ now()->format('d M Y H:i') }}.
    </p>
</body>
</html>
