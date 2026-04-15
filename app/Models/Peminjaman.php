<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Buku;

class Peminjaman extends Model
{
    use HasFactory;

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
        'kondisi_buku',
        'status_denda',
        'metode_pembayaran',
        'tanggal_bayar',
        'alasan_penolakan',
        'penerima',
    ];

    // BIAR TANGGAL OTOMATIS JADI CARBON
    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'tanggal_jatuh_tempo' => 'datetime',
        'tanggal_bayar' => 'datetime',
    ];

    // ================= RELASI =================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function getDendaAttribute($value)
    {
      return abs($value);
    }
}