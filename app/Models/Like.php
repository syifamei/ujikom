<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    protected $fillable = [
        'galeri_id',
        'session_id',
    ];

    /**
     * Get the galeri that owns the like.
     */
    public function galeri(): BelongsTo
    {
        return $this->belongsTo(Galeri::class);
    }
}
