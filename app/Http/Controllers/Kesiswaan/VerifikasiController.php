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
            // default: tampilkan yang belum diproses dulu
            $query->orderByRaw("FIELD(status, 'Belum', 'Ditolak', 'Disetujui')");
        }

        // Filter by tahun ajaran. Default: tahun ajaran yang sedang Aktif,
        // supaya kesiswaan nggak ke-mix lihat data dari tahun-tahun lama.
        // Pilih "Semua Tahun" (value kosong khusus) untuk lihat semuanya.
        if ($request->has('tahun_ajaran') && $request->tahun_ajaran !== 'semua') {
            $query->where('id_ajaran', $request->tahun_ajaran);
        } elseif (!$request->has('tahun_ajaran')) {
            $ajaranAktif = TahunAjaran::aktif();
            if ($ajaranAktif) {
                $query->where('id_ajaran', $ajaranAktif->id_ajaran);
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

        $prestasi = $query->latest('tanggal')->paginate(10)->withQueryString();
        $daftarAjaran = TahunAjaran::orderByDesc('tahun')->get();

        return view('kesiswaan.prestasi.index', compact('prestasi', 'daftarAjaran'));
    }

    public function show(Prestasi $prestasi)
    {
        $prestasi->load(['siswa', 'tahunAjaran', 'sertifikat', 'dokumentasi']);

        return view('kesiswaan.prestasi.show', compact('prestasi'));
    }

    public function verifikasi(Request $request, Prestasi $prestasi)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Disetujui,Ditolak'],
            'kategori' => ['required_if:status,Disetujui', 'nullable', 'in:Akademik,Non Akademik,Kejuaraan'],
            'catatan' => ['required_if:status,Ditolak', 'nullable', 'string', 'max:500'],
        ]);

        $prestasi->update([
            'id_kesiswaan' => auth()->user()->kesiswaan->id_kesiswaan,
            'status' => $validated['status'],
            'kategori' => $validated['kategori'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
            'tanggal_verifikasi' => now(),
        ]);

        $prestasi->siswa->user->notify(new StatusVerifikasiNotification($prestasi));

        return back()->with('success', "Prestasi berhasil di-{$validated['status']}.");
    }
}