<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfilController extends Controller
{
    public function show()
    {
        $siswa = auth()->user()->siswa;

        // Jaring pengaman tambahan: kalau qr_code masih kosong
        // (data lama sebelum auto-generate dipasang di model), generate sekarang.
        if (empty($siswa->qr_code)) {
            $siswa->update([
                'qr_code' => Str::slug($siswa->nama ?: 'siswa') . '-' . Str::random(6),
            ]);
        }

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
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($siswa->foto_profil) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }
            $validated['foto_profil'] = $request->file('foto_profil')->store('siswa/foto', 'public');
        }

        $siswa->update([
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'] ?? null,
            'foto_profil' => $validated['foto_profil'] ?? $siswa->foto_profil,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}