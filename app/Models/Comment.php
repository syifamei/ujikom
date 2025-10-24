<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'foto_comments';
    
    protected $fillable = [
        'foto_id',
        'user_id',
        'author_name',
        'content',
        'status',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the foto that owns the comment
     */
    public function foto()
    {
        return $this->belongsTo(Foto::class, 'foto_id');
    }

    /**
     * Get the user who made the comment
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the commenter name (author_name or user name)
     */
    public function getCommenterNameAttribute()
    {
        return $this->author_name ?? $this->user?->name ?? 'Anonim';
    }
}