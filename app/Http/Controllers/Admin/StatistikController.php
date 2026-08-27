<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;

class StatistikController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalPrestasi = Prestasi::count();
        $totalBelum = Prestasi::where('status', 'Belum')->count();
        $totalDisetujui = Prestasi::where('status', 'Disetujui')->count();
        $totalDitolak = Prestasi::where('status', 'Ditolak')->count();

        $perKategori = Prestasi::whereNotNull('kategori')
            ->selectRaw('kategori, count(*) as jumlah')
            ->groupBy('kategori')
            ->pluck('jumlah', 'kategori');

        $perTingkat = Prestasi::selectRaw('tingkat, count(*) as jumlah')
            ->groupBy('tingkat')
            ->pluck('jumlah', 'tingkat');

        $leaderboard = Siswa::withCount(['prestasi as prestasi_disetujui_count' => function ($q) {
            $q->where('status', 'Disetujui');
        }])
            ->orderByDesc('prestasi_disetujui_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa', 'totalPrestasi', 'totalBelum', 'totalDisetujui', 'totalDitolak',
            'perKategori', 'perTingkat', 'leaderboard'
        ));
    }
}
