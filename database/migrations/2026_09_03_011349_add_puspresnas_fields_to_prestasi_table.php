<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Apakah prestasi ini terhubung/terdaftar di Puspresnas (Pusat Prestasi Nasional)
            $table->boolean('terhubung_puspresnas')->default(false)->after('kategori');
            // Asal kompetisi: dalam negeri atau luar negeri
            $table->enum('asal', ['Dalam Negeri', 'Luar Negeri'])->default('Dalam Negeri')->after('terhubung_puspresnas');
            // Jenis penyelenggara: Kementerian (pemerintah) atau Non Kementerian (swasta)
            $table->enum('jenis_penyelenggara', ['Kementerian', 'Non Kementerian'])->nullable()->after('asal');
        });
    }

    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn(['terhubung_puspresnas', 'asal', 'jenis_penyelenggara']);
        });
    }
};