<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Siswa extends Model
{
    use SoftDeletes;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'id_user', 'nama', 'nis', 'npsn', 'kelas', 'jurusan', 'email', 'no_hp', 'foto_profil', 'qr_code',
        'status_kelulusan', 'tanggal_lulus',
    ];

    protected $casts = [
        'tanggal_lulus' => 'date',
    ];

    protected static function booted(): void
    {
        // Jaring pengaman: siswa manapun yang dibuat lewat jalur apapun
        // (form Admin, Import Excel, Tinker, dll) SELALU dapat qr_code otomatis
        // kalau belum diisi manual. Ini mencegah error "Missing parameter: qrCode"
        // di halaman profil/portofolio.
        static::creating(function (Siswa $siswa) {
            if (empty($siswa->qr_code)) {
                $siswa->qr_code = Str::slug($siswa->nama ?: 'siswa') . '-' . Str::random(6);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'id_siswa');
    }

    public function prestasiDisetujui()
    {
        return $this->prestasi()->where('status', 'Disetujui');
    }
}