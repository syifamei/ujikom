# Sistem Kontak - SMKN 4 Bogor

## Deskripsi
Sistem kontak memungkinkan pengunjung website untuk mengirim pesan kepada admin sekolah. Pesan yang dikirim akan otomatis masuk ke halaman admin untuk dikelola.

## Fitur yang Tersedia

### 1. Form Kontak untuk Pengunjung
- **Lokasi**: `/kontak`
- **Fitur**:
  - Form pengiriman pesan dengan validasi
  - Field: Nama, Email, Subjek, Pesan
  - Notifikasi sukses/error setelah pengiriman
  - Validasi input yang ketat

### 2. Panel Admin untuk Mengelola Pesan
- **Lokasi**: `/admin/contact`
- **Fitur**:
  - Daftar semua pesan yang masuk
  - Filter berdasarkan status (Belum Dibaca, Sudah Dibaca, Sudah Dibalas)
  - Detail pesan lengkap
  - Update status pesan
  - Hapus pesan
  - Notifikasi jumlah pesan belum dibaca

### 3. Dashboard Admin
- **Lokasi**: `/admin/dashboard`
- **Fitur**:
  - Statistik total pesan kontak
  - Notifikasi pesan belum dibaca
  - Quick action untuk mengakses pesan kontak

## Struktur Database

### Tabel: contact_messages
```sql
- id (bigint, primary key)
- nama (varchar)
- email (varchar)
- subjek (varchar)
- pesan (text)
- status (enum: 'unread', 'read', 'replied')
- created_at (timestamp)
- updated_at (timestamp)
```

## Routes yang Tersedia

### Public Routes
- `GET /kontak` - Halaman form kontak
- `POST /kontak` - Kirim pesan kontak

### Admin Routes (Protected)
- `GET /admin/contact` - Daftar pesan kontak
- `GET /admin/contact/{id}` - Detail pesan
- `PATCH /admin/contact/{id}/status` - Update status pesan
- `DELETE /admin/contact/{id}` - Hapus pesan

## Cara Menggunakan

### Untuk Pengunjung:
1. Buka halaman `/kontak`
2. Isi form dengan data yang valid
3. Klik "Kirim Pesan"
4. Tunggu notifikasi sukses

### Untuk Admin:
1. Login ke admin panel
2. Akses menu "Pesan Kontak" di sidebar
3. Lihat daftar pesan yang masuk
4. Klik pesan untuk melihat detail
5. Update status atau hapus pesan sesuai kebutuhan

## Validasi Form
- **Nama**: Wajib diisi, maksimal 255 karakter
- **Email**: Wajib diisi, format email yang valid, maksimal 255 karakter
- **Subjek**: Wajib diisi, maksimal 255 karakter
- **Pesan**: Wajib diisi, minimal 10 karakter

## Status Pesan
- **unread**: Pesan belum dibaca (default)
- **read**: Pesan sudah dibaca
- **replied**: Pesan sudah dibalas

## File yang Dibuat/Dimodifikasi

### Model & Migration
- `app/Models/ContactMessage.php`
- `database/migrations/2025_09_09_001920_create_contact_messages_table.php`

### Controller
- `app/Http/Controllers/ContactController.php`

### Views
- `resources/views/kontak.blade.php` (dimodifikasi)
- `resources/views/admin/contact/index.blade.php` (baru)
- `resources/views/admin/contact/show.blade.php` (baru)
- `resources/views/layouts/admin.blade.php` (dimodifikasi)
- `resources/views/admin/dashboard.blade.php` (dimodifikasi)

### Routes
- `routes/web.php` (dimodifikasi)

### Seeder
- `database/seeders/ContactMessageSeeder.php`

## Testing
Sistem sudah dilengkapi dengan data contoh melalui seeder. Untuk menguji:
1. Akses halaman `/kontak` dan kirim pesan
2. Login sebagai admin dan lihat pesan di `/admin/contact`
3. Cek dashboard admin untuk statistik pesan

## Keamanan
- Form menggunakan CSRF protection
- Validasi input yang ketat
- Admin routes dilindungi middleware
- Sanitasi data input

## Catatan
- Server Laravel sudah berjalan di background
- Database sudah di-migrate dan di-seed
- Sistem siap digunakan




























































