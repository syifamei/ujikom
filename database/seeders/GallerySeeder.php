<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleries = [
            [
                'title' => 'Upacara Bendera Senin',
                'description' => 'Upacara bendera rutin setiap hari Senin di lapangan sekolah',
                'image_path' => 'gallery/upacara-senin.jpg',
                'category' => 'kegiatan',
                'uploaded_by' => null
            ],
            [
                'title' => 'Kegiatan Olahraga',
                'description' => 'Kegiatan olahraga rutin siswa di lapangan sekolah',
                'image_path' => 'gallery/olahraga.jpg',
                'category' => 'kegiatan',
                'uploaded_by' => null
            ],
            [
                'title' => 'Kegiatan Pramuka',
                'description' => 'Kegiatan ekstrakurikuler pramuka setiap hari Sabtu',
                'image_path' => 'gallery/pramuka.jpg',
                'category' => 'kegiatan',
                'uploaded_by' => null
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler',
                'description' => 'Berbagai kegiatan ekstrakurikuler yang diikuti siswa',
                'image_path' => 'gallery/ekstrakurikuler.jpg',
                'category' => 'kegiatan',
                'uploaded_by' => null
            ],
            [
                'title' => 'Juara 1 Lomba Matematika',
                'description' => 'Siswa berhasil meraih juara 1 lomba matematika tingkat kabupaten',
                'image_path' => 'gallery/juara-matematika.jpg',
                'category' => 'prestasi',
                'uploaded_by' => null
            ],
            [
                'title' => 'Juara 2 Basket Putra',
                'description' => 'Tim basket putra meraih juara 2 turnamen antar sekolah',
                'image_path' => 'gallery/juara-basket.jpg',
                'category' => 'prestasi',
                'uploaded_by' => null
            ],
            [
                'title' => 'Juara 3 Debat Bahasa Inggris',
                'description' => 'Tim debat bahasa Inggris meraih juara 3 tingkat provinsi',
                'image_path' => 'gallery/juara-debat.jpg',
                'category' => 'prestasi',
                'uploaded_by' => null
            ],
            [
                'title' => 'Prestasi Siswa',
                'description' => 'Berbagai prestasi yang diraih siswa di berbagai bidang',
                'image_path' => 'gallery/prestasi-siswa.jpg',
                'category' => 'prestasi',
                'uploaded_by' => null
            ],
            [
                'title' => 'Proyek P5 Lingkungan',
                'description' => 'Proyek Penguatan Profil Pelajar Pancasila tentang lingkungan',
                'image_path' => 'gallery/p5-lingkungan.jpg',
                'category' => 'p5',
                'uploaded_by' => null
            ],
            [
                'title' => 'P5 Kewirausahaan',
                'description' => 'Proyek P5 tentang kewirausahaan dan ekonomi kreatif',
                'image_path' => 'gallery/p5-kewirausahaan.jpg',
                'category' => 'p5',
                'uploaded_by' => null
            ],
            [
                'title' => 'P5 Kebhinekaan',
                'description' => 'Proyek P5 tentang kebhinekaan dan toleransi',
                'image_path' => 'gallery/p5-kebhinekaan.jpg',
                'category' => 'p5',
                'uploaded_by' => null
            ]
        ];

        foreach ($galleries as $galleryData) {
            Gallery::create($galleryData);
        }
    }
}