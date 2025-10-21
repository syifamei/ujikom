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

class ApiDeleteEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_delete_kategori(): void
    {
        $kategori = Kategori::create(['judul' => 'Hapus']);

        $this->deleteJson('/api/kategori/' . $kategori->id)
            ->assertOk()
            ->assertJsonStructure(['success', 'message']);

        $this->assertDatabaseMissing('kategori', ['id' => $kategori->id]);
    }

    public function test_delete_petugas(): void
    {
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);

        $this->deleteJson('/api/petugas/' . $petugas->id)
            ->assertOk()
            ->assertJsonStructure(['success', 'message']);

        $this->assertDatabaseMissing('petugas', ['id' => $petugas->id]);
    }

    public function test_delete_post(): void
    {
        $kategori = Kategori::create(['judul' => 'A']);
        $petugas = Petugas::create(['username' => 'user_' . Str::random(6), 'password' => bcrypt('secret')]);
        $post = Post::create([
            'judul' => 'Del',
            'kategori_id' => $kategori->id,
            'isi' => 'Isi',
            'petugas_id' => $petugas->id,
            'status' => 'draft',
        ]);

        $this->deleteJson('/api/posts/' . $post->id)
            ->assertOk()
            ->assertJsonStructure(['success', 'message']);

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }

    public function test_delete_profile(): void
    {
        $profile = Profile::create(['judul' => 'Del', 'isi' => 'Isi']);

        $this->deleteJson('/api/profile/' . $profile->id)
            ->assertOk()
            ->assertJsonStructure(['success', 'message']);

        $this->assertDatabaseMissing('profile', ['id' => $profile->id]);
    }

    public function test_delete_galery(): void
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

        $this->deleteJson('/api/galery/' . $galery->id)
            ->assertOk()
            ->assertJsonStructure(['success', 'message']);

        $this->assertDatabaseMissing('galery', ['id' => $galery->id]);
    }

    public function test_delete_foto(): void
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
        $foto = Foto::create(['galery_id' => $galery->id, 'file' => 'del.jpg', 'judul' => 'Del']);

        $this->deleteJson('/api/foto/' . $foto->id)
            ->assertOk()
            ->assertJsonStructure(['success', 'message']);

        $this->assertDatabaseMissing('foto', ['id' => $foto->id]);
    }
}









