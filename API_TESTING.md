# API Testing Documentation

## Base URL
```
http://127.0.0.1:8000/api
```

## 1. Kategori API

### Get All Kategori
```
GET /api/kategori
```

### Create Kategori
```
POST /api/kategori
Content-Type: application/json

{
    "judul": "Teknologi"
}
```

### Get Kategori by ID
```
GET /api/kategori/{id}
```

### Update Kategori
```
PUT /api/kategori/{id}
Content-Type: application/json

{
    "judul": "Teknologi Terbaru"
}
```

### Delete Kategori
```
DELETE /api/kategori/{id}
```

## 2. Petugas API

### Get All Petugas
```
GET /api/petugas
```

### Create Petugas
```
POST /api/petugas
Content-Type: application/json

{
    "username": "admin",
    "password": "password123"
}
```

### Get Petugas by ID
```
GET /api/petugas/{id}
```

### Update Petugas
```
PUT /api/petugas/{id}
Content-Type: application/json

{
    "username": "admin_updated",
    "password": "newpassword123"
}
```

### Delete Petugas
```
DELETE /api/petugas/{id}
```

## 3. Posts API

### Get All Posts
```
GET /api/posts
```

### Create Post
```
POST /api/posts
Content-Type: application/json

{
    "judul": "Artikel Pertama",
    "kategori_id": 1,
    "isi": "Ini adalah isi artikel pertama",
    "petugas_id": 1,
    "status": "published"
}
```

### Get Post by ID
```
GET /api/posts/{id}
```

### Update Post
```
PUT /api/posts/{id}
Content-Type: application/json

{
    "judul": "Artikel Pertama Updated",
    "kategori_id": 1,
    "isi": "Ini adalah isi artikel pertama yang diupdate",
    "petugas_id": 1,
    "status": "published"
}
```

### Delete Post
```
DELETE /api/posts/{id}
```

## 4. Profile API

### Get All Profile
```
GET /api/profile
```

### Create Profile
```
POST /api/profile
Content-Type: application/json

{
    "judul": "Tentang Kami",
    "isi": "Ini adalah halaman tentang kami"
}
```

### Get Profile by ID
```
GET /api/profile/{id}
```

### Update Profile
```
PUT /api/profile/{id}
Content-Type: application/json

{
    "judul": "Tentang Kami Updated",
    "isi": "Ini adalah halaman tentang kami yang diupdate"
}
```

### Delete Profile
```
DELETE /api/profile/{id}
```

## 5. Galery API

### Get All Galery
```
GET /api/galery
```

### Create Galery
```
POST /api/galery
Content-Type: application/json

{
    "post_id": 1,
    "position": 1,
    "status": 1
}
```

### Get Galery by ID
```
GET /api/galery/{id}
```

### Update Galery
```
PUT /api/galery/{id}
Content-Type: application/json

{
    "post_id": 1,
    "position": 2,
    "status": 1
}
```

### Delete Galery
```
DELETE /api/galery/{id}
```

## 6. Foto API

### Get All Foto
```
GET /api/foto
```

### Create Foto
```
POST /api/foto
Content-Type: application/json

{
    "galery_id": 1,
    "file": "image1.jpg",
    "judul": "Foto Pertama"
}
```

### Get Foto by ID
```
GET /api/foto/{id}
```

### Update Foto
```
PUT /api/foto/{id}
Content-Type: application/json

{
    "galery_id": 1,
    "file": "image1_updated.jpg",
    "judul": "Foto Pertama Updated"
}
```

### Delete Foto
```
DELETE /api/foto/{id}
```

## Testing dengan Postman

1. **Buka Postman**
2. **Set Base URL**: `http://127.0.0.1:8000/api`
3. **Test setiap endpoint** sesuai dengan dokumentasi di atas
4. **Pastikan Content-Type**: `application/json` untuk POST dan PUT requests

## Sample Data untuk Testing

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

## Notes
- Semua response menggunakan format JSON
- Response success selalu memiliki field `success: true`
- Error response akan memiliki field `success: false` dan `message` dengan detail error
- Foreign key constraints sudah diatur dengan `ON DELETE CASCADE`
