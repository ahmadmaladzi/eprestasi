<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\TahunAjaran;

class DashboardController extends Controller
{
    public function index()
    {
        $ajaranAktif = TahunAjaran::aktif();

        $prestasiQuery = Prestasi::query();
        if ($ajaranAktif) {
            $prestasiQuery->where('id_ajaran', $ajaranAktif->id_ajaran);
        }

        $totalMenunggu = (clone $prestasiQuery)->where('status', 'Belum')->count();
        $totalDisetujui = (clone $prestasiQuery)->where('status', 'Disetujui')->count();
        $totalDitolak = (clone $prestasiQuery)->where('status', 'Ditolak')->count();
        $totalSiswaAktif = Siswa::where('status_kelulusan', 'Aktif')->count();

        // === Widget "Aktivitas Terbaru" ===
        // Gabungin 2 sumber: prestasi baru diajukan siswa + prestasi yang baru diverifikasi,
        // diurutkan dari yang paling baru.
        $aktivitasDiajukan = Prestasi::with('siswa')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($prestasi) {
                return [
                    'icon' => 'diajukan',
                    'judul' => 'Prestasi baru diajukan',
                    'deskripsi' => ($prestasi->siswa->nama ?? 'Siswa') . ' — "' . $prestasi->nama_prestasi . '"',
                    'waktu' => $prestasi->created_at,
                ];
            });

        $aktivitasVerifikasi = Prestasi::with('siswa')
            ->whereNotNull('tanggal_verifikasi')
            ->latest('tanggal_verifikasi')
            ->take(10)
            ->get()
            ->map(function ($prestasi) {
                $judul = match (true) {
                    $prestasi->status === 'Disetujui' => 'Prestasi disetujui',
                    $prestasi->perlu_revisi => 'Prestasi diminta revisi',
                    default => 'Prestasi ditolak',
                };

                return [
                    'icon' => $prestasi->status === 'Disetujui' ? 'disetujui' : 'ditolak',
                    'judul' => $judul,
                    'deskripsi' => ($prestasi->siswa->nama ?? 'Siswa') . ' — "' . $prestasi->nama_prestasi . '"',
                    'waktu' => $prestasi->tanggal_verifikasi,
                ];
            });

        $aktivitasTerbaru = $aktivitasDiajukan->concat($aktivitasVerifikasi)
            ->sortByDesc('waktu')
            ->take(8)
            ->values();

        return view('kesiswaan.dashboard', compact(
            'totalMenunggu', 'totalDisetujui', 'totalDitolak', 'totalSiswaAktif',
            'ajaranAktif', 'aktivitasTerbaru'
        ));
    }
}