<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::withCount('siswa');

        if ($request->filled('search')) {
            $query->where('nama_kelas', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        $daftarKelas = $query->orderBy('tingkat')->orderBy('nama_kelas')->paginate(15)->withQueryString();

        return view('admin.kelas.index', compact('daftarKelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:100', 'unique:kelas,nama_kelas'],
            'tingkat' => ['required', 'in:10,11,12'],
            'jurusan' => ['required', 'string', 'max:50'],
        ]);

        Kelas::create($validated);

        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, Kelas $kela)
    {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:100', 'unique:kelas,nama_kelas,' . $kela->id_kelas . ',id_kelas'],
            'tingkat' => ['required', 'in:10,11,12'],
            'jurusan' => ['required', 'string', 'max:50'],
        ]);

        $kela->update($validated);

        return back()->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function toggleStatus(Kelas $kela)
    {
        $kela->status = $kela->status === 'Aktif' ? 'Nonaktif' : 'Aktif';
        $kela->save();

        return back()->with('success', 'Status kelas berhasil diubah.');
    }

    public function show(Kelas $kela, Request $request)
    {
        $query = $kela->siswa();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
        }

        $siswa = $query->orderBy('nama')->paginate(20)->withQueryString();

        return view('admin.kelas.show', compact('kela', 'siswa'));
    }

    public function destroy(Kelas $kela)
    {
        if ($kela->siswa()->count() > 0) {
            return back()->with('error', 'Kelas tidak bisa dihapus karena masih ada siswa terdaftar di kelas ini. Nonaktifkan saja kelasnya.');
        }

        $kela->delete();

        return back()->with('success', 'Kelas berhasil dihapus.');
    }
}