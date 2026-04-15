<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaPerpus extends Model
{
    protected $table = 'kepala_perpus';

    protected $fillable = [
        'user_id',
        'nip_kepala',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
