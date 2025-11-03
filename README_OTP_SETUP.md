# Setup OTP Authentication System

## Deskripsi
Sistem autentikasi dengan verifikasi OTP (One-Time Password) via email untuk SMKN 4 Bogor Gallery.

## Flow Autentikasi
1. **Register** → User mengisi form pendaftaran (nama, email, password)
2. **Generate OTP** → Sistem generate kode OTP 6 digit dan kirim ke email
3. **Verifikasi OTP** → User memasukkan kode OTP dari email
4. **Aktivasi Akun** → Akun diaktifkan (is_active = true)
5. **Login** → User dapat login dengan email & password
6. **Redirect** → Setelah login, redirect ke halaman galeri

## Instalasi & Konfigurasi

### 1. Jalankan Migration
```bash
php artisan migrate
```

Migration akan menambahkan kolom berikut ke tabel `users`:
- `otp_code` (string, nullable) - Kode OTP 6 digit
- `otp_expires_at` (timestamp, nullable) - Waktu kadaluarsa OTP
- `is_active` (boolean, default: false) - Status aktivasi akun

### 2. Konfigurasi Email (.env)

#### Opsi A: Menggunakan Mailtrap (Untuk Development)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_username
MAIL_PASSWORD=your_mailtrap_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@smkn4bogor.sch.id
MAIL_FROM_NAME="${APP_NAME}"
```

Daftar di: https://mailtrap.io

#### Opsi B: Menggunakan Gmail (Untuk Production)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_gmail@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_gmail@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Cara mendapatkan App Password Gmail:**
1. Buka Google Account → Security
2. Enable 2-Step Verification
3. Generate App Password
4. Gunakan password 16 karakter yang digenerate

#### Opsi C: Menggunakan SMTP Sekolah (Jika Ada)
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.smkn4bogor.sch.id
MAIL_PORT=587
MAIL_USERNAME=noreply@smkn4bogor.sch.id
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@smkn4bogor.sch.id
MAIL_FROM_NAME="SMKN 4 BOGOR"
```

### 3. Test Email Configuration
```bash
php artisan tinker
```

```php
Mail::raw('Test email', function ($message) {
    $message->to('your_test_email@example.com')
        ->subject('Test Email');
});
```

### 4. Clear Cache (Setelah Update .env)
```bash
php artisan config:clear
php artisan cache:clear
```

## Fitur-Fitur

### 1. Registrasi dengan OTP
- Form registrasi: nama, email, password, konfirmasi password
- Password strength indicator
- Generate OTP otomatis setelah registrasi
- Kirim OTP via email
- OTP berlaku 10 menit

### 2. Verifikasi OTP
- Input 6 digit OTP dengan UI modern
- Auto-focus antar input field
- Countdown timer 10 menit
- Tombol kirim ulang OTP
- Validasi OTP di backend

### 3. Login dengan Pengecekan is_active
- User hanya bisa login jika `is_active = true`
- Jika belum verifikasi OTP, muncul error message
- Redirect ke galeri setelah login berhasil

### 4. Navbar dengan Auth Buttons
- Tombol **Login** dan **Daftar** untuk guest
- Dropdown user dengan nama dan tombol **Logout** untuk user yang sudah login
- Responsive design dengan Bootstrap 5

## Routes

### Public Routes
```php
GET  /register           - Form registrasi
POST /register           - Submit registrasi
GET  /verify-otp         - Form verifikasi OTP
POST /verify-otp         - Submit verifikasi OTP
POST /resend-otp         - Kirim ulang OTP
GET  /login              - Form login
POST /login              - Submit login
POST /logout             - Logout
```

## Database Schema

### Tabel: users
```sql
- id (bigint, primary key)
- name (varchar)
- username (varchar, unique)
- email (varchar, unique)
- password (varchar)
- phone (varchar, nullable)
- status (varchar, nullable)
- profile_photo_path (varchar, nullable)
- otp_code (varchar, nullable)          -- NEW
- otp_expires_at (timestamp, nullable)  -- NEW
- is_active (boolean, default: false)   -- NEW
- email_verified_at (timestamp, nullable)
- remember_token (varchar, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## Security Features

1. **OTP Expiration**: OTP berlaku 10 menit
2. **Password Hashing**: Menggunakan bcrypt
3. **CSRF Protection**: Semua form dilindungi CSRF token
4. **Email Validation**: Validasi format email dan unique check
5. **Password Confirmation**: Harus match dengan password
6. **Account Activation**: User tidak bisa login sebelum verifikasi OTP

## Troubleshooting

### Email Tidak Terkirim
1. Cek konfigurasi `.env`
2. Cek log error di `storage/logs/laravel.log`
3. Pastikan firewall tidak memblok port SMTP
4. Untuk development, gunakan Mailtrap atau log driver

### OTP Kadaluarsa
- OTP berlaku 10 menit
- User bisa klik tombol "Kirim Ulang Kode OTP"
- OTP baru akan digenerate dan dikirim

### User Tidak Bisa Login
- Pastikan akun sudah diverifikasi (`is_active = true`)
- Cek email & password sudah benar
- Cek di database tabel `users` kolom `is_active`

## Development Tips

### Untuk Testing Tanpa Email
Ubah di `.env`:
```env
MAIL_MAILER=log
```

OTP akan di-log di `storage/logs/laravel.log` dan tidak dikirim via email.

### Activate User Manual (Untuk Testing)
```sql
UPDATE users SET is_active = 1 WHERE email = 'test@example.com';
```

Atau via tinker:
```bash
php artisan tinker
```
```php
$user = User::where('email', 'test@example.com')->first();
$user->is_active = true;
$user->save();
```

## File-File yang Dimodifikasi/Dibuat

### Models
- `app/Models/User.php` - Tambah OTP methods

### Controllers
- `app/Http/Controllers/Auth/RegisterController.php` - Handle registrasi & OTP
- `app/Http/Controllers/Auth/LoginController.php` - Handle login dengan check is_active

### Views
- `resources/views/auth/register.blade.php` - Form registrasi
- `resources/views/auth/login.blade.php` - Form login
- `resources/views/auth/verify-otp.blade.php` - Form verifikasi OTP (BARU)
- `resources/views/layouts/app.blade.php` - Navbar dengan auth buttons

### Routes
- `routes/web.php` - Route registrasi, login, OTP verification

### Migrations
- `database/migrations/2024_01_24_000000_add_otp_and_active_to_users_table.php`

## Support
Untuk bantuan lebih lanjut, hubungi tim IT SMKN 4 Bogor.
