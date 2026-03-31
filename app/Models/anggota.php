<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class anggota extends Model
{
    protected $table = 'anggota';

    protected $fillable = [
        'user_id',
        'nis',
        'kelas',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
