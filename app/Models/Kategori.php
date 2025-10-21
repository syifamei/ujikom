<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    
    protected $fillable = [
        'nama',
        'deskripsi',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationships
    public function fotos()
    {
        return $this->hasMany(Foto::class, 'kategori_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'kategori_id');
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

    // Accessors & Mutators
    public function getNamaAttribute($value)
    {
        return ucwords($value);
    }

    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = strtolower($value);
    }

    // Methods
    public function isAktif()
    {
        return $this->status === 'Aktif';
    }

    public function getFotoCount()
    {
        return $this->fotos()->count();
    }

    public function getPostCount()
    {
        return $this->posts()->count();
    }
}
