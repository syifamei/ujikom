# Dokumentasi Laporan Galeri Admin

## 📋 Overview
Halaman laporan galeri admin yang menampilkan statistik lengkap tentang aktivitas galeri, user, like, dan download dengan fitur filter periode dan export PDF.

## ✨ Fitur yang Tersedia

### 1. **Summary Cards**
Menampilkan ringkasan statistik:
- ✅ Total User Terdaftar (yang register/login)
- ✅ Total Foto di Galeri
- ✅ Total Like dari semua user
- ✅ Total Download dari semua user

### 2. **Daftar User Terdaftar**
Tabel yang menampilkan:
- Username
- Nama Lengkap
- Email
- Status (Aktif/Tidak Aktif)
- Tanggal Daftar

### 3. **Statistik per Kategori**
Tabel yang menampilkan:
- Nama Kategori
- Total Foto dalam kategori
- Total Like per kategori
- Total Download per kategori

### 4. **Detail Foto**
Tabel lengkap semua foto dengan:
- Thumbnail foto
- Judul
- Kategori
- Jumlah Like per foto
- Jumlah Download per foto
- Tanggal Upload

### 5. **Filter Periode**
Dropdown filter:
- **Semua Waktu** - Menampilkan semua data sejak awal
- **1 Minggu Terakhir** - Data 7 hari terakhir
- **1 Bulan Terakhir** - Data 30 hari terakhir

### 6. **Generate PDF**
- Export laporan ke file PDF
- Format: `laporan-galeri-{period}-{timestamp}.pdf`
- Ukuran kertas: A4 Portrait
- Include semua data yang ditampilkan di halaman

## 🚀 Cara Mengakses

### URL Halaman Laporan:
```
/admin/reports/gallery
```

### Generate PDF:
```
/admin/gallery/report?period={all|weekly|monthly}
```

## 📊 Struktur Data

### Controller: `GalleryReportController.php`

#### Method: `index()`
Menampilkan halaman laporan dengan data:
- `$users` - Daftar user yang terdaftar
- `$fotos` - Daftar foto dengan likes & downloads
- `$kategoriStats` - Statistik per kategori
- `$summary` - Ringkasan total
- `$period` - Periode filter (all/weekly/monthly)

#### Method: `generate()`
Generate PDF dengan data yang sama seperti halaman web

## 🔧 Filter Berdasarkan Periode

### Cara Kerja:
```php
// All Time (default)
if ($period === 'all') {
    // Ambil semua data tanpa filter tanggal
}

// Weekly
if ($period === 'weekly') {
    $query->where('created_at', '>=', now()->subWeek());
}

// Monthly
if ($period === 'monthly') {
    $query->where('created_at', '>=', now()->subMonth());
}
```

### Yang Difilter:
- ✅ User registrations (berdasarkan created_at)
- ✅ Likes (berdasarkan tanggal like)
- ✅ Downloads (berdasarkan tanggal download)
- ✅ Fotos (berdasarkan tanggal upload)

## 📁 File Structure

```
app/Http/Controllers/Admin/
  └── GalleryReportController.php

resources/views/admin/reports/
  ├── gallery_index.blade.php   (Halaman web)
  └── gallery.blade.php          (Template PDF)

routes/
  └── web.php
      ├── Route::get('/admin/reports/gallery')
      └── Route::get('/admin/gallery/report')
```

## 🎨 Tampilan

### Halaman Web
- Responsive design (desktop, tablet, mobile)
- Bootstrap styling
- Cards untuk summary
- Tables untuk detail data
- Filter dropdown di atas

### PDF Export
- Clean layout A4
- Header dengan logo sekolah
- Grid statistics cards
- Tables untuk semua data
- Footer dengan timestamp

## 💾 Database Queries

### Users dengan Filter:
```php
User::query()
    ->when($period === 'weekly', fn($q) => $q->where('created_at', '>=', now()->subWeek()))
    ->when($period === 'monthly', fn($q) => $q->where('created_at', '>=', now()->subMonth()))
    ->orderBy('created_at', 'desc')
    ->get();
```

### Likes per Foto:
```php
$foto->likes()
    ->when($period === 'weekly', fn($q) => $q->where('created_at', '>=', now()->subWeek()))
    ->when($period === 'monthly', fn($q) => $q->where('created_at', '>=', now()->subMonth()))
    ->count();
```

### Downloads per Foto:
```php
$foto->downloadLogs()
    ->when($period === 'weekly', fn($q) => $q->where('created_at', '>=', now()->subWeek()))
    ->when($period === 'monthly', fn($q) => $q->where('created_at', '>=', now()->subMonth()))
    ->count();
```

### Stats per Kategori:
```php
foreach ($kategori->fotos as $foto) {
    $totalLikes += $foto->likes()
        ->when($period, fn($q) => $q->where('created_at', '>=', $startDate))
        ->count();
        
    $totalDownloads += $foto->downloadLogs()
        ->when($period, fn($q) => $q->where('created_at', '>=', $startDate))
        ->count();
}
```

## ⚠️ Catatan Penting

### Yang TIDAK Ditampilkan:
- ❌ Komentar (sudah dihapus dari laporan)
- ❌ Data pending/rejected comments
- ❌ Dislike (tidak digunakan)

### Yang Ditampilkan:
- ✅ User registrations
- ✅ Likes per foto
- ✅ Downloads per foto
- ✅ Stats per kategori
- ✅ Filtered by period

## 🧪 Testing

### Test Case 1: Filter Semua Waktu
1. Pilih "Semua Waktu" di dropdown
2. Harus muncul semua user sejak awal
3. Harus muncul semua foto sejak awal
4. Stats kategori menghitung dari semua data

### Test Case 2: Filter Mingguan
1. Pilih "1 Minggu Terakhir"
2. Hanya tampil user yang register 7 hari terakhir
3. Likes & downloads hanya dari 7 hari terakhir
4. Stats kategori dihitung dari data 7 hari

### Test Case 3: Filter Bulanan
1. Pilih "1 Bulan Terakhir"
2. Hanya tampil user yang register 30 hari terakhir
3. Likes & downloads hanya dari 30 hari terakhir
4. Stats kategori dihitung dari data 30 hari

### Test Case 4: Generate PDF
1. Klik tombol "Generate PDF"
2. File PDF ter-download otomatis
3. PDF berisi data sesuai filter yang dipilih
4. Semua tabel dan stats tampil dengan benar

## 📝 Maintenance

### Update Summary Cards:
Edit di `gallery_index.blade.php` bagian:
```blade
<div class="row g-3 mb-4">
    <!-- Summary cards -->
</div>
```

### Update PDF Layout:
Edit di `gallery.blade.php` bagian:
```blade
<div class="stats-grid">
    <!-- PDF stats -->
</div>
```

### Tambah Filter Baru:
1. Update controller method `index()` dan `generate()`
2. Tambah option di dropdown filter
3. Update query sesuai periode baru

---

**Version:** 2.0  
**Last Updated:** October 26, 2025  
**Maintained By:** Admin SMKN 4 BOGOR
