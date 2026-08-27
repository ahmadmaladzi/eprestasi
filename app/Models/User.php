<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['nama', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function siswa()
    {
        return $this->hasOne(Siswa::class, 'id_user');
    }

    public function kesiswaan()
    {
        return $this->hasOne(Kesiswaan::class, 'id_user');
    }

    public function isSiswa(): bool
    {
        return $this->role === 'siswa';
    }

    public function isKesiswaan(): bool
    {
        return $this->role === 'kesiswaan';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
