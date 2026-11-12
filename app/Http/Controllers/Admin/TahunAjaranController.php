<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        $query = TahunAjaran::query();

        if ($request->filled('search')) {
            $query->where('tahun', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $daftarAjaran = $query->latest()->paginate(10)->withQueryString();

        $totalAjaran = TahunAjaran::count();
        $totalAktif = TahunAjaran::where('status', 'Aktif')->count();
        $totalPrestasiKeseluruhan = TahunAjaran::withCount('prestasi')->get()->sum('prestasi_count');

        return view('admin.ajaran.index', compact('daftarAjaran', 'totalAjaran', 'totalAktif', 'totalPrestasiKeseluruhan'));
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