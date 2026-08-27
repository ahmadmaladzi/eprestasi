<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('nama');
            $table->string('nis')->unique();
            $table->string('kelas');
            $table->string('jurusan');
            $table->string('email')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('foto_profil')->nullable();
            // qr_code menyimpan slug unik yang dipakai untuk URL publik (/p/{qr_code})
            // dan menjadi sumber untuk generate gambar QR-nya (di-generate on the fly, bukan disimpan sebagai gambar)
            $table->string('qr_code')->unique()->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
