<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['nama' => 'Lomba Kemerdekaan', 'deskripsi' => 'Kegiatan lomba dalam rangka kemerdekaan RI', 'status' => 'aktif'],
            ['nama' => 'Classmeet', 'deskripsi' => 'Kegiatan classmeet antar kelas', 'status' => 'aktif'],
            ['nama' => 'P5', 'deskripsi' => 'Proyek Penguatan Profil Pelajar Pancasila', 'status' => 'aktif'],
            ['nama' => 'Moontour', 'deskripsi' => 'Kegiatan study tour dan kunjungan', 'status' => 'aktif'],
            ['nama' => 'Pensi', 'deskripsi' => 'Pentas seni dan budaya sekolah', 'status' => 'aktif'],
            ['nama' => 'Ekstrakurikuler', 'deskripsi' => 'Kegiatan ekstrakurikuler siswa', 'status' => 'aktif'],
            ['nama' => 'Prestasi & Penghargaan', 'deskripsi' => 'Prestasi dan penghargaan siswa dan sekolah', 'status' => 'aktif'],
            ['nama' => 'Lainnya', 'deskripsi' => 'Kategori umum lainnya', 'status' => 'aktif'],
        ];

        foreach ($categories as $category) {
            Kategori::firstOrCreate(
                ['nama' => $category['nama']],
                ['deskripsi' => $category['deskripsi'], 'status' => $category['status']]
            );
        }
    }
}
