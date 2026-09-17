<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $semuaTahunAjaran = TahunAjaran::orderByDesc('tahun')->get();

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

        if (!$tampilkanSemua && $selectedAjaran) {
            $prestasiQuery->where('id_ajaran', $selectedAjaran->id_ajaran);
        }

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

        return view('kesiswaan.statistik', compact(
            'totalPrestasi', 'totalBelum', 'totalDisetujui', 'totalDitolak',
            'perKategori', 'perTingkat', 'leaderboard',
            'semuaTahunAjaran', 'selectedAjaran', 'tampilkanSemua'
        ));
    }
}