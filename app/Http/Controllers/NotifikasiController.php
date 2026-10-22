<?php

namespace App\Http\Controllers;

class NotifikasiController extends Controller
{
    // Klik 1 notifikasi: tandai dibaca, lalu arahkan ke detail prestasi terkait (kalau ada)
    public function tandaiBaca(string $id)
    {
        $user = auth()->user();
        $notifikasi = $user->notifications()->findOrFail($id);
        $notifikasi->markAsRead();

        $prestasiId = $notifikasi->data['prestasi_id'] ?? null;

        if ($prestasiId && $user->isSiswa()) {
            return redirect()->route('siswa.prestasi.show', $prestasiId);
        }

        if ($prestasiId && $user->isKesiswaan()) {
            return redirect()->route('kesiswaan.prestasi.show', $prestasiId);
        }

        return back();
    }

    // Tombol "Tandai semua dibaca"
    public function tandaiSemuaBaca()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back();
    }
}