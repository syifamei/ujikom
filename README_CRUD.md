# UJIKOM CRUD API Project

## Deskripsi
Project ini adalah aplikasi CRUD API menggunakan Laravel 12 dengan database MySQL. Aplikasi ini memiliki 6 tabel utama: kategori, petugas, posts, profile, galery, dan foto.

## Struktur Database
- **kategori**: id, judul
- **petugas**: id, username, password, created_at
- **posts**: id, judul, kategori_id, isi, petugas_id, status, created_at
- **profile**: id, judul, isi, created_at
- **galery**: id, post_id, position, status
- **foto**: id, galery_id, file, judul

## Setup Project

### 1. Database Setup
1. Buat database MySQL dengan nama `dbujikom`
2. Import file `database_schema.sql` ke database tersebut
3. Update file `.env` dengan konfigurasi database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=dbujikom
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### 2. Install Dependencies
```bash
composer install
```

### 3. Generate Application Key
```bash
php artisan key:generate
```

### 4. Clear Cache
```bash
php artisan config:clear
php artisan route:clear
php artisan cache:clear
```

### 5. Dump Autoload
```bash
composer dump-autoload
```

## Menjalankan Aplikasi

### Start Server
```bash
php artisan serve
```
Aplikasi akan berjalan di `http://127.0.0.1:8000`

### Base URL API
```
http://127.0.0.1:8000/api
```

## API Endpoints

### Kategori
- `GET /api/kategori` - Get all kategori
- `POST /api/kategori` - Create kategori
- `GET /api/kategori/{id}` - Get kategori by ID
- `PUT /api/kategori/{id}` - Update kategori
- `DELETE /api/kategori/{id}` - Delete kategori

### Petugas
- `GET /api/petugas` - Get all petugas
- `POST /api/petugas` - Create petugas
- `GET /api/petugas/{id}` - Get petugas by ID
- `PUT /api/petugas/{id}` - Update petugas
- `DELETE /api/petugas/{id}` - Delete petugas

### Posts
- `GET /api/posts` - Get all posts
- `POST /api/posts` - Create post
- `GET /api/posts/{id}` - Get post by ID
- `PUT /api/posts/{id}` - Update post
- `DELETE /api/posts/{id}` - Delete post

### Profile
- `GET /api/profile` - Get all profile
- `POST /api/profile` - Create profile
- `GET /api/profile/{id}` - Get profile by ID
- `PUT /api/profile/{id}` - Update profile
- `DELETE /api/profile/{id}` - Delete profile

### Galery
- `GET /api/galery` - Get all galery
- `POST /api/galery` - Create galery
- `GET /api/galery/{id}` - Get galery by ID
- `PUT /api/galery/{id}` - Update galery
- `DELETE /api/galery/{id}` - Delete galery

### Foto
- `GET /api/foto` - Get all foto
- `POST /api/foto` - Create foto
- `GET /api/foto/{id}` - Get foto by ID
- `PUT /api/foto/{id}` - Update foto
- `DELETE /api/foto/{id}` - Delete foto

## Testing dengan Postman

### 1. Setup Postman
- Buka Postman
- Set Base URL: `http://127.0.0.1:8000/api`
- Set Headers: `Content-Type: application/json`

### 2. Test Create Data
1. **Create Kategori**
   ```json
   POST /api/kategori
   {
       "judul": "Teknologi"
   }
   ```

2. **Create Petugas**
   ```json
   POST /api/petugas
   {
       "username": "admin",
       "password": "password123"
   }
   ```

3. **Create Post**
   ```json
   POST /api/posts
   {
       "judul": "Artikel Pertama",
       "kategori_id": 1,
       "isi": "Ini adalah isi artikel pertama",
       "petugas_id": 1,
       "status": "published"
   }
   ```

### 3. Test Read Data
- `GET /api/kategori` - Get all kategori
- `GET /api/petugas` - Get all petugas
- `GET /api/posts` - Get all posts

### 4. Test Update Data
```json
PUT /api/kategori/1
{
    "judul": "Teknologi Terbaru"
}
```

### 5. Test Delete Data
- `DELETE /api/kategori/1` - Delete kategori dengan ID 1

## Sample Data

### Kategori
- Teknologi
- Olahraga
- Pendidikan

### Petugas
- username: admin, password: password
- username: editor, password: password

### Profile
- Tentang Kami
- Visi Misi

## Troubleshooting

### Routes Tidak Muncul
1. Clear route cache: `php artisan route:clear`
2. Clear config cache: `php artisan config:clear`
3. Dump autoload: `composer dump-autoload`

### Database Connection Error
1. Pastikan MySQL berjalan
2. Cek konfigurasi database di `.env`
3. Pastikan database `dbujikom` sudah dibuat

### Controller Not Found
1. Pastikan namespace benar
2. Cek file controller ada di folder yang benar
3. Dump autoload: `composer dump-autoload`

## File Structure
```
app/
├── Http/Controllers/
│   ├── KategoriController.php
│   ├── PetugasController.php
│   ├── PostController.php
│   ├── ProfileController.php
│   ├── GaleryController.php
│   └── FotoController.php
├── Models/
│   ├── Kategori.php
│   ├── Petugas.php
│   ├── Post.php
│   ├── Profile.php
│   ├── Galery.php
│   └── Foto.php
routes/
└── api.php
```

## Notes
- Semua response menggunakan format JSON
- Response success selalu memiliki field `success: true`
- Error response akan memiliki field `success: false` dan `message`
- Foreign key constraints sudah diatur dengan `ON DELETE CASCADE`
- Password petugas di-hash menggunakan bcrypt
- Timestamps otomatis untuk created_at
