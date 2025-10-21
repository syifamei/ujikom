<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Informasi;
use App\Models\User;

class InformasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user or create one
        $admin = User::first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@smkn4bogor.sch.id',
                'password' => bcrypt('password'),
            ]);
        }

        $informasis = [
            [
                'judul' => 'Penerimaan Peserta Didik Baru (PPDB) 2024/2025',
                'deskripsi' => 'Informasi lengkap mengenai pendaftaran siswa baru untuk tahun ajaran 2024/2025 di SMKN 4 Bogor.',
                'konten' => "SMKN 4 Bogor membuka pendaftaran siswa baru untuk tahun ajaran 2024/2025. Program keahlian yang tersedia:\n\n1. PPLG (Perangkat Lunak dan Gim)\n2. TJKT (Teknik Jaringan Komputer dan Telekomunikasi)\n3. TO (Teknik Otomotif)\n4. TPFL (Teknik Pengelasan dan Fabrikasi Logam)\n\nPersyaratan pendaftaran:\n- Lulusan SMP/MTs atau sederajat\n- Usia maksimal 21 tahun\n- Mengisi formulir pendaftaran\n- Menyerahkan dokumen yang diperlukan\n\nPendaftaran dibuka mulai 1 Januari 2024. Untuk informasi lebih lanjut, silakan hubungi panitia PPDB.",
                'status' => 'Aktif',
                'tanggal_posting' => '2024-01-15',
                'admin_id' => $admin->id,
            ],
            [
                'judul' => 'Kegiatan Praktik Kerja Industri (Prakerin)',
                'deskripsi' => 'Pelaksanaan program Prakerin untuk siswa kelas XI yang akan dilaksanakan di berbagai industri mitra.',
                'konten' => "Program Praktik Kerja Industri (Prakerin) akan dilaksanakan mulai bulan Juni 2024. Prakerin merupakan program wajib bagi siswa kelas XI untuk mendapatkan pengalaman kerja langsung di dunia industri.\n\nLokasi Prakerin:\n- PT. Astra International Tbk\n- PT. Telkom Indonesia\n- PT. Bank Central Asia\n- PT. Indofood Sukses Makmur\n- Dan berbagai industri mitra lainnya\n\nDurasi Prakerin: 3 bulan\n\nSiswa akan didampingi oleh guru pembimbing dan pembimbing dari industri. Setelah Prakerin selesai, siswa wajib membuat laporan dan presentasi hasil Prakerin.",
                'status' => 'Aktif',
                'tanggal_posting' => '2024-01-20',
                'admin_id' => $admin->id,
            ],
            [
                'judul' => 'Kunjungan Industri ke PT. Telkom Indonesia',
                'deskripsi' => 'Kunjungan edukatif siswa jurusan TJKT ke PT. Telkom Indonesia untuk melihat infrastruktur telekomunikasi.',
                'konten' => "Siswa jurusan TJKT (Teknik Jaringan Komputer dan Telekomunikasi) akan melakukan kunjungan industri ke PT. Telkom Indonesia pada tanggal 25 Februari 2024.\n\nAgenda kunjungan:\n- Pengenalan infrastruktur telekomunikasi\n- Demonstrasi teknologi jaringan\n- Diskusi dengan praktisi industri\n- Kunjungan ke data center\n\nKunjungan ini bertujuan untuk memberikan wawasan langsung kepada siswa tentang dunia kerja di bidang telekomunikasi dan jaringan komputer.\n\nSiswa diharapkan mempersiapkan diri dengan baik dan membawa perlengkapan yang diperlukan.",
                'status' => 'Aktif',
                'tanggal_posting' => '2024-01-25',
                'admin_id' => $admin->id,
            ],
            [
                'judul' => 'Lomba Kompetensi Siswa (LKS) Tingkat Kota',
                'deskripsi' => 'SMKN 4 Bogor akan mengikuti LKS tingkat kota Bogor dengan mengirimkan perwakilan dari setiap jurusan.',
                'konten' => "Lomba Kompetensi Siswa (LKS) tingkat kota Bogor akan diselenggarakan pada bulan Maret 2024. SMKN 4 Bogor akan mengirimkan perwakilan dari setiap jurusan:\n\nKategori lomba:\n1. Web Technologies (PPLG)\n2. IT Network Systems Administration (TJKT)\n3. Automobile Technology (TO)\n4. Welding (TPFL)\n\nPersiapan LKS:\n- Pelatihan intensif selama 2 bulan\n- Pendampingan oleh guru ahli\n- Simulasi lomba\n- Evaluasi berkala\n\nTarget: Juara umum LKS tingkat kota Bogor 2024\n\nSemoga perwakilan SMKN 4 Bogor dapat meraih prestasi terbaik!",
                'status' => 'Aktif',
                'tanggal_posting' => '2024-01-30',
                'admin_id' => $admin->id,
            ],
            [
                'judul' => 'Workshop Pengembangan Aplikasi Mobile',
                'deskripsi' => 'Workshop pengembangan aplikasi mobile untuk siswa jurusan PPLG yang akan dibimbing oleh praktisi industri.',
                'konten' => "Workshop pengembangan aplikasi mobile akan diselenggarakan pada tanggal 10-12 Maret 2024. Workshop ini khusus untuk siswa jurusan PPLG kelas XI dan XII.\n\nMateri workshop:\n- Pengenalan Flutter Framework\n- UI/UX Design untuk Mobile\n- State Management\n- API Integration\n- Publishing ke App Store\n\nPembicara:\n- Ahmad Fauzi (Senior Mobile Developer)\n- Sarah Putri (UI/UX Designer)\n- Budi Santoso (Product Manager)\n\nWorkshop akan dilaksanakan di lab komputer SMKN 4 Bogor dengan fasilitas lengkap. Siswa akan membuat project aplikasi mobile dari awal hingga selesai.",
                'status' => 'Aktif',
                'tanggal_posting' => '2024-02-05',
                'admin_id' => $admin->id,
            ],
            [
                'judul' => 'Pelatihan K3 (Keselamatan dan Kesehatan Kerja)',
                'deskripsi' => 'Pelatihan K3 untuk siswa jurusan TO dan TPFL sebagai persiapan menghadapi dunia kerja yang aman.',
                'konten' => "Pelatihan K3 (Keselamatan dan Kesehatan Kerja) akan dilaksanakan pada tanggal 15-17 Maret 2024. Pelatihan ini wajib diikuti oleh siswa jurusan TO dan TPFL.\n\nMateri pelatihan:\n- Pengenalan K3\n- Penggunaan APD (Alat Pelindung Diri)\n- Prosedur keselamatan kerja\n- Penanganan kecelakaan kerja\n- Evakuasi darurat\n\nInstruktur:\n- Ir. Suryadi (Ahli K3 Umum)\n- Dr. Rina Marlina (Dokter K3)\n\nSetelah pelatihan, siswa akan mendapatkan sertifikat K3 yang berlaku secara nasional. Sertifikat ini sangat penting untuk memasuki dunia kerja di industri.",
                'status' => 'Aktif',
                'tanggal_posting' => '2024-02-10',
                'admin_id' => $admin->id,
            ],
        ];

        foreach ($informasis as $informasi) {
            Informasi::create($informasi);
        }
    }
}
