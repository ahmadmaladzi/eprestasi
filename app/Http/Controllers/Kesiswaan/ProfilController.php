<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:kesiswaan,email,'.$kesiswaan->id_kesiswaan.',id_kesiswaan',
                'unique:users,email,'.auth()->id(),
            ],
            'no_hp' => ['nullable', 'string', 'max:20'],
        ]);

        // nip sengaja tidak bisa diedit di sini, sama seperti nis siswa
        // yang juga immutable lewat form profil.
        DB::transaction(function () use ($kesiswaan, $validated) {
            $kesiswaan->update($validated);

            // Sinkronkan nama & email ke tabel users. Email ini yang dipakai
            // untuk login dan menerima kode OTP reset password.
            $kesiswaan->user->update([
                'nama' => $validated['nama'],
                'email' => $validated['email'],
            ]);
        });

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
