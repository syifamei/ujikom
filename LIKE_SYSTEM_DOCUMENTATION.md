# Dokumentasi Sistem Like Per User

## Overview
Sistem like per user yang terintegrasi dengan database, menampilkan jumlah like real-time dari semua user yang sudah login.

## Arsitektur Sistem

### 1. Database Structure

#### Tabel: `foto_likes`
```sql
- id (bigint, primary key)
- foto_id (bigint, foreign key -> foto.id)
- user_id (bigint, foreign key -> users.id)
- ip_address (nullable)
- session_id (nullable)
- created_at (timestamp)
- updated_at (timestamp)

UNIQUE INDEX: (foto_id, user_id) -- Satu user hanya bisa like 1x per foto
```

#### Relasi Database
- `foto_likes.foto_id` → `foto.id` (CASCADE on delete)
- `foto_likes.user_id` → `users.id` (CASCADE on delete)

### 2. Backend Implementation

#### Model: `FotoLike.php`
```php
protected $fillable = [
    'foto_id',
    'user_id',
    'ip_address',
    'session_id'
];

// Relationships
public function user(): BelongsTo
public function foto(): BelongsTo
```

#### Model: `Foto.php`
```php
// Relationship
public function likes() {
    return $this->hasMany(FotoLike::class, 'foto_id');
}

// Helper methods
public function isLikedBy($userId)
public function isLikedByUser()
```

#### Controller: `GaleriController.php`

##### Method: `index()`
```php
// Load foto dengan count likes dari database
$query = Foto::with(['kategori'])
    ->withCount('likes as likes_count')  // Count dari database
    ->where('status', 'Aktif')
    ->when($user, function($q) use ($user) {
        // Load status like user saat ini
        $q->with(['likes' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }]);
    });

// Set is_liked status untuk setiap foto
$fotos->each(function($foto) use ($user) {
    if ($user) {
        $foto->is_liked = $foto->likes->contains('user_id', $user->id);
    } else {
        $foto->is_liked = false;
    }
});
```

##### Method: `likePhoto($id)`
```php
// Cek authentication
if (!auth()->check()) {
    return response()->json([
        'success' => false,
        'redirect' => route('register'),
        'message' => 'Silakan login atau daftar terlebih dahulu'
    ], 401);
}

$foto = Foto::findOrFail($id);
$user = auth()->user();

// Cek existing like
$existingLike = $foto->likes()->where('user_id', $user->id)->first();

if ($existingLike) {
    // Unlike
    $existingLike->delete();
    $isLiked = false;
    $message = 'Like dihapus';
} else {
    // Like
    $foto->likes()->create([
        'user_id' => $user->id,
        'ip_address' => request()->ip(),
    ]);
    $isLiked = true;
    $message = 'Berhasil menyukai foto';
}

return response()->json([
    'success' => true,
    'message' => $message,
    'likes_count' => $foto->likes()->count(),  // Count real-time dari database
    'is_liked' => $isLiked
]);
```

### 3. Frontend Implementation

#### HTML (galeri.blade.php)
```blade
<!-- Like Button -->
<button type="button" 
    onclick="event.stopPropagation(); handleLike({{ $foto->id }}, this)" 
    class="card-action-btn {{ $foto->is_liked ? 'liked' : '' }}" 
    data-foto-id="{{ $foto->id }}">
    <i class="{{ $foto->is_liked ? 'fas' : 'far' }} fa-heart"></i>
    <span class="like-count">{{ $foto->likes_count ?? 0 }}</span>
</button>
```

**Penjelasan:**
- `{{ $foto->likes_count }}` → Total like dari SEMUA user (dari database)
- `{{ $foto->is_liked }}` → Status like user saat ini (true/false)
- `fas fa-heart` → Heart solid (merah) jika sudah like
- `far fa-heart` → Heart outline (abu) jika belum like

#### JavaScript (galeri.blade.php)
```javascript
function handleLike(fotoId, button) {
    // 1. Check authentication
    if (!isAuthenticated) {
        showNotification('Silakan login atau daftar terlebih dahulu', 'error');
        setTimeout(() => {
            window.location.href = '/register';
        }, 1500);
        return;
    }

    // 2. Disable button (prevent double click)
    button.disabled = true;

    // 3. Send AJAX request
    fetch(`/galeri/like/${fotoId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // 4. Update like count (real-time dari database)
            const likeCount = button.querySelector('.like-count');
            likeCount.textContent = data.likes_count;
            
            // 5. Update visual state
            const icon = button.querySelector('i');
            if (data.is_liked) {
                button.classList.add('liked');
                icon.className = 'fas fa-heart';  // Solid red
            } else {
                button.classList.remove('liked');
                icon.className = 'far fa-heart';  // Outline gray
            }
            
            showNotification(data.message, 'success');
        }
    })
    .finally(() => {
        button.disabled = false;  // Re-enable button
    });
}
```

### 4. Routing (web.php)
```php
// Like route (requires authentication check in controller)
Route::post('/galeri/like/{id}', [GaleriController::class, 'likePhoto'])
    ->name('galeri.like.photo');
