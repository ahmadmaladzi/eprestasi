<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function show()
    {
        $kesiswaan = auth()->user()->kesiswaan;

        return view('kesiswaan.profil', compact('kesiswaan'));
    }

    public function update(Request $request)
    {
        $kesiswaan = auth()->user()->kesiswaan;

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        // nip sengaja tidak bisa diedit di sini, sama seperti nis siswa
        // yang juga immutable lewat form profil.
        $kesiswaan->update($validated);

        // Sinkronkan nama & email ke tabel users juga, sama seperti pola di Siswa\ProfilController.
        $kesiswaan->user->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'] ?? $kesiswaan->user->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
