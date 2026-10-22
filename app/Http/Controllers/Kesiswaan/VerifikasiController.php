<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\TahunAjaran;
use App\Notifications\StatusVerifikasiNotification;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestasi::with(['siswa', 'tahunAjaran']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->orderByRaw("FIELD(status, 'Belum', 'Ditolak', 'Disetujui')");
        }

        $ajaranUntukKartu = null;
        if ($request->has('tahun_ajaran') && $request->tahun_ajaran !== 'semua') {
            $query->where('id_ajaran', $request->tahun_ajaran);
            $ajaranUntukKartu = $request->tahun_ajaran;
        } elseif (!$request->has('tahun_ajaran')) {
            $ajaranAktif = TahunAjaran::aktif();
            if ($ajaranAktif) {
                $query->where('id_ajaran', $ajaranAktif->id_ajaran);
                $ajaranUntukKartu = $ajaranAktif->id_ajaran;
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_prestasi', 'like', "%{$search}%")
                    ->orWhereHas('siswa', fn ($qq) => $qq->where('nama', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('asal')) {
            $query->where('asal', $request->asal);
        }

        if ($request->filled('jenis_penyelenggara')) {
            $query->where('jenis_penyelenggara', $request->jenis_penyelenggara);
        }

        if ($request->filled('puspresnas')) {
            $query->where('terhubung_puspresnas', $request->puspresnas === 'ya');
        }

        switch ($request->get('sort', 'terbaru')) {
            case 'terlama':
                $query->orderBy('tanggal', 'asc');
                break;
            case 'nama_az':
                $query->orderBy('nama_prestasi', 'asc');
                break;
            case 'nama_za':
                $query->orderBy('nama_prestasi', 'desc');
                break;
            case 'siswa_az':
                $query->join('siswa', 'prestasi.id_siswa', '=', 'siswa.id_siswa')
                      ->orderBy('siswa.nama', 'asc')
                      ->select('prestasi.*');
                break;
            case 'terbaru':
            default:
                if ($request->filled('status')) {
                    $query->orderBy('tanggal', 'desc');
                }
                break;
        }

        $prestasi = $query->paginate(10)->withQueryString();
        $daftarAjaran = TahunAjaran::orderByDesc('tahun')->get();

        $kartuQuery = Prestasi::query();
        if ($ajaranUntukKartu) {
            $kartuQuery->where('id_ajaran', $ajaranUntukKartu);
        }
        $totalMenunggu = (clone $kartuQuery)->where('status', 'Belum')->count();
        $totalDisetujui = (clone $kartuQuery)->where('status', 'Disetujui')->count();
        $totalDitolak = (clone $kartuQuery)->where('status', 'Ditolak')->count();

        return view('kesiswaan.prestasi.index', compact(
            'prestasi', 'daftarAjaran', 'totalMenunggu', 'totalDisetujui', 'totalDitolak'
        ));
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['siswa', 'tahunAjaran', 'sertifikat', 'dokumentasi']);

        return view('kesiswaan.prestasi.show', compact('prestasi'));
    }

    public function verifikasi(Request $request, Prestasi $prestasi)
    {
        // PENTING: "Revisi" WAJIB ada di daftar 'in:' ini, karena tombol
        // "Minta Revisi" di halaman detail ngirim value 'Revisi'. Kalau cuma
        // 'Disetujui,Ditolak' doang, submit-nya ditolak validasi tanpa pesan
        // error yang keliatan di halaman (makanya kelihatan "ngilang" aja).
        $validated = $request->validate([
            'status' => ['required', 'in:Disetujui,Ditolak,Revisi'],
            'kategori' => ['required_if:status,Disetujui', 'nullable', 'in:Akademik,Non Akademik,Kejuaraan'],
            'catatan' => ['required_if:status,Ditolak,Revisi', 'nullable', 'string', 'max:500'],
        ]);

        // "Revisi" disimpan sebagai status Ditolak + flag perlu_revisi,
        // supaya statistik/filter status yang udah ada (Belum/Disetujui/Ditolak) gak perlu diubah.
        $statusDisimpan = $validated['status'] === 'Revisi' ? 'Ditolak' : $validated['status'];
        $perluRevisi = $validated['status'] === 'Revisi';

        $prestasi->update([
            'id_kesiswaan' => auth()->user()->kesiswaan->id_kesiswaan,
            'status' => $statusDisimpan,
            'perlu_revisi' => $perluRevisi,
            'kategori' => $validated['kategori'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
            'tanggal_verifikasi' => now(),
        ]);

        $prestasi->siswa->user->notify(new StatusVerifikasiNotification($prestasi));

        $pesan = match ($validated['status']) {
            'Disetujui' => 'Prestasi berhasil disetujui.',
            'Revisi' => 'Prestasi dikembalikan ke siswa untuk direvisi.',
            default => 'Prestasi berhasil ditolak.',
        };

        return redirect()->route('kesiswaan.prestasi.show', $prestasi)->with('success', $pesan);
    }
}