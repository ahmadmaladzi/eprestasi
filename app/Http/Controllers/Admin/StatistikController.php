<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $semuaTahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

        // Tentukan tahun ajaran yang sedang dilihat:
        // - kalau user pilih spesifik lewat query string, pakai itu
        // - kalau user pilih "semua", jangan filter sama sekali
        // - kalau belum pilih apa-apa, default ke tahun ajaran yang Aktif
        $ajaranAktif = TahunAjaran::aktif();
        $selectedAjaran = null;
        $tampilkanSemua = false;

        if ($request->filled('tahun_ajaran')) {
            if ($request->tahun_ajaran === 'semua') {
                $tampilkanSemua = true;
            } else {
                $selectedAjaran = TahunAjaran::find($request->tahun_ajaran);
            }
        } else {
            $selectedAjaran = $ajaranAktif;
        }

        $prestasiQuery = Prestasi::query();
        $siswaQuery = Siswa::query();

        if (!$tampilkanSemua && $selectedAjaran) {
            $prestasiQuery->where('id_ajaran', $selectedAjaran->id_ajaran);
            // Untuk tahun ajaran terpilih, hitung siswa aktif (kohort siswa).
            $siswaQuery->where('status_kelulusan', 'Aktif');
        }

        $totalSiswa = (clone $siswaQuery)->count();
        $totalPrestasi = (clone $prestasiQuery)->count();
        $totalBelum = (clone $prestasiQuery)->where('status', 'Belum')->count();
        $totalDisetujui = (clone $prestasiQuery)->where('status', 'Disetujui')->count();
        $totalDitolak = (clone $prestasiQuery)->where('status', 'Ditolak')->count();

        $perKategori = (clone $prestasiQuery)->whereNotNull('kategori')
            ->selectRaw('kategori, count(*) as jumlah')
            ->groupBy('kategori')
            ->pluck('jumlah', 'kategori');

        $perTingkat = (clone $prestasiQuery)->selectRaw('tingkat, count(*) as jumlah')
            ->groupBy('tingkat')
            ->pluck('jumlah', 'tingkat');

        $leaderboard = Siswa::withCount(['prestasi as prestasi_disetujui_count' => function ($q) use ($tampilkanSemua, $selectedAjaran) {
            $q->where('status', 'Disetujui');
            if (!$tampilkanSemua && $selectedAjaran) {
                $q->where('id_ajaran', $selectedAjaran->id_ajaran);
            }
        }])
            ->orderByDesc('prestasi_disetujui_count')
            ->take(5)
            ->get();

        // === Widget "Aktivitas Terbaru" ===
        // Gabungin 2 sumber aktivitas (prestasi baru diajukan + akun baru dibuat)
        // jadi 1 timeline, diurutkan dari yang paling baru.
        $aktivitasPrestasi = Prestasi::with('siswa')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($prestasi) {
                return [
                    'icon' => 'prestasi',
                    'judul' => 'Prestasi baru diajukan',
                    'deskripsi' => ($prestasi->siswa->nama ?? 'Siswa') . ' — "' . $prestasi->nama_prestasi . '"',
                    'waktu' => $prestasi->created_at,
                ];
            });

        $aktivitasUser = User::latest()
            ->take(10)
            ->get()
            ->map(function ($user) {
                return [
                    'icon' => 'user',
                    'judul' => 'Akun pengguna baru',
                    'deskripsi' => $user->nama . ' ditambahkan sebagai ' . $user->role,
                    'waktu' => $user->created_at,
                ];
            });

        $aktivitasTerbaru = $aktivitasPrestasi->concat($aktivitasUser)
            ->sortByDesc('waktu')
            ->take(8)
            ->values();

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalPrestasi', 'totalBelum', 'totalDisetujui', 'totalDitolak',
            'perKategori', 'perTingkat', 'leaderboard',
            'semuaTahunAjaran', 'selectedAjaran', 'tampilkanSemua',
            'aktivitasTerbaru'
        ));
    }
}