<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Petugas;
use App\Models\Post;
use App\Models\Profile;
use App\Models\Galery;
use App\Models\Foto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ApiPostEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_post_kategori_create(): void
    {
        $payload = ['judul' => 'Teknologi'];

        $this->postJson('/api/kategori', $payload)
            ->assertCreated()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'judul']])
            ->assertJsonPath('data.judul', 'Teknologi');

        $this->assertDatabaseHas('kategori', ['judul' => 'Teknologi']);
    }

    public function test_post_petugas_create(): void
    {
        $username = 'user_' . Str::random(6);
        $payload = ['username' => $username, 'password' => 'secret123'];

        $this->postJson('/api/petugas', $payload)
            ->assertCreated()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'username']])
            ->assertJsonPath('data.username', $username);

        $this->assertDatabaseHas('petugas', ['username' => $username]);
    }

    public function test_post_posts_create(): void
    {
        $kategori = Kategori::create(['judul' => 'Kategori A']);
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);

        $payload = [
            'judul' => 'Judul Post',
            'kategori_id' => $kategori->id,
            'isi' => 'Isi konten',
            'petugas_id' => $petugas->id,
            'status' => 'draft',
        ];

        $this->postJson('/api/posts', $payload)
            ->assertCreated()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'judul', 'kategori_id', 'petugas_id', 'status']])
            ->assertJsonPath('data.judul', 'Judul Post');

        $this->assertDatabaseHas('posts', ['judul' => 'Judul Post', 'kategori_id' => $kategori->id, 'petugas_id' => $petugas->id]);
    }

    public function test_post_profile_create(): void
    {
        $payload = ['judul' => 'Tentang Kami', 'isi' => 'Deskripsi singkat'];

        $this->postJson('/api/profile', $payload)
            ->assertCreated()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'judul', 'isi']])
            ->assertJsonPath('data.judul', 'Tentang Kami');

        $this->assertDatabaseHas('profile', ['judul' => 'Tentang Kami']);
    }

    public function test_post_galery_create(): void
    {
        $kategori = Kategori::create(['judul' => 'Kategori B']);
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);
        $post = Post::create([
            'judul' => 'Postingan',
            'kategori_id' => $kategori->id,
            'isi' => 'Isi',
            'petugas_id' => $petugas->id,
            'status' => 'draft',
        ]);

        $payload = ['post_id' => $post->id, 'position' => 1, 'status' => 1];

        $this->postJson('/api/galery', $payload)
            ->assertCreated()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'post_id', 'position', 'status']])
            ->assertJsonPath('data.post_id', $post->id);

        $this->assertDatabaseHas('galery', ['post_id' => $post->id, 'position' => 1, 'status' => 1]);
    }

    public function test_post_foto_create(): void
    {
        $kategori = Kategori::create(['judul' => 'Kategori C']);
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);
        $post = Post::create([
            'judul' => 'Postingan',
            'kategori_id' => $kategori->id,
            'isi' => 'Isi',
            'petugas_id' => $petugas->id,
            'status' => 'draft',
        ]);
        $galery = Galery::create(['post_id' => $post->id, 'position' => 1, 'status' => 1]);

        $payload = ['galery_id' => $galery->id, 'file' => 'file.jpg', 'judul' => 'Sampul'];

        $this->postJson('/api/foto', $payload)
            ->assertCreated()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'galery_id', 'file', 'judul']])
            ->assertJsonPath('data.galery_id', $galery->id);

        $this->assertDatabaseHas('foto', ['galery_id' => $galery->id, 'file' => 'file.jpg']);
    }
}










