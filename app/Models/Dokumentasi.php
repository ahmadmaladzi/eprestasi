<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    protected $table = 'dokumentasi';
    protected $primaryKey = 'id_dokumentasi';

    protected $fillable = ['id_prestasi', 'foto', 'caption', 'tanggal_dibuat'];

    protected function casts(): array
    {
        return ['tanggal_dibuat' => 'date'];
    }

    public function prestasi()
    {
        return $this->belongsTo(Prestasi::class, 'id_prestasi');
    }
}
