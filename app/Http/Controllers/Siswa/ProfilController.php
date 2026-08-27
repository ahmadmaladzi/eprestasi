<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
            'nama' => ['required', 'string', 'max:255'],
            'kelas' => ['required', 'string', 'max:20'],
            'jurusan' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        if ($request->hasFile('foto_profil')) {
            $validated['foto_profil'] = $request->file('foto_profil')->store('foto-profil', 'public');
        }

        // qr_code di-generate sekali saat pertama kali isi profil (kalau belum ada)
        if (!$siswa->qr_code) {
            $validated['qr_code'] = Str::slug($validated['nama']) . '-' . $siswa->id_siswa;
        }

        $siswa->update($validated);

        // Sinkronkan nama & email ke tabel users juga
        $siswa->user->update([
            'nama' => $validated['nama'],
            'email' => $validated['email'] ?? $siswa->user->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
