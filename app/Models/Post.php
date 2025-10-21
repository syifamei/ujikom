<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['judul', 'isi'];
    
    // Enable timestamps since the migration has these fields
    public $timestamps = true;
    
    // Cast date fields to Carbon instances
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function galeries(): HasMany
    {
        return $this->hasMany(Galery::class, 'post_id');
    }
}
