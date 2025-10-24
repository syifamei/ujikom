<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agendas';
    
    protected $fillable = [
        'title',
        'description',
        'scheduled_at',
        'photo_path',
        'status'
    ];
    
    protected $casts = [
        'scheduled_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships - removed admin relationship since admin_id column doesn't exist

    // Scopes
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    public function scopeNonaktif($query)
    {
        return $query->where('status', 'Nonaktif');
    }

    public function scopeTerbaru($query, $limit = 6)
    {
        return $query->where('status', 'Aktif')
                    ->orderBy('tanggal', 'desc')
                    ->limit($limit);
    }

    // Methods
    public function isAktif()
    {
        return $this->status === 'Aktif';
    }

    public function getExcerptAttribute($length = 150)
    {
        return \Str::limit(strip_tags($this->deskripsi), $length);
    }
}


