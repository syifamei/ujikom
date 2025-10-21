<?php

namespace Tests\Feature;

use App\Models\Foto;
use App\Models\Galery;
use App\Models\Kategori;
use App\Models\Petugas;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ApiGetEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_kategori_index_and_show(): void
    {
        $kategori = Kategori::create(['judul' => 'Teknologi']);

        $this->getJson('/api/kategori')->assertOk()->assertJsonStructure(['success', 'data']);
        $this->getJson('/api/kategori/' . $kategori->id)->assertOk()->assertJsonStructure(['success', 'data']);
    }

    public function test_get_petugas_index_and_show(): void
    {
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);

        $this->getJson('/api/petugas')->assertOk()->assertJsonStructure(['success', 'data']);
        $this->getJson('/api/petugas/' . $petugas->id)->assertOk()->assertJsonStructure(['success', 'data']);
    }

    public function test_get_posts_index_and_show(): void
    {
        $kategori = Kategori::create(['judul' => 'Pendidikan']);
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);
        $post = Post::create([
            'judul' => 'Judul Post',
            'kategori_id' => $kategori->id,
            'isi' => 'Isi konten',
            'petugas_id' => $petugas->id,
            'status' => 'draft',
        ]);

        $this->getJson('/api/posts')->assertOk()->assertJsonStructure(['success', 'data']);
        $this->getJson('/api/posts/' . $post->id)->assertOk()->assertJsonStructure(['success', 'data']);
    }

    public function test_get_profile_index_and_show(): void
    {
        $profile = Profile::create(['judul' => 'Tentang Kami', 'isi' => 'Deskripsi']);

        $this->getJson('/api/profile')->assertOk()->assertJsonStructure(['success', 'data']);
        $this->getJson('/api/profile/' . $profile->id)->assertOk()->assertJsonStructure(['success', 'data']);
    }

    public function test_get_galery_index_and_show(): void
    {
        $kategori = Kategori::create(['judul' => 'Olahraga']);
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);
        $post = Post::create([
            'judul' => 'Postingan',
            'kategori_id' => $kategori->id,
            'isi' => 'Isi',
            'petugas_id' => $petugas->id,
            'status' => 'draft',
        ]);
        $galery = Galery::create(['post_id' => $post->id, 'position' => 1, 'status' => 1]);

        $this->getJson('/api/galery')->assertOk()->assertJsonStructure(['success', 'data']);
        $this->getJson('/api/galery/' . $galery->id)->assertOk()->assertJsonStructure(['success', 'data']);
    }

    public function test_get_foto_index_and_show(): void
    {
        $kategori = Kategori::create(['judul' => 'Teknologi']);
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);
        $post = Post::create([
            'judul' => 'Postingan',
            'kategori_id' => $kategori->id,
            'isi' => 'Isi',
            'petugas_id' => $petugas->id,
            'status' => 'draft',
        ]);
        $galery = Galery::create(['post_id' => $post->id, 'position' => 1, 'status' => 1]);
        $foto = Foto::create(['galery_id' => $galery->id, 'file' => 'file.jpg', 'judul' => 'Sampul']);

        $this->getJson('/api/foto')->assertOk()->assertJsonStructure(['success', 'data']);
        $this->getJson('/api/foto/' . $foto->id)->assertOk()->assertJsonStructure(['success', 'data']);
    }
}


