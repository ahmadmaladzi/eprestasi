<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class KenaikanKelasController extends Controller
{
    public function index(Request $request)
    {
        $daftarKelas = Kelas::where('status', 'Aktif')->orderBy('tingkat')->orderBy('nama_kelas')->get();

        $kelasAsal = null;
        $siswaDiKelas = collect();

        if ($request->filled('kelas_asal')) {
            $kelasAsal = Kelas::find($request->kelas_asal);
            if ($kelasAsal) {
                $siswaDiKelas = Siswa::where('kelas', $kelasAsal->nama_kelas)
                    ->where('status_kelulusan', 'Aktif')
                    ->orderBy('nama')
                    ->get();
            }
        }

        return view('admin.kenaikan-kelas.index', compact('daftarKelas', 'kelasAsal', 'siswaDiKelas'));
    }

    public function proses(Request $request)
    {
        $validated = $request->validate([
            'siswa_ids' => ['required', 'array', 'min:1'],
            'siswa_ids.*' => ['exists:siswa,id_siswa'],
            'kelas_tujuan' => ['required', 'exists:kelas,id_kelas'],
            'kelas_asal' => ['required', 'exists:kelas,id_kelas'],
        ], [
            'siswa_ids.required' => 'Pilih minimal 1 siswa yang mau dipindahkan.',
        ]);

        $kelasTujuan = Kelas::findOrFail($validated['kelas_tujuan']);

        $jumlah = Siswa::whereIn('id_siswa', $validated['siswa_ids'])
            ->update(['kelas' => $kelasTujuan->nama_kelas, 'jurusan' => $kelasTujuan->jurusan]);

        return redirect()
            ->route('admin.kenaikan-kelas.index', ['kelas_asal' => $validated['kelas_asal']])
            ->with('success', "{$jumlah} siswa berhasil dipindahkan ke kelas {$kelasTujuan->nama_kelas}.");
    }
}