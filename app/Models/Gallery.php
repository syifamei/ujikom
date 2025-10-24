<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path',
        'category',
        'uploaded_by'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the likes for the gallery
     */
    public function likes()
    {
        return $this->hasMany(GalleryLike::class, 'gallery_item_id');
    }

    /**
     * Get the comments for the gallery
     */
    public function comments()
    {
        return $this->hasMany(GalleryComment::class, 'gallery_item_id');
    }

    /**
     * Get the user who uploaded the gallery
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Get the full URL for the image
     */
    public function getImageUrlAttribute()
    {
        return Storage::url($this->image_path);
    }

    /**
     * Get the like count
     */
    public function getLikesCountAttribute()
    {
        return $this->likes()->where('type', 'like')->count();
    }

    /**
     * Get the comment count
     */
    public function getCommentsCountAttribute()
    {
        return $this->comments()->where('status', 'approved')->count();
    }

    /**
     * Check if gallery is liked by current IP
     */
    public function getIsLikedAttribute()
    {
        $ip = request()->ip();
        return $this->likes()->where('ip_address', $ip)->where('type', 'like')->exists();
    }
}