```

## Fitur-Fitur Utama

### ✅ Persistent Storage
- Like disimpan di database tabel `foto_likes`
- Data tidak hilang saat refresh atau close browser
- Relasi dengan `user_id` dan `foto_id`

### ✅ Real-Time Update
- Jumlah like update otomatis tanpa reload halaman
- Menggunakan AJAX untuk komunikasi dengan server
- Response JSON berisi `likes_count` terbaru dari database

### ✅ Unique Constraint
- Satu user hanya bisa like 1x per foto
- Enforced di database level dengan UNIQUE INDEX
- Prevent duplicate likes

### ✅ User Authentication
- Like hanya bisa dilakukan oleh user yang sudah login
- Redirect ke halaman register jika belum login
- Tracking user yang like dengan `user_id`

### ✅ Visual Feedback
- Heart icon berubah dari outline ke solid saat like
- Warna berubah merah (#ef4444) saat liked
- Animasi smooth transition
- Notification popup sukses/error

### ✅ Count Accuracy
- `likes_count` = Total dari SEMUA user di database
- Count via `withCount('likes as likes_count')` (Eloquent)
- Bukan dari session atau localStorage

## Flow Diagram

```
User Click Like Button
    ↓
Check isAuthenticated?
    ↓ No → Redirect to Register
    ↓ Yes
Send POST /galeri/like/{id}
    ↓
GaleriController::likePhoto()
    ↓
Check Existing Like in DB
    ↓
If Exists → Delete (Unlike)
If Not → Create (Like)
    ↓
Count Total Likes from DB
    ↓
Return JSON Response
    ↓
Frontend Update UI
    ↓
Show Notification
```

## Testing Checklist

### Test Case 1: Like Without Login
1. ❌ Belum login
2. Click like button
3. ✅ Muncul notifikasi "Silakan login atau daftar"
4. ✅ Redirect ke halaman register

### Test Case 2: Like With Login
1. ✅ Sudah login
2. Click like button
3. ✅ Heart icon berubah dari outline ke solid
4. ✅ Warna berubah merah
5. ✅ Counter bertambah 1
6. ✅ Muncul notifikasi "Berhasil menyukai foto"

### Test Case 3: Unlike
1. ✅ Sudah like sebelumnya
2. Click like button lagi
3. ✅ Heart icon berubah dari solid ke outline
4. ✅ Warna berubah gray
5. ✅ Counter berkurang 1
6. ✅ Muncul notifikasi "Like dihapus"

### Test Case 4: Multiple Users
1. ✅ User A like foto → Counter = 1
2. ✅ User B like foto → Counter = 2
3. ✅ User C like foto → Counter = 3
4. ✅ User A unlike → Counter = 2
5. ✅ Total count akurat dari database

### Test Case 5: Page Refresh
1. ✅ Like foto (counter = 5)
2. ✅ Refresh halaman (Ctrl+F5)
3. ✅ Counter masih 5 (data dari database)
4. ✅ Heart icon masih merah (is_liked = true)

### Test Case 6: Prevent Double Like
1. ✅ User A like foto
2. ❌ User A coba like lagi (via API/console)
3. ✅ Database reject (UNIQUE constraint)
4. ✅ Counter tidak double count

## Troubleshooting

### Problem: Like count = 0 padahal sudah ada yang like
**Solution:** 
- Check query di controller: `->withCount('likes as likes_count')`
- Check relasi di Model Foto: `public function likes()`
- Check tabel `foto_likes` di database

### Problem: Like button tidak klik
**Solution:**
- Check browser console untuk error
- Pastikan `@stack('scripts')` ada di layout
- Check CSRF token: `<meta name="csrf-token" content="{{ csrf_token() }}">`

### Problem: Multiple user like tidak terakumulasi
**Solution:**
- Check unique constraint di migration
- Pastikan pakai `user_id` bukan `session_id`
- Verify di tabel: `SELECT * FROM foto_likes WHERE foto_id = X`

## Database Queries untuk Monitoring

### Cek total likes per foto
```sql
SELECT foto_id, COUNT(*) as total_likes 
FROM foto_likes 
GROUP BY foto_id 
ORDER BY total_likes DESC;
```

### Cek user yang like foto tertentu
```sql
SELECT u.name, u.email, fl.created_at 
FROM foto_likes fl
JOIN users u ON fl.user_id = u.id
WHERE fl.foto_id = 1
ORDER BY fl.created_at DESC;
```

### Cek foto yang paling banyak dilike
```sql
SELECT f.judul, COUNT(fl.id) as likes
FROM foto f
LEFT JOIN foto_likes fl ON f.id = fl.foto_id
WHERE f.status = 'Aktif'
GROUP BY f.id
ORDER BY likes DESC
LIMIT 10;
```

## Maintenance

### Clear all likes (reset)
```sql
TRUNCATE TABLE foto_likes;
```

### Remove duplicate likes (jika ada bug)
```sql
DELETE fl1 FROM foto_likes fl1
INNER JOIN foto_likes fl2 
WHERE fl1.id > fl2.id 
AND fl1.foto_id = fl2.foto_id 
AND fl1.user_id = fl2.user_id;
```

## Security Considerations

1. ✅ CSRF Protection (Laravel token)
2. ✅ Authentication required
3. ✅ SQL Injection protected (Eloquent ORM)
4. ✅ XSS protected (Blade escaping)
5. ✅ Rate limiting (optional - bisa ditambah middleware)

## Performance Optimization

1. **Database Index**
   ```sql
   INDEX on (foto_id, user_id)
   INDEX on (foto_id)
   ```

2. **Eager Loading**
   ```php
   ->withCount('likes as likes_count')  // Avoid N+1 query
   ```

3. **Caching** (optional)
   ```php
   Cache::remember("foto_{$id}_likes", 60, function() {
       return $foto->likes()->count();
   });
   ```

---

**Version:** 1.0  
**Last Updated:** October 26, 2025  
**Author:** Cascade AI Assistant
