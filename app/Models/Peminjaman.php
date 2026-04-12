<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Buku;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
    'user_id',
    'buku_id',
    'tanggal_pinjam',
    'tanggal_kembali',
    'tanggal_jatuh_tempo',
    'status',
    'denda',
    'jenis_denda',
    'status_denda',
    'metode_pembayaran',
    'tanggal_bayar',
    'alasan_penolakan',
];
    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke buku
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}