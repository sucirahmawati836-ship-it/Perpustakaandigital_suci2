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
        User::updateOrCreate(
            ['email' => 'miska@gmail.com'],
            [
                'name' => 'Kepala Perpustakaan',
                'password' => Hash::make('123456'),
                'role' => 'kepala',
            ]
        );

        // ================= PETUGAS =================
        User::updateOrCreate(
            ['email' => 'sucirahmawati836@gmail.com'],
            [
                'name' => 'Petugas Perpustakaan',
                'password' => Hash::make('123456'),
                'role' => 'petugas',
            ]
        );
    }
}