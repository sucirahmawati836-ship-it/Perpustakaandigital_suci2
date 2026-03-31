<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kepala_perpus extends Model
{
    protected $table = 'kepala_perpus';

    protected $fillable = [
        'user_id',
        'nip',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
