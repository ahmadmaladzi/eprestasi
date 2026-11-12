<?php

use App\Http\Controllers\Admin\StatistikController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\KelulusanController;
use App\Http\Controllers\Admin\KenaikanKelasController;
use App\Http\Controllers\Admin\TahunAjaranController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Kesiswaan\DashboardController as KesiswaanDashboardController;
use App\Http\Controllers\Kesiswaan\ProfilController as KesiswaanProfilController;
use App\Http\Controllers\Kesiswaan\StatistikController as KesiswaanStatistikController;
use App\Http\Controllers\Kesiswaan\VerifikasiController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PublicProfilController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\PrestasiController;
use App\Http\Controllers\Siswa\ProfilController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return match (auth()->user()->role) {
        'siswa' => redirect()->route('siswa.dashboard'),
        'kesiswaan' => redirect()->route('kesiswaan.dashboard'),
        'admin' => redirect()->route('admin.dashboard'),
        default => redirect('/'),
    };
})->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/akun/ganti-password', [PasswordController::class, 'edit'])->name('akunpassword.edit');
    Route::put('/akun/ganti-password', [PasswordController::class, 'update'])->name('akunpassword.update');

    // Notifikasi (dipakai lintas role: siswa & kesiswaan)
    Route::post('/notifikasi/{id}/baca', [NotifikasiController::class, 'tandaiBaca'])->name('notifikasi.baca');
    Route::post('/notifikasi/baca-semua', [NotifikasiController::class, 'tandaiSemuaBaca'])->name('notifikasi.baca-semua');
});

// ==== SISWA ====
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profil', [ProfilController::class, 'show'])->name('profil');
    Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');

    Route::resource('prestasi', PrestasiController::class);

    // "Lihat Portofolio" khusus siswa yang login (lihat versi publik miliknya sendiri)
    Route::get('/portofolio', function () {
        $qrCode = auth()->user()->siswa->qr_code;
        return $qrCode
            ? redirect()->route('public.profil', ['qrCode' => $qrCode, 'owner' => 1])
            : back()->with('error', 'Lengkapi profil kamu dulu untuk membuat portofolio.');
    })->name('portofolio');
});

// ==== KESISWAAN ====
Route::middleware(['auth', 'role:kesiswaan'])->prefix('kesiswaan')->name('kesiswaan.')->group(function () {
    Route::get('/dashboard', [KesiswaanDashboardController::class, 'index'])->name('dashboard');

    Route::get('/statistik', [KesiswaanStatistikController::class, 'index'])->name('statistik');
    Route::get('/profil', [KesiswaanProfilController::class, 'show'])->name('profil');
    Route::put('/profil', [KesiswaanProfilController::class, 'update'])->name('profil.update');

    Route::get('/prestasi', [VerifikasiController::class, 'index'])->name('prestasi.index');
    Route::get('/prestasi/{prestasi}', [VerifikasiController::class, 'show'])->name('prestasi.show');
    Route::post('/prestasi/{prestasi}/verifikasi', [VerifikasiController::class, 'verifikasi'])->name('prestasi.verifikasi');
});

// ==== ADMIN ====
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [StatistikController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/import', [UserController::class, 'importForm'])->name('users.import.form');
    Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');

    Route::get('/tahun-ajaran', [TahunAjaranController::class, 'index'])->name('ajaran.index');
    Route::put('/tahun-ajaran/{ajaran}', [TahunAjaranController::class, 'update'])->name('ajaran.update');
    Route::delete('/tahun-ajaran/{ajaran}', [TahunAjaranController::class, 'destroy'])->name('ajaran.destroy');

    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/{kela}', [KelasController::class, 'show'])->name('kelas.show');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::put('/kelas/{kela}', [KelasController::class, 'update'])->name('kelas.update');
    Route::put('/kelas/{kela}/toggle', [KelasController::class, 'toggleStatus'])->name('kelas.toggle');
    Route::delete('/kelas/{kela}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    Route::get('/kelulusan', [KelulusanController::class, 'index'])->name('kelulusan.index');
    Route::put('/kelulusan/{siswa}/tandai', [KelulusanController::class, 'tandaiLulus'])->name('kelulusan.tandai');
    Route::post('/kelulusan/{siswa}/keluarkan', [KelulusanController::class, 'keluarkan'])->name('kelulusan.keluarkan');
    Route::post('/kelulusan/tandai-bulk', [KelulusanController::class, 'tandaiLulusBulk'])->name('kelulusan.tandai-bulk');
    Route::put('/kelulusan/{siswa}/batalkan', [KelulusanController::class, 'batalkanLulus'])->name('kelulusan.batalkan');
    Route::get('/alumni', [KelulusanController::class, 'alumni'])->name('kelulusan.alumni');

    Route::get('/kenaikan-kelas', [KenaikanKelasController::class, 'index'])->name('kenaikan-kelas.index');
    Route::post('/kenaikan-kelas/proses', [KenaikanKelasController::class, 'proses'])->name('kenaikan-kelas.proses');
});

// ==== PUBLIK (akses via scan QR Code, tanpa login) ====
Route::get('/p/{qrCode}', [PublicProfilController::class, 'show'])->name('public.profil');
Route::get('/p/{qrCode}/pdf', [PublicProfilController::class, 'generatePdf'])->name('public.profil.pdf');