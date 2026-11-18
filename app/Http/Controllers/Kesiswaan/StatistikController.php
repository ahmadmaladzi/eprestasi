<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Exports\PrestasiExport;
use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        $jurusanDipilih = $request->get('jurusan');

        $prestasiQuery = Prestasi::query();

        if (!$tampilkanSemua && $selectedAjaran) {
            $prestasiQuery->where('id_ajaran', $selectedAjaran->id_ajaran);
        }

        if ($jurusanDipilih) {
            $prestasiQuery->whereHas('siswa', fn ($q) => $q->where('jurusan', $jurusanDipilih));
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
            ->when($jurusanDipilih, fn ($q) => $q->where('jurusan', $jurusanDipilih))
            ->having('prestasi_disetujui_count', '>', 0)
            ->orderByDesc('prestasi_disetujui_count')
            ->take(10)
            ->get();

        // Dropdown jurusan: diambil dari jurusan-jurusan yang beneran ada datanya
        $daftarJurusan = Siswa::whereNotNull('jurusan')
            ->select('jurusan')
            ->distinct()
            ->orderBy('jurusan')
            ->pluck('jurusan');

        return view('kesiswaan.statistik', compact(
            'totalPrestasi', 'totalBelum', 'totalDisetujui', 'totalDitolak',
            'perKategori', 'perTingkat', 'leaderboard',
            'semuaTahunAjaran', 'selectedAjaran', 'tampilkanSemua',
            'daftarJurusan', 'jurusanDipilih'
        ));
    }

    /**
     * Unduh daftar prestasi (format Excel) sesuai filter yang aktif di halaman statistik.
     */
    public function export(Request $request)
    {
        $tampilkanSemua = false;
        $selectedAjaran = null;

        if ($request->filled('tahun_ajaran')) {
            if ($request->tahun_ajaran === 'semua') {
                $tampilkanSemua = true;
            } else {
                $selectedAjaran = TahunAjaran::find($request->tahun_ajaran);
            }
        } else {
            $selectedAjaran = TahunAjaran::aktif();
        }

        $jurusanDipilih = $request->get('jurusan');

        $status = $request->get('status', 'Disetujui');
        if (! in_array($status, ['Belum', 'Disetujui', 'Ditolak', 'Semua'], true)) {
            $status = 'Disetujui';
        }

        $query = Prestasi::query()->with([
            'siswa:id_siswa,nama,nis,kelas,jurusan',
            'tahunAjaran:id_ajaran,tahun',
        ]);

        if (! $tampilkanSemua && $selectedAjaran) {
            $query->where('id_ajaran', $selectedAjaran->id_ajaran);
        }

        if ($jurusanDipilih) {
            $query->whereHas('siswa', fn ($q) => $q->where('jurusan', $jurusanDipilih));
        }

        if ($status !== 'Semua') {
            $query->where('status', $status);
        }

        $prestasi = $query->get()
            ->sortBy(fn ($item) => implode('|', [
                $item->siswa?->kelas ?? '',
                $item->siswa?->nama ?? '',
                $item->tanggal?->format('Y-m-d') ?? '',
            ]))
            ->values();

        $periodeText = $tampilkanSemua
            ? 'Semua Tahun Ajaran'
            : 'Tahun Ajaran '.($selectedAjaran?->tahun ?? 'Aktif');

        $subtitle = $periodeText.' · '.($jurusanDipilih ?: 'Semua Jurusan');
        $dicetak = 'Dicetak: '.now()->locale('id')->translatedFormat('d F Y');

        $namaFile = 'Daftar-Prestasi-'
            .($tampilkanSemua ? 'Semua-Tahun' : str_replace('/', '-', $selectedAjaran?->tahun ?? 'Aktif'))
            .($jurusanDipilih ? '-'.str_replace(' ', '-', $jurusanDipilih) : '')
            .'.xlsx';

        return Excel::download(new PrestasiExport($prestasi, $subtitle, $dicetak), $namaFile);
    }
}