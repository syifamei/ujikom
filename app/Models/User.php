<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'status',
        'profile_photo_path',
        'otp_code',
        'otp_expires_at',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'otp_expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];
    
    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];
    
    /**
     * Get the URL to the user's profile photo.
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo_path
                    ? asset('storage/'.$this->profile_photo_path)
                    : $this->defaultProfilePhotoUrl();
    }
    
    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     */
    protected function defaultProfilePhotoUrl(): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=7F9CF5&background=EBF4FF';
    }
    
    /**
     * Get the likes for the user.
     */
    public function likes()
    {
        return $this->belongsToMany(Foto::class, 'foto_likes', 'user_id', 'foto_id')
            ->withTimestamps();
    }
    
    /**
     * Get the comments for the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    
    /**
     * Get the download logs for the user.
     */
    public function downloadLogs()
    {
        return $this->hasMany(DownloadLog::class);
    }

    /**
     * Get the galleries for the user.
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Get the gallery items for the user.
     */
    public function galleryItems()
    {
        return $this->hasManyThrough(GalleryItem::class, Gallery::class);
    }

    /**
     * Generate OTP code for user verification.
     */
    public function generateOtpCode(): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $this->otp_code = $otp;
        $this->otp_expires_at = now()->addMinutes(10); // OTP valid for 10 minutes
        $this->save();
        
        return $otp;
    }

    /**
     * Verify OTP code.
     */
    public function verifyOtpCode(string $otp): bool
    {
        if (!$this->otp_code || !$this->otp_expires_at) {
            return false;
        }

        if ($this->otp_expires_at->isPast()) {
            return false;
        }

        return $this->otp_code === $otp;
    }

    /**
     * Clear OTP code after verification.
     */
    public function clearOtpCode(): void
    {
        $this->otp_code = null;
        $this->otp_expires_at = null;
        $this->save();
    }

    /**
     * Activate user account.
     */
    public function activate(): void
    {
        $this->is_active = true;
        $this->clearOtpCode();
    }
}
