<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function show()
    {
        $siswa = auth()->user()->siswa;

        return view('siswa.profil', compact('siswa'));
    }

    public function update(Request $request)
    {
        $siswa = auth()->user()->siswa;

        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:siswa,email,' . $siswa->id_siswa . ',id_siswa'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $fotoPath = $siswa->foto_profil;

        if ($request->hasFile('foto_profil')) {
            if ($siswa->foto_profil) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }
            $fotoPath = $request->file('foto_profil')->store('siswa/foto', 'public');
        }

        $siswa->update([
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] ?? null,
            'foto_profil' => $fotoPath,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}