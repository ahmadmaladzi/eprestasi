<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;

        $totalPrestasi = $siswa->prestasi()->count();
        $totalDisetujui = $siswa->prestasi()->where('status', 'Disetujui')->count();
        $totalMenunggu = $siswa->prestasi()->where('status', 'Belum')->count();
        $totalDitolak = $siswa->prestasi()->where('status', 'Ditolak')->count();

        $prestasiTerbaru = $siswa->prestasi()
            ->with(['tahunAjaran'])
            ->latest('created_at')
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'siswa', 'totalPrestasi', 'totalDisetujui', 'totalMenunggu', 'totalDitolak', 'prestasiTerbaru'
        ));
    }
}