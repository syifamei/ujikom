<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Informasi extends Model
{
    use HasFactory;

    protected $table = 'informasi';
    
    protected $fillable = [
        'judul',
        'deskripsi',
        'konten',
        'gambar',
        'status',
        'tanggal_posting',
        'admin_id'
    ];

    protected $casts = [
        'tanggal_posting' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

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
                    ->orderBy('tanggal_posting', 'desc')
                    ->limit($limit);
    }

    // Accessors & Mutators (preserve exact input)
    public function getJudulAttribute($value)
    {
        return $value;
    }

    public function setJudulAttribute($value)
    {
        $this->attributes['judul'] = $value;
    }

    // Methods
    public function isAktif()
    {
        return $this->status === 'Aktif';
    }

    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/informasi/' . $this->gambar);
        }
        return asset('images/default-informasi.jpg');
    }

    public function getExcerptAttribute($length = 150)
    {
        return \Str::limit(strip_tags($this->konten), $length);
    }
}


