<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            // NOTE: email tidak ada di ERD asli (ERD hanya punya nama, password, role),
            // tapi wajib ditambahkan di sini karena Laravel butuh kolom unik untuk proses
            // login/auth. Email siswa/kesiswaan tetap disimpan juga di tabel masing-masing
            // sesuai ERD, dan disinkronkan otomatis saat akun dibuat.
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'siswa', 'kesiswaan']);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
