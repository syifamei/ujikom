<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoLike extends Model
{
    use HasFactory;

    protected $table = 'foto_likes';

    protected $fillable = [
        'foto_id',
        'user_id',
        'ip_address',
        'session_id'
    ];

    /**
     * Get the user who made this like
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the foto
     */
    public function foto(): BelongsTo
    {
        return $this->belongsTo(Foto::class);
    }
}





