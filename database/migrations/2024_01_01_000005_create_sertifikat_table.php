<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sertifikat', function (Blueprint $table) {
            $table->id('id_sertifikat');
            $table->foreignId('id_prestasi')->constrained('prestasi', 'id_prestasi')->onDelete('cascade');
            $table->string('nama_file');
            $table->unsignedInteger('ukuran_file')->comment('ukuran dalam KB');
            $table->text('deskripsi')->nullable();
            // file_path dibutuhkan secara teknis untuk menyimpan lokasi file di storage
            // (ERD tidak mencantumkan ini secara eksplisit, tapi wajib ada agar file bisa diakses)
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat');
    }
};
