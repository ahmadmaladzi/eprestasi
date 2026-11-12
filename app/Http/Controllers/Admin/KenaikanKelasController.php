<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KenaikanKelasController extends Controller
{
    public function index(Request $request)
    {
        $daftarKelas = Kelas::where('status', 'Aktif')->orderBy('tingkat')->orderBy('nama_kelas')->get();
        $daftarTahunAjaran = TahunAjaran::orderBy('tahun', 'desc')->get();

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

        return view('admin.kenaikan-kelas.index', compact('daftarKelas', 'daftarTahunAjaran', 'kelasAsal', 'siswaDiKelas'));
    }

    public function proses(Request $request)
    {
        $validated = $request->validate([
            'siswa_ids' => ['required', 'array', 'min:1'],
            'siswa_ids.*' => ['exists:siswa,id_siswa'],
            'kelas_asal' => ['required', 'exists:kelas,id_kelas'],
            'tahun_pilihan' => ['required', 'string'],
            'tahun_baru' => ['required_if:tahun_pilihan,NEW', 'nullable', 'string', 'max:20'],
            'tahun_status' => ['required_if:tahun_pilihan,NEW', 'nullable', 'in:Aktif,Tidak Aktif'],
            'kelas_tujuan_default' => ['nullable', 'exists:kelas,id_kelas'],
            'kelas_tujuan_per_siswa' => ['nullable', 'array'],
        ], [
            'siswa_ids.required' => 'Pilih minimal 1 siswa yang mau dipindahkan.',
            'tahun_baru.required_if' => 'Format tahun ajaran baru wajib diisi.',
        ]);

        // Tangani Tahun Ajaran
        if ($validated['tahun_pilihan'] === 'NEW') {
            $tahunAjaran = TahunAjaran::firstOrCreate(
                ['tahun' => $validated['tahun_baru']],
                ['status' => $validated['tahun_status']]
            );

            if ($tahunAjaran->wasRecentlyCreated && $validated['tahun_status'] === 'Aktif') {
                TahunAjaran::where('id_ajaran', '!=', $tahunAjaran->id_ajaran)
                    ->update(['status' => 'Tidak Aktif']);
            }
        } else {
            $tahunAjaran = TahunAjaran::findOrFail($validated['tahun_pilihan']);
        }

        $berhasil = 0;
        $kelasCache = [];

        foreach ($validated['siswa_ids'] as $siswaId) {
            $targetKelasId = $request->input("kelas_tujuan_per_siswa.{$siswaId}") ?: ($validated['kelas_tujuan_default'] ?? null);

            if (! $targetKelasId) {
                continue;
            }

            if (! isset($kelasCache[$targetKelasId])) {
                $kelasCache[$targetKelasId] = Kelas::find($targetKelasId);
            }

            $kelasTujuan = $kelasCache[$targetKelasId];
            if ($kelasTujuan) {
                Siswa::where('id_siswa', $siswaId)->update([
                    'kelas' => $kelasTujuan->nama_kelas,
                    'jurusan' => $kelasTujuan->jurusan,
                ]);
                $berhasil++;
            }
        }

        return redirect()
            ->route('admin.kenaikan-kelas.index', ['kelas_asal' => $validated['kelas_asal']])
            ->with('success', "{$berhasil} siswa berhasil dipindahkan untuk Tahun Ajaran {$tahunAjaran->tahun}.");
    }
}