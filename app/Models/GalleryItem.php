<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GalleryItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'image_path',
        'description',
        'status'
    ];

    /**
     * Get all likes for this gallery item
     */
    public function likes(): HasMany
    {
        return $this->hasMany(GalleryLike::class);
    }

    /**
     * Get all comments for this gallery item
     */
    public function comments(): HasMany
    {
        return $this->hasMany(GalleryComment::class);
    }

    /**
     * Get approved comments only
     */
    public function approvedComments(): HasMany
    {
        return $this->hasMany(GalleryComment::class)->where('status', 'approved');
    }

    /**
     * Get all downloads for this gallery item
     */
    public function downloads(): HasMany
    {
        return $this->hasMany(GalleryDownload::class);
    }

    /**
     * Get like count
     */
    public function getLikeCountAttribute(): int
    {
        return $this->likes()->where('type', 'like')->count();
    }

    /**
     * Get dislike count
     */
    public function getDislikeCountAttribute(): int
    {
        return $this->likes()->where('type', 'dislike')->count();
    }

    /**
     * Get download count
     */
    public function getDownloadCountAttribute(): int
    {
        return $this->downloads()->count();
    }

    /**
     * Get comment count
     */
    public function getCommentCountAttribute(): int
    {
        return $this->approvedComments()->count();
    }

    /**
     * Check if user has liked/disliked this item
     */
    public function userReaction($userId = null, $ipAddress = null, $sessionId = null)
    {
        $query = $this->likes();
        
        if ($userId) {
            $query->where('user_id', $userId);
        } elseif ($ipAddress) {
            $query->where('ip_address', $ipAddress);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        }
        
        return $query->first();
    }
}


