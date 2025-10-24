<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Foto;

class FotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fotos = [
            [
                'judul' => 'Upacara Bendera',
                'deskripsi' => 'Upacara bendera setiap hari Senin di SMKN 4 Bogor',
                'path' => 'fotos/sample/upacara.jpg',
                'kategori_id' => 8, // Lomba Kemerdekaan
                'status' => 'Aktif'
            ],
            [
                'judul' => 'Kegiatan Pramuka',
                'deskripsi' => 'Kegiatan ekstrakurikuler pramuka yang rutin dilaksanakan',
                'path' => 'fotos/sample/pramuka.jpg',
                'kategori_id' => 1, // Ekstrakurikuler
                'status' => 'Aktif'
            ],
            [
                'judul' => 'Juara Lomba Coding',
                'deskripsi' => 'Siswa SMKN 4 Bogor meraih juara 1 lomba coding tingkat provinsi',
                'path' => 'fotos/sample/coding.jpg',
                'kategori_id' => 2, // Prestasi dan Penghargaan
                'status' => 'Aktif'
            ],
            [
                'judul' => 'Pentas Seni',
                'deskripsi' => 'Pentas seni tahunan yang menampilkan bakat siswa',
                'path' => 'fotos/sample/pensi.jpg',
                'kategori_id' => 3, // Pensi
                'status' => 'Aktif'
            ],
            [
                'judul' => 'Kunjungan Industri',
                'deskripsi' => 'Study tour ke perusahaan teknologi di Jakarta',
                'path' => 'fotos/sample/industri.jpg',
                'kategori_id' => 6, // Moontour
                'status' => 'Aktif'
            ]
        ];

        foreach ($fotos as $foto) {
            Foto::create($foto);
        }

        $this->command->info('Sample foto berhasil dibuat!');
    }
}











































































