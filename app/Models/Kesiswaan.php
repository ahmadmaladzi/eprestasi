<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kesiswaan extends Model
{
    use SoftDeletes;

    protected $table = 'kesiswaan';
    protected $primaryKey = 'id_kesiswaan';

    protected $fillable = ['id_user', 'nama', 'nip', 'jabatan', 'no_hp', 'email'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function prestasiDiverifikasi()
    {
        return $this->hasMany(Prestasi::class, 'id_kesiswaan');
    }
}
