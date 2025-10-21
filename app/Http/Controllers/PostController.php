<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $post = Post::create([
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Informasi berhasil ditambahkan!');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'judul' => 'sometimes|required|string|max:255',
            'isi' => 'sometimes|required|string',
        ]);

        $post->fill($validated);
        $post->save();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Informasi berhasil diupdate!');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index')
            ->with('success', 'Informasi berhasil dihapus!');
    }

    // API methods for backward compatibility
    public function apiIndex(): JsonResponse
    {
        $posts = Post::all();
        return response()->json([
            'success' => true,
            'data' => $posts,
        ]);
    }

    public function apiStore(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $post = Post::create([
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil dibuat',
            'data' => $post,
        ], 201);
    }

    public function apiShow(Post $post): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $post,
        ]);
    }

    public function apiUpdate(Request $request, Post $post): JsonResponse
    {
        $validated = $request->validate([
            'judul' => 'sometimes|required|string|max:255',
            'isi' => 'sometimes|required|string',
        ]);

        $post->fill($validated);
        $post->save();

        return response()->json([
            'success' => true,
            'message' => 'Post berhasil diupdate',
            'data' => $post,
        ]);
    }

    public function apiDestroy(Post $post): JsonResponse
    {
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Post berhasil dihapus',
        ]);
    }
}
