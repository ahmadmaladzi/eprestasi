<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrestasiRequest;
use App\Models\Dokumentasi;
use App\Models\Prestasi;
use App\Models\Sertifikat;
use App\Models\TahunAjaran;
use App\Models\User;
use App\Notifications\PrestasiBaruDiajukanNotification;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $siswa = auth()->user()->siswa;

        $query = $siswa->prestasi()->with(['tahunAjaran']);

        if ($request->filled('search')) {
            $query->where('nama_prestasi', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('sort')) {
            match ($request->sort) {
                'terlama' => $query->oldest('tanggal'),
                'nama_az' => $query->orderBy('nama_prestasi', 'asc'),
                'nama_za' => $query->orderBy('nama_prestasi', 'desc'),
                default => $query->latest('tanggal'),
            };
        } else {
            $query->latest('tanggal');
        }

        // withQueryString() wajib ada biar filter/sort ikut kebawa
        // pas pindah halaman pagination, bukan ke-reset.
        $prestasi = $query->paginate(10)->withQueryString();

        return view('siswa.prestasi.index', compact('prestasi'));
    }

    public function create()
    {
        $siswa = auth()->user()->siswa;

        if ($siswa->status_kelulusan === 'Keluar') {
            return back()->with('error', 'Anda tidak dapat mengajukan prestasi. Akun Anda berstatus Keluar.');
        }

        $ajaranAktif = TahunAjaran::aktif();

        if (!$ajaranAktif) {
            return back()->with('error', 'Belum ada tahun ajaran aktif. Hubungi admin.');
        }

        return view('siswa.prestasi.create', compact('ajaranAktif'));
    }

    public function store(PrestasiRequest $request)
    {
        $siswa = auth()->user()->siswa;
        $ajaranAktif = TahunAjaran::aktif();

        if (!$ajaranAktif) {
            return back()->with('error', 'Belum ada tahun ajaran aktif. Hubungi admin.');
        }

        $prestasi = Prestasi::create([
            'id_siswa' => $siswa->id_siswa,
            'id_ajaran' => $ajaranAktif->id_ajaran,
            'nama_prestasi' => $request->nama_prestasi,
            'penyelenggara' => $request->penyelenggara,
            'tingkat' => $request->tingkat,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'status' => 'Belum',
            'asal' => $request->asal ?? 'Dalam Negeri',
            'jenis_penyelenggara' => $request->jenis_penyelenggara,
            'terhubung_puspresnas' => $request->boolean('terhubung_puspresnas'),
        ]);

        $this->simpanDokumen($request, $prestasi);

        // Beri tahu semua akun kesiswaan bahwa ada pengajuan baru yang perlu diverifikasi
        $prestasi->load('siswa');
        $semuaKesiswaan = User::where('role', 'kesiswaan')->get();
        foreach ($semuaKesiswaan as $kesiswaan) {
            $kesiswaan->notify(new PrestasiBaruDiajukanNotification($prestasi));
        }

        return redirect()->route('siswa.prestasi.index')
            ->with('success', 'Prestasi berhasil diajukan, menunggu verifikasi kesiswaan.');
    }

    public function show(Prestasi $prestasi)
    {
        $this->authorizeSiswa($prestasi);
        $prestasi->load(['tahunAjaran', 'sertifikat', 'dokumentasi', 'kesiswaan']);

        return view('siswa.prestasi.show', compact('prestasi'));
    }

    public function edit(Prestasi $prestasi)
    {
        $this->authorizeSiswa($prestasi);
        $siswa = auth()->user()->siswa;

        if ($siswa->status_kelulusan === 'Keluar') {
            return back()->with('error', 'Anda tidak dapat mengedit prestasi. Akun Anda berstatus Keluar.');
        }

        if ($prestasi->status === 'Disetujui') {
            return back()->with('error', 'Prestasi yang sudah disetujui tidak bisa diedit.');
        }

        return view('siswa.prestasi.edit', compact('prestasi'));
    }

    public function update(PrestasiRequest $request, Prestasi $prestasi)
    {
        $this->authorizeSiswa($prestasi);

        $prestasi->update($request->only([
            'nama_prestasi', 'penyelenggara', 'tingkat', 'tanggal', 'deskripsi',
            'asal', 'jenis_penyelenggara',
        ]));
        $prestasi->update(['terhubung_puspresnas' => $request->boolean('terhubung_puspresnas')]);

        $this->simpanDokumen($request, $prestasi);

        // Kalau sebelumnya ditolak & direvisi, ajukan ulang jadi "Belum"
        if ($prestasi->status === 'Ditolak') {
            $prestasi->update(['status' => 'Belum', 'catatan' => null]);

            // Beri tahu kesiswaan juga kalau ada pengajuan yang direvisi & diajukan ulang
            $prestasi->load('siswa');
            $semuaKesiswaan = User::where('role', 'kesiswaan')->get();
            foreach ($semuaKesiswaan as $kesiswaan) {
                $kesiswaan->notify(new PrestasiBaruDiajukanNotification($prestasi));
            }
        }

        return redirect()->route('siswa.prestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui dan diajukan ulang.');
    }

    public function destroy(Prestasi $prestasi)
    {
        $this->authorizeSiswa($prestasi);
        $prestasi->delete();

        return back()->with('success', 'Prestasi berhasil dihapus.');
    }

    private function simpanDokumen(PrestasiRequest $request, Prestasi $prestasi): void
    {
        if ($request->hasFile('sertifikat')) {
            $file = $request->file('sertifikat');
            $path = $file->store('sertifikat', 'public');

            Sertifikat::create([
                'id_prestasi' => $prestasi->id_prestasi,
                'nama_file' => $file->getClientOriginalName(),
                'ukuran_file' => round($file->getSize() / 1024), // KB
                'deskripsi' => $request->sertifikat_deskripsi,
                'file_path' => $path,
            ]);
        }

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('dokumentasi', 'public');

            Dokumentasi::create([
                'id_prestasi' => $prestasi->id_prestasi,
                'foto' => $path,
                'caption' => $request->caption,
                'tanggal_dibuat' => now(),
            ]);
        }
    }

    private function authorizeSiswa(Prestasi $prestasi): void
    {
        if ($prestasi->id_siswa !== auth()->user()->siswa->id_siswa) {
            abort(403);
        }
    }
}