# Database Migration Instructions

## Error: Column 'username' not found

The error occurs because the database migrations haven't been run yet.

## Solution

Run the following command in your terminal:

```bash
cd c:\xampp\htdocs\ujikom
php artisan migrate
```

This will add the following columns to your `users` table:
- `username` (unique)
- `phone` (nullable)
- `status` (enum: Aktif/Nonaktif)
- `profile_photo_path` (nullable)
- `otp_code` (nullable)
- `otp_expires_at` (nullable)
- `is_active` (boolean)

## If You Get "Nothing to migrate" Message

If migrations were already run before, but some are missing, try:

```bash
php artisan migrate:fresh
```

⚠️ **WARNING**: This will drop all tables and recreate them. All data will be lost!

## If You Want to Keep Existing Data

Run migrations one by one:

```bash
php artisan migrate --path=/database/migrations/2025_10_09_100001_add_username_and_status_to_users_table.php
php artisan migrate --path=/database/migrations/2024_01_24_000000_add_otp_and_active_to_users_table.php
```

## Alternative: Make Username Optional (Quick Fix)

If you can't run migrations right now, update the RegisterController to make username optional:

In `app/Http/Controllers/Auth/RegisterController.php` line 46, change:

```php
'username' => $this->generateUsername($request->email),
```

To:

```php
'username' => null,
```

Then later run migrations to add the username column properly.
