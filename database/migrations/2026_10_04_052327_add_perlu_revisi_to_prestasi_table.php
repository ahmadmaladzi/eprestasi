<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Dipakai saat kesiswaan klik "Revisi" (bukan "Tolak" final).
            // Status tetap disimpan "Ditolak" di kolom status (supaya statistik/filter
            // yang udah ada gak perlu diubah), tapi flag ini bedain "revisi" vs "ditolak final".
            $table->boolean('perlu_revisi')->default(false)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn('perlu_revisi');
        });
    }
};