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

        // PENTING: hanya field data pribadi yang boleh diubah siswa.
        // nama, nis, kelas, jurusan TIDAK divalidasi/diupdate di sini sama sekali,
        // supaya walaupun ada yang coba kirim data itu lewat request manual, tetap diabaikan.
        $validated = $request->validate([
            'email' => ['required', 'email', 'unique:siswa,email,' . $siswa->id_siswa . ',id_siswa'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('siswa/foto', 'public');
        }

        $siswa->update([
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] ?? null,
            'foto' => $validated['foto'] ?? $siswa->foto,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}