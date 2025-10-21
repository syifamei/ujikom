-- Sample data untuk testing aplikasi Galeri Sekolah

-- Insert kategori
INSERT INTO kategori (judul) VALUES 
('Ekstrakurikuler'),
('Berita Terkini'),
('Prestasi & Penghargaan'),
('Galeri Sekolah'),
('Agenda Sekolah');

-- Insert petugas (password: password)
INSERT INTO petugas (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('editor', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert profile
INSERT INTO profile (judul, isi) VALUES 
('Tentang Kami', 'Sekolah kami adalah lembaga pendidikan yang berkomitmen untuk memberikan pendidikan berkualitas dan membentuk karakter siswa yang unggul dalam prestasi dan berakhlak mulia. Didirikan pada tahun 1990, sekolah kami telah meluluskan ribuan siswa yang berhasil dalam berbagai bidang.\n\nDengan visi menjadi sekolah unggulan yang menghasilkan lulusan berkualitas dan berakhlak mulia, kami terus berkomitmen untuk memberikan pendidikan terbaik dengan mengembangkan potensi siswa secara optimal.\n\nMisi kami:\n1. Menyelenggarakan pendidikan berkualitas\n2. Mengembangkan potensi siswa secara optimal\n3. Membentuk karakter siswa yang berakhlak mulia\n4. Menciptakan lingkungan belajar yang kondusif');

-- Insert posts untuk Ekstrakurikuler
INSERT INTO posts (judul, kategori_id, isi, petugas_id, status) VALUES 
('Kegiatan Pramuka', 1, 'Kegiatan pramuka rutin setiap hari Sabtu dengan berbagai aktivitas menarik untuk mengembangkan karakter siswa. Kegiatan meliputi latihan kepemimpinan, survival, dan kegiatan sosial.', 1, 'Aktif'),
('Klub Robotik', 1, 'Klub robotik untuk siswa yang tertarik dengan teknologi. Siswa belajar membuat robot sederhana dan mengikuti berbagai kompetisi robotik.', 1, 'Aktif'),
('English Club', 1, 'English Club untuk meningkatkan kemampuan berbahasa Inggris siswa melalui berbagai aktivitas menarik seperti drama, debat, dan conversation.', 2, 'Aktif');

-- Insert posts untuk Berita Terkini
INSERT INTO posts (judul, kategori_id, isi, petugas_id, status) VALUES 
('Penerimaan Siswa Baru 2024', 2, 'Pendaftaran siswa baru untuk tahun ajaran 2024/2025 telah dibuka. Silakan daftar segera karena kuota terbatas. Pendaftaran dibuka mulai Januari 2024.', 1, 'Aktif'),
('Lomba Matematika', 2, 'Siswa kami berhasil meraih juara 1 dalam lomba matematika tingkat kabupaten. Selamat kepada para pemenang!', 2, 'Aktif'),
('Kunjungan Industri', 2, 'Siswa kelas XII melakukan kunjungan industri ke berbagai perusahaan untuk menambah wawasan tentang dunia kerja.', 2, 'Aktif');

-- Insert posts untuk Prestasi & Penghargaan
INSERT INTO posts (judul, kategori_id, isi, petugas_id, status) VALUES 
('Juara 1 Olimpiade Sains', 3, 'Tim olimpiade sains sekolah berhasil meraih juara 1 dalam kompetisi tingkat provinsi. Prestasi membanggakan untuk sekolah kami.', 1, 'Aktif'),
('Penghargaan Sekolah Adiwiyata', 3, 'Sekolah kami mendapatkan penghargaan Adiwiyata tingkat kabupaten atas komitmen dalam menjaga lingkungan sekolah.', 1, 'Aktif'),
('Juara 2 Lomba Debat Bahasa Inggris', 3, 'Tim debat bahasa Inggris berhasil meraih juara 2 dalam kompetisi tingkat kabupaten.', 2, 'Aktif');

-- Insert posts untuk Galeri Sekolah
INSERT INTO posts (judul, kategori_id, isi, petugas_id, status) VALUES 
('Kegiatan Pramuka', 4, 'Dokumentasi kegiatan pramuka yang rutin dilaksanakan setiap hari Sabtu.', 1, 'Aktif'),
('Kunjungan Industri', 4, 'Dokumentasi kunjungan industri siswa kelas XII ke berbagai perusahaan.', 2, 'Aktif');

-- Insert posts untuk Agenda Sekolah
INSERT INTO posts (judul, kategori_id, isi, petugas_id, status) VALUES 
('Pensi 2024', 5, 'Pentas Seni (Pensi) akan dilaksanakan pada bulan Maret 2024. Acara menampilkan berbagai pertunjukan seni dari siswa.', 1, 'Aktif'),
('Transforkrab 2024', 5, 'Transportasi Forklift Kreatif (Transforkrab) akan dilaksanakan pada bulan April 2024. Kompetisi membuat kendaraan kreatif dari bahan bekas.', 1, 'Aktif'),
('P5 - Proyek Penguatan Profil Pelajar Pancasila', 5, 'Kegiatan P5 akan dilaksanakan pada bulan Mei 2024 dengan tema "Kebhinekaan Global".', 1, 'Aktif'),
('Moontour - Study Tour', 5, 'Kunjungan studi ke berbagai destinasi wisata dan edukasi akan dilaksanakan pada bulan Juni 2024.', 2, 'Aktif'),
('Klasmeet - Class Meeting', 5, 'Class Meeting antar kelas akan dilaksanakan pada bulan Juli 2024 dengan berbagai perlombaan menarik.', 2, 'Aktif'),
('Lomba 17-an', 5, 'Perlombaan dalam rangka memperingati HUT RI ke-79 akan dilaksanakan pada bulan Agustus 2024.', 1, 'Aktif');

-- Insert galery
INSERT INTO galery (post_id, position, status) VALUES 
(4, 1, 1),
(7, 1, 1);

-- Insert foto (catatan: file path akan diisi saat upload foto)
INSERT INTO foto (galery_id, file, judul) VALUES 
(1, 'sample1.jpg', 'Kegiatan Pramuka 1'),
(1, 'sample2.jpg', 'Kegiatan Pramuka 2'),
(2, 'sample3.jpg', 'Kunjungan Industri 1'),
(2, 'sample4.jpg', 'Kunjungan Industri 2');
