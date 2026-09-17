<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $daftarAjaran = TahunAjaran::latest()->paginate(10);

        return view('admin.ajaran.index', compact('daftarAjaran'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tahun' => ['required', 'string', 'max:20', 'unique:tahun_ajaran,tahun'],
            'status' => ['required', 'in:Aktif,Tidak Aktif'],
        ]);

        // Hanya boleh ada 1 tahun ajaran aktif dalam satu waktu
        if ($validated['status'] === 'Aktif') {
            TahunAjaran::where('status', 'Aktif')->update(['status' => 'Tidak Aktif']);
        }

        TahunAjaran::create($validated);

        return back()->with('success', 'Tahun ajaran berhasil ditambahkan.');
    }

    public function update(Request $request, TahunAjaran $ajaran)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Aktif,Tidak Aktif'],
        ]);

        if ($validated['status'] === 'Aktif') {
            TahunAjaran::where('status', 'Aktif')->update(['status' => 'Tidak Aktif']);
        }

        $ajaran->update($validated);

        return back()->with('success', 'Status tahun ajaran berhasil diperbarui.');
    }

    public function destroy(TahunAjaran $ajaran)
    {
        if ($ajaran->prestasi()->exists()) {
            return back()->with('error', 'Tahun ajaran tidak bisa dihapus karena masih dipakai prestasi.');
        }

        $ajaran->delete();

        return back()->with('success', 'Tahun ajaran berhasil dihapus.');
    }
}