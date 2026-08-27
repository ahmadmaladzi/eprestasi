<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('id_prestasi');
            $table->foreignId('id_siswa')->constrained('siswa', 'id_siswa')->onDelete('cascade');
            $table->foreignId('id_ajaran')->constrained('tahun_ajaran', 'id_ajaran');
            // id_kesiswaan diisi otomatis dengan akun kesiswaan yang memverifikasi (nullable selama masih "Belum")
            $table->foreignId('id_kesiswaan')->nullable()->constrained('kesiswaan', 'id_kesiswaan')->onDelete('set null');
            $table->string('nama_prestasi');
            $table->date('tanggal');
            $table->string('penyelenggara');
            $table->enum('tingkat', ['Sekolah', 'Kabupaten/Kota', 'Provinsi', 'Nasional', 'Internasional']);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Belum', 'Disetujui', 'Ditolak'])->default('Belum');
            // Kategori ditentukan/dikonfirmasi oleh kesiswaan saat menyetujui (lihat use case: Setuju -> kategori)
            $table->enum('kategori', ['Akademik', 'Non Akademik', 'Kejuaraan'])->nullable();
            // catatan diisi kesiswaan saat menolak (lihat use case: Tolak -> catatan)
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_verifikasi')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
