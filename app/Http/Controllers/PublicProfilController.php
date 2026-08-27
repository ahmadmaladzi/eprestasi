<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PublicProfilController extends Controller
{
    public function show(string $qrCode)
    {
        $siswa = Siswa::where('qr_code', $qrCode)->firstOrFail();

        $prestasi = $siswa->prestasi()
            ->with(['tahunAjaran', 'sertifikat', 'dokumentasi'])
            ->where('status', 'Disetujui')
            ->latest('tanggal')
            ->get();

        $qrImage = QrCode::size(200)->generate(url("/p/{$qrCode}"));

        return view('public.profil', compact('siswa', 'prestasi', 'qrImage'));
    }

    public function generatePdf(string $qrCode)
    {
        $siswa = Siswa::where('qr_code', $qrCode)->firstOrFail();

        $prestasi = $siswa->prestasi()
            ->where('status', 'Disetujui')
            ->latest('tanggal')
            ->get();

        $pdf = Pdf::loadView('public.portofolio-pdf', compact('siswa', 'prestasi'));

        return $pdf->download('Portofolio-' . $siswa->nama . '.pdf');
    }
}
