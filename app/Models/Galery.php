<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Galery extends Model
{
    protected $table = 'galery';
    protected $fillable = ['post_id', 'position', 'status'];
    public $timestamps = false;

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(Foto::class, 'galery_id');
    }
}
