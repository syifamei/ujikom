<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Komentar extends Model
{
    protected $fillable = [
        'galeri_id',
        'nama',
        'isi',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the galeri that owns the comment.
     */
    public function galeri(): BelongsTo
    {
        return $this->belongsTo(Galeri::class);
    }
}
