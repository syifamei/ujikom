<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_item_id',
        'user_id',
        'ip_address',
        'session_id',
        'type'
    ];

    /**
     * Get the gallery that owns the like
     */
    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_item_id');
    }
}