# Sistem Informasi SMKN 4 Bogor

## Deskripsi
Sistem informasi adalah fitur baru yang menggantikan bagian kategori di halaman utama. Admin dapat menambahkan, mengedit, dan mengelola informasi sekolah yang akan ditampilkan secara otomatis di halaman utama.

## Fitur Utama

### 1. Halaman Utama (Public)
- Menampilkan informasi sekolah terbaru (maksimal 6 informasi)
- Setiap informasi menampilkan:
  - Gambar (opsional)
  - Judul
  - Deskripsi singkat
  - Tanggal posting
  - Status (Aktif/Nonaktif)
- Modal popup untuk membaca konten lengkap
- Responsive design

### 2. Panel Admin
- **Kelola Informasi**: CRUD lengkap untuk informasi
- **Tambah Informasi**: Form untuk menambah informasi baru
- **Edit Informasi**: Form untuk mengedit informasi yang ada
- **Lihat Detail**: Halaman detail informasi
- **Toggle Status**: Aktifkan/nonaktifkan informasi
- **Hapus Informasi**: Hapus informasi dengan konfirmasi

## Struktur Database

### Tabel `informasi`
```sql
CREATE TABLE informasi (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT NOT NULL,
    konten LONGTEXT NOT NULL,
    gambar VARCHAR(255) NULL,
    status ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
    tanggal_posting DATE NOT NULL,
    admin_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE
);
```

## File yang Dibuat/Dimodifikasi

### Model
- `app/Models/Informasi.php` - Model untuk tabel informasi

### Controller
- `app/Http/Controllers/InformasiController.php` - Controller untuk mengelola informasi

### Views
- `resources/views/admin/informasi/index.blade.php` - Halaman daftar informasi
- `resources/views/admin/informasi/create.blade.php` - Form tambah informasi
- `resources/views/admin/informasi/edit.blade.php` - Form edit informasi
- `resources/views/admin/informasi/show.blade.php` - Halaman detail informasi

### Migration
- `database/migrations/2025_08_29_012521_create_informasi_table.php` - Migration untuk tabel informasi

### Seeder
- `database/seeders/InformasiSeeder.php` - Data sample untuk testing

### Routes
- Ditambahkan di `routes/web.php`:
  ```php
  Route::resource('informasi', InformasiController::class);
  Route::patch('/informasi/{informasi}/toggle-status', [InformasiController::class, 'toggleStatus'])->name('informasi.toggle-status');
  ```

### Layout
- `resources/views/layouts/admin.blade.php` - Ditambahkan menu Informasi
- `resources/views/admin/dashboard.blade.php` - Ditambahkan quick action untuk informasi
- `resources/views/home.blade.php` - Diganti bagian Program Keahlian menjadi Informasi Sekolah

## Cara Penggunaan

### 1. Akses Panel Admin
- Login ke panel admin
- Pilih menu "Informasi" di sidebar

### 2. Menambah Informasi Baru
- Klik tombol "Tambah Informasi"
- Isi form:
  - **Judul**: Judul informasi (wajib)
  - **Deskripsi**: Deskripsi singkat (maksimal 500 karakter)
  - **Konten**: Konten lengkap informasi
  - **Gambar**: Upload gambar (opsional, maksimal 2MB)
  - **Tanggal Posting**: Tanggal informasi diposting
  - **Status**: Aktif atau Nonaktif
- Klik "Simpan Informasi"

### 3. Mengedit Informasi
- Klik tombol edit (ikon pensil) pada informasi yang ingin diedit
- Ubah data yang diperlukan
- Klik "Update Informasi"

### 4. Mengubah Status
- Klik tombol toggle status (ikon mata) untuk mengaktifkan/nonaktifkan
- Informasi yang nonaktif tidak akan ditampilkan di halaman utama

### 5. Menghapus Informasi
- Klik tombol hapus (ikon tempat sampah)
- Konfirmasi penghapusan
- Gambar akan dihapus otomatis dari storage

## Fitur Tambahan

### 1. Preview Gambar
- Saat upload gambar, akan muncul preview
- Mendukung format JPG, PNG, GIF
- Maksimal ukuran 2MB

### 2. Validasi Form
- Semua field wajib diisi kecuali gambar
- Validasi ukuran dan format gambar
- Validasi panjang deskripsi

### 3. Responsive Design
- Halaman admin responsive untuk desktop dan mobile
- Halaman utama responsive dengan grid layout

### 4. Keamanan
- CSRF protection
- Validasi input
- Konfirmasi untuk aksi penting
- File upload validation

## Data Sample
Seeder telah menyediakan 6 data sample informasi:
1. Penerimaan Peserta Didik Baru (PPDB) 2024/2025
2. Kegiatan Praktik Kerja Industri (Prakerin)
3. Kunjungan Industri ke PT. Telkom Indonesia
4. Lomba Kompetensi Siswa (LKS) Tingkat Kota
5. Workshop Pengembangan Aplikasi Mobile
6. Pelatihan K3 (Keselamatan dan Kesehatan Kerja)

## Instalasi

1. Jalankan migration:
   ```bash
   php artisan migrate
   ```

2. Jalankan seeder (opsional):
   ```bash
   php artisan db:seed --class=InformasiSeeder
   ```

3. Pastikan symbolic link storage sudah dibuat:
   ```bash
   php artisan storage:link
   ```

4. Buat folder untuk gambar:
   ```bash
   mkdir -p storage/app/public/informasi
   ```

## Catatan Penting

- Gambar disimpan di `storage/app/public/informasi/`
- Hanya informasi dengan status "Aktif" yang ditampilkan di halaman utama
- Maksimal 6 informasi ditampilkan di halaman utama
- Urutan berdasarkan tanggal posting terbaru
- Admin yang membuat informasi akan tercatat di database

## Troubleshooting

### Gambar tidak muncul
- Pastikan symbolic link storage sudah dibuat
- Periksa permission folder storage
- Pastikan path gambar benar

### Error saat upload gambar
- Periksa ukuran file (maksimal 2MB)
- Pastikan format file didukung (JPG, PNG, GIF)
- Periksa permission folder storage

### Informasi tidak muncul di halaman utama
- Pastikan status informasi "Aktif"
- Periksa tanggal posting
- Refresh cache jika diperlukan


