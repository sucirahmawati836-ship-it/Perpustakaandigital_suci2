<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// IMPORT MODEL
use App\Models\Anggota;
use App\Models\Petugas;
use App\Models\KepalaPerpus;
use App\Models\Peminjaman;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nip_petugas', 
        'nip_kepala',
        
    ];

    protected $hidden = [
        'password',
    ];

    // Relasi
    public function anggota()
    {
        return $this->hasOne(Anggota::class);
    }

    public function petugas()
    {
        return $this->hasOne(Petugas::class);
    }

    public function kepala()
    {
        return $this->hasOne(KepalaPerpus::class);
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}