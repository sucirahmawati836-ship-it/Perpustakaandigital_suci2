<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class petugas extends Model
{
    protected $table = 'petugas';

    protected $fillable = [
        'user_id',
        'nip_petugas',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}