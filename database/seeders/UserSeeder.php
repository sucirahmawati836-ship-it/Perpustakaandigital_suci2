<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ================= KEPALA =================
        User::create([
            'name' => 'Kepala Perpustakaan',
            'email' => 'kepala@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'kepala',
        ]);

        // ================= PETUGAS =================
        User::create([
            'name' => 'Petugas Perpustakaan',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('123456'),
            'role' => 'petugas',
        ]);
    }
}