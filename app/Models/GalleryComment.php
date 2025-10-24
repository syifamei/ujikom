<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GalleryComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gallery_item_id',
        'user_id',
        'name',
        'email',
        'content',
        'status'
    ];

    /**
     * Get the gallery that owns the comment
     */
    public function gallery()
    {
        return $this->belongsTo(Gallery::class, 'gallery_item_id');
    }
}