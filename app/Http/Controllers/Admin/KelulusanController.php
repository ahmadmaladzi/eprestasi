<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KelulusanController extends Controller
{
    // Halaman "Tandai Kelulusan": daftar siswa yang masih Aktif
    public function index(Request $request)
    {
        $query = Siswa::where('status_kelulusan', 'Aktif');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'nama_za' => $query->orderBy('nama', 'desc'),
                'kelas' => $query->orderBy('kelas', 'asc'),
                default => $query->orderBy('nama', 'asc'),
            };
        } else {
            $query->orderBy('nama', 'asc');
        }

        // Per halaman dinaikin ke 50 (bukan 15) supaya 1 kelas biasanya muat
        // sekaligus di 1 halaman, jadi "pilih semua" beneran kepake buat 1 kelas penuh.
        $siswaAktif = $query->paginate(50)->withQueryString();

        // Daftar kelas unik (dari siswa yang masih aktif) buat isi dropdown filter
        $daftarKelas = Siswa::where('status_kelulusan', 'Aktif')
            ->whereNotNull('kelas')
            ->select('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('admin.kelulusan.index', compact('siswaAktif', 'daftarKelas'));
    }

    public function tandaiLulus(Request $request, Siswa $siswa)
    {
        $siswa->update([
            'status_kelulusan' => 'Lulus',
            'tanggal_lulus' => now(),
        ]);

        return back()->with('success', $siswa->nama . ' berhasil ditandai lulus.');
    }

    // Tandai lulus untuk siswa yang dicentang lewat checkbox (bisa 1, bisa banyak, bisa semua).
    public function tandaiLulusBulk(Request $request)
    {
        $validated = $request->validate([
            'siswa_ids' => ['required', 'array', 'min:1'],
            'siswa_ids.*' => ['integer', 'exists:siswa,id_siswa'],
        ], [
            'siswa_ids.required' => 'Pilih minimal 1 siswa dulu.',
        ]);

        $jumlah = Siswa::whereIn('id_siswa', $validated['siswa_ids'])
            ->where('status_kelulusan', 'Aktif')
            ->update([
                'status_kelulusan' => 'Lulus',
                'tanggal_lulus' => now(),
            ]);

        return back()->with('success', $jumlah . ' siswa berhasil ditandai lulus.');
    }

    public function batalkanLulus(Siswa $siswa)
    {
        $siswa->update([
            'status_kelulusan' => 'Aktif',
            'tanggal_lulus' => null,
        ]);

        return back()->with('success', 'Status kelulusan dibatalkan.');
    }

    // Halaman "Data Alumni": daftar siswa yang sudah Lulus
    public function alumni(Request $request)
    {
        $query = Siswa::where('status_kelulusan', 'Lulus');

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_lulus', $request->tahun);
        }

        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'nama_za' => $query->orderBy('nama', 'desc'),
                'terlama' => $query->orderBy('tanggal_lulus', 'asc'),
                default => $query->orderBy('tanggal_lulus', 'desc'),
            };
        } else {
            $query->orderBy('tanggal_lulus', 'desc');
        }

        $alumni = $query->paginate(15)->withQueryString();

        // Dropdown tahun lulus: diambil dari tahun-tahun yang beneran ada datanya
        $daftarTahun = Siswa::where('status_kelulusan', 'Lulus')
            ->whereNotNull('tanggal_lulus')
            ->selectRaw('YEAR(tanggal_lulus) as tahun')
            ->distinct()
            ->orderByDesc('tahun')
            ->pluck('tahun');

        // Dropdown kelas: diambil dari kelas-kelas alumni yang beneran ada datanya
        $daftarKelas = Siswa::where('status_kelulusan', 'Lulus')
            ->whereNotNull('kelas')
            ->select('kelas')
            ->distinct()
            ->orderBy('kelas')
            ->pluck('kelas');

        return view('admin.kelulusan.alumni', compact('alumni', 'daftarTahun', 'daftarKelas'));
    }
}