<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use SoftDeletes;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    protected $fillable = [
        'id_user', 'nama', 'nis', 'kelas', 'jurusan', 'email', 'no_hp', 'foto_profil', 'qr_code',
    ];

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
