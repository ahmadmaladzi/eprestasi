<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    protected $table = 'tahun_ajaran';
    protected $primaryKey = 'id_ajaran';

    protected $fillable = ['tahun', 'status'];

    public function prestasi()
    {
        return $this->hasMany(Prestasi::class, 'id_ajaran');
    }

    public static function aktif()
    {
        return static::where('status', 'Aktif')->first();
    }
}
