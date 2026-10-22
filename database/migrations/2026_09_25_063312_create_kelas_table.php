<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('id_kelas');
            $table->string('nama_kelas'); // Contoh: "X AKL 1", "XI RPL 2", "XII TKJ 1"
            $table->enum('tingkat', ['10', '11', '12']);
            $table->string('jurusan'); // Kode jurusan sesuai penamaan sekolah (AKL, AK, BR, DKV, MP, MLOG, RPL, TKJ, dst)
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};