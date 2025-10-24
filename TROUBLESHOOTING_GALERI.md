# 🔧 Troubleshooting Sistem Galeri Admin

## 🚨 **Error yang Sering Terjadi & Solusinya**

### **1. Error: "Column not found: created_at"**

**Gejala:**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'created_at' in 'order clause'
```

**Penyebab:**
- Tabel `foto` tidak memiliki kolom `created_at`
- Migration lama tidak kompatibel dengan sistem baru

**Solusi:**
```bash
# Rollback migration yang bermasalah
php artisan migrate:rollback --step=1

# Hapus migration yang bermasalah
rm database/migrations/2025_08_28_021838_update_foto_table_for_gallery.php

# Jalankan migration yang benar
php artisan migrate --path=database/migrations/2025_08_28_023402_recreate_foto_table_for_gallery.php
```

### **2. Error: "Foreign key constraint is incorrectly formed"**

**Gejala:**
```
SQLSTATE[HY000]: General error: 1005 Can't create table `foto` (errno: 150 "Foreign key constraint is incorrectly formed")
```

**Penyebab:**
- Tabel referensi (`kategori`, `petugas`) belum ada
- Urutan migration tidak tepat

**Solusi:**
```bash
# Jalankan migration kategori terlebih dahulu
php artisan migrate --path=database/migrations/2025_08_28_021320_add_columns_to_kategori_table.php
php artisan migrate --path=database/migrations/2025_08_28_021443_add_timestamps_to_kategori_table.php

# Jalankan seeder kategori
php artisan db:seed --class=KategoriSeeder

# Baru jalankan migration foto
php artisan migrate --path=database/migrations/2025_08_28_023402_recreate_foto_table_for_gallery.php
```

### **3. Error: "Cannot drop foreign key"**

**Gejala:**
```
SQLSTATE[42000]: Syntax error or access violation: 1091 Can't DROP FOREIGN KEY `foto_galery_id_foreign`
```

**Penyebab:**
- Foreign key constraint tidak ada
- Migration mencoba menghapus constraint yang tidak ada

**Solusi:**
```bash
# Hapus migration yang bermasalah
rm database/migrations/2025_08_28_021838_update_foto_table_for_gallery.php

# Gunakan migration yang lebih sederhana
php artisan migrate --path=database/migrations/2025_08_28_023402_recreate_foto_table_for_gallery.php
```

## 🛠️ **Langkah Perbaikan Lengkap**

### **Step 1: Reset Database (Jika Perlu)**
```bash
# Hapus semua tabel dan buat ulang
php artisan migrate:fresh

# Jalankan seeder kategori
php artisan db:seed --class=KategoriSeeder

# Jalankan seeder foto sample
php artisan db:seed --class=FotoSeeder
```

### **Step 2: Periksa Struktur Tabel**
```bash
# Cek status migration
php artisan migrate:status

# Cek struktur tabel yang ada
php artisan tinker --execute="Schema::getColumnListing('foto')"
php artisan tinker --execute="Schema::getColumnListing('kategori')"
```

### **Step 3: Periksa Storage**
```bash
# Buat storage link
php artisan storage:link

# Buat direktori foto
mkdir -p storage/app/public/fotos
mkdir -p storage/app/public/fotos/sample

# Set permission (Linux/Mac)
chmod -R 775 storage/app/public/fotos
```

## 📊 **Struktur Database yang Benar**

### **Tabel `kategori`**
```sql
CREATE TABLE kategori (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    deskripsi TEXT NULL,
    status ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### **Tabel `foto`**
```sql
CREATE TABLE foto (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255) NOT NULL,
    deskripsi TEXT NULL,
    path VARCHAR(255) NOT NULL,
    kategori_id BIGINT UNSIGNED NOT NULL,
    status ENUM('Aktif', 'Nonaktif') DEFAULT 'Aktif',
    petugas_id BIGINT UNSIGNED NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

## 🔍 **Debug Commands**

### **Periksa Error Log**
```bash
# Lihat log Laravel
tail -f storage/logs/laravel.log

# Periksa error database
php artisan tinker --execute="DB::connection()->getPdo()->errorInfo()"
```

### **Periksa Route**
```bash
# Lihat semua route yang tersedia
php artisan route:list --name=admin

# Test route tertentu
php artisan route:list --name=admin.galeries
```

### **Periksa View**
```bash
# Clear cache view
php artisan view:clear

# Periksa file view ada
ls -la resources/views/admin/galeries/
```

## ✅ **Checklist Verifikasi**

- [ ] Migration kategori berhasil dijalankan
- [ ] Migration foto berhasil dijalankan
- [ ] Seeder kategori berhasil dijalankan
- [ ] Seeder foto sample berhasil dijalankan
- [ ] Storage link sudah dibuat
- [ ] Direktori foto sudah dibuat
- [ ] Route admin galeri sudah terdaftar
- [ ] Controller Admin\FotoController sudah ada
- [ ] View admin galeri sudah ada
- [ ] Model Foto dan Kategori sudah ada

## 🚀 **Test Sistem**

### **1. Test Database**
```bash
# Cek data kategori
php artisan tinker --execute="App\Models\Kategori::all()"

# Cek data foto
php artisan tinker --execute="App\Models\Foto::with('kategori')->get()"
```

### **2. Test Route**
```bash
# Test akses halaman galeri
curl http://127.0.0.1:8000/admin/galeri
```

### **3. Test Upload**
- Buka halaman galeri admin
- Klik "Tambah Foto"
- Upload file gambar
- Verifikasi foto muncul di galeri

## 📞 **Jika Masih Bermasalah**

### **1. Periksa Error Log**
```bash
tail -f storage/logs/laravel.log
```

### **2. Periksa Console Browser**
- Buka Developer Tools (F12)
- Lihat tab Console untuk error JavaScript
- Lihat tab Network untuk error HTTP

### **3. Periksa Database**
```bash
# Masuk ke database
mysql -u root -p dbujikom

# Periksa struktur tabel
DESCRIBE foto;
DESCRIBE kategori;
```

### **4. Reset Lengkap (Last Resort)**
```bash
# Hapus semua dan buat ulang
php artisan migrate:fresh --seed

# Jalankan seeder manual
php artisan db:seed --class=KategoriSeeder
php artisan db:seed --class=FotoSeeder
```

---

**© 2025 SMKN 4 Bogor - Troubleshooting Guide**
*Dibuat untuk memudahkan troubleshooting sistem galeri admin*











































































