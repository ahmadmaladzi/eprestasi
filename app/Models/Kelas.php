<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    protected $fillable = [
        'nama_kelas', 'tingkat', 'jurusan', 'status',
    ];

    // Sementara masih cocokkan berdasarkan teks nama kelas
    // (kolom siswa.kelas masih teks bebas, belum pakai id_kelas)
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas', 'nama_kelas');
    }
}