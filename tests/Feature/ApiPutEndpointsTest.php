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

class ApiPutEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_put_kategori_update(): void
    {
        $kategori = Kategori::create(['judul' => 'Lama']);
        $payload = ['judul' => 'Baru'];

        $this->putJson('/api/kategori/' . $kategori->id, $payload)
            ->assertOk()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'judul']])
            ->assertJsonPath('data.judul', 'Baru');

        $this->assertDatabaseHas('kategori', ['id' => $kategori->id, 'judul' => 'Baru']);
    }

    public function test_put_petugas_update(): void
    {
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);
        $newName = 'user_' . Str::random(6);
        $payload = ['username' => $newName];

        $this->putJson('/api/petugas/' . $petugas->id, $payload)
            ->assertOk()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'username']])
            ->assertJsonPath('data.username', $newName);

        $this->assertDatabaseHas('petugas', ['id' => $petugas->id, 'username' => $newName]);
    }

    public function test_put_posts_update(): void
    {
        $kategoriA = Kategori::create(['judul' => 'A']);
        $kategoriB = Kategori::create(['judul' => 'B']);
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);
        $post = Post::create([
            'judul' => 'Awal',
            'kategori_id' => $kategoriA->id,
            'isi' => 'Isi awal',
            'petugas_id' => $petugas->id,
            'status' => 'draft',
        ]);

        $payload = [
            'judul' => 'Update',
            'kategori_id' => $kategoriB->id,
            'isi' => 'Isi update',
            'petugas_id' => $petugas->id,
            'status' => 'published',
        ];

        $this->putJson('/api/posts/' . $post->id, $payload)
            ->assertOk()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'judul', 'kategori_id', 'petugas_id', 'status']])
            ->assertJsonPath('data.judul', 'Update')
            ->assertJsonPath('data.kategori_id', $kategoriB->id);

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'judul' => 'Update', 'kategori_id' => $kategoriB->id]);
    }

    public function test_put_profile_update(): void
    {
        $profile = Profile::create(['judul' => 'Lama', 'isi' => 'Isi lama']);
        $payload = ['judul' => 'Baru', 'isi' => 'Isi baru'];

        $this->putJson('/api/profile/' . $profile->id, $payload)
            ->assertOk()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'judul', 'isi']])
            ->assertJsonPath('data.judul', 'Baru');

        $this->assertDatabaseHas('profile', ['id' => $profile->id, 'judul' => 'Baru', 'isi' => 'Isi baru']);
    }

    public function test_put_galery_update(): void
    {
        $kategori = Kategori::create(['judul' => 'A']);
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);
        $post = Post::create([
            'judul' => 'Post',
            'kategori_id' => $kategori->id,
            'isi' => 'Isi',
            'petugas_id' => $petugas->id,
            'status' => 'draft',
        ]);
        $galery = Galery::create(['post_id' => $post->id, 'position' => 1, 'status' => 1]);

        $payload = ['post_id' => $post->id, 'position' => 2, 'status' => 0];

        $this->putJson('/api/galery/' . $galery->id, $payload)
            ->assertOk()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'post_id', 'position', 'status']])
            ->assertJsonPath('data.position', 2)
            ->assertJsonPath('data.status', 0);

        $this->assertDatabaseHas('galery', ['id' => $galery->id, 'position' => 2, 'status' => 0]);
    }

    public function test_put_foto_update(): void
    {
        $kategori = Kategori::create(['judul' => 'A']);
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);
        $post = Post::create([
            'judul' => 'Post',
            'kategori_id' => $kategori->id,
            'isi' => 'Isi',
            'petugas_id' => $petugas->id,
            'status' => 'draft',
        ]);
        $galery = Galery::create(['post_id' => $post->id, 'position' => 1, 'status' => 1]);
        $foto = Foto::create(['galery_id' => $galery->id, 'file' => 'awal.jpg', 'judul' => 'Awal']);

        $payload = ['galery_id' => $galery->id, 'file' => 'update.jpg', 'judul' => 'Update'];

        $this->putJson('/api/foto/' . $foto->id, $payload)
            ->assertOk()
            ->assertJsonStructure(['success', 'message', 'data' => ['id', 'galery_id', 'file', 'judul']])
            ->assertJsonPath('data.file', 'update.jpg')
            ->assertJsonPath('data.judul', 'Update');

        $this->assertDatabaseHas('foto', ['id' => $foto->id, 'file' => 'update.jpg', 'judul' => 'Update']);
    }
}









