<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestasi extends Model
{
    use SoftDeletes;

    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';

    protected $fillable = [
        'id_siswa', 'id_ajaran', 'id_kesiswaan', 'nama_prestasi', 'tanggal',
        'penyelenggara', 'tingkat', 'deskripsi', 'status', 'perlu_revisi', 'kategori',
        'catatan', 'tanggal_verifikasi',
        'terhubung_puspresnas', 'asal', 'jenis_penyelenggara',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'tanggal_verifikasi' => 'datetime',
            'terhubung_puspresnas' => 'boolean',
            'perlu_revisi' => 'boolean',
        ];
    }

    // Label status buat ditampilin: "Revisi" kalau ditolak tapi memang minta direvisi,
    // "Ditolak" kalau ditolak final (perlu_revisi = false).
    public function getLabelStatusAttribute(): string
    {
        if ($this->status === 'Ditolak' && $this->perlu_revisi) {
            return 'Revisi';
        }

        return $this->status;
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class, 'id_ajaran');
    }

    public function kesiswaan()
    {
        return $this->belongsTo(Kesiswaan::class, 'id_kesiswaan');
    }

    public function sertifikat()
    {
        return $this->hasMany(Sertifikat::class, 'id_prestasi');
    }

    public function dokumentasi()
    {
        return $this->hasMany(Dokumentasi::class, 'id_prestasi');
    }
}