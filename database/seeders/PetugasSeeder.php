<?php

namespace Database\Seeders;

use App\Models\Petugas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    /**
     * Seed the application's database with a default admin petugas.
     */
    public function run(): void
    {
        // Create default admin if not exists
        $username = 'admin';
        $password = 'admin123';

        if (!Petugas::where('username', $username)->exists()) {
            Petugas::create([
                'username' => $username,
                'password' => $password, // Simpan sebagai plain text untuk ditampilkan
            ]);
        }

        // Create additional sample petugas
        $samplePetugas = [
            ['username' => 'petugas1', 'password' => 'password123'],
            ['username' => 'petugas2', 'password' => 'password123'],
            ['username' => 'operator', 'password' => 'operator123'],
        ];

        foreach ($samplePetugas as $petugas) {
            if (!Petugas::where('username', $petugas['username'])->exists()) {
                Petugas::create([
                    'username' => $petugas['username'],
                    'password' => $petugas['password'], // Simpan sebagai plain text untuk ditampilkan
                ]);
            }
        }
    }
}


















