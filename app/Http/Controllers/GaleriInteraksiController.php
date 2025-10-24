<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\Like;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriInteraksiController extends Controller
{
    /**
     * Handle like/unlike action
     */
    public function like(Request $request)
    {
        $request->validate([
            'galeri_id' => 'required|exists:galeri,id',
        ]);

        $galeriId = $request->galeri_id;
        $sessionId = session()->getId();

        // Check if already liked
        $existingLike = Like::where('galeri_id', $galeriId)
            ->where('session_id', $sessionId)
            ->first();

        if ($existingLike) {
            // Unlike
            $existingLike->delete();
            $liked = false;
        } else {
            // Like
            Like::create([
                'galeri_id' => $galeriId,
                'session_id' => $sessionId,
            ]);
            $liked = true;
        }

        $totalLikes = Like::where('galeri_id', $galeriId)->count();

        return response()->json([
            'liked' => $liked,
            'totalLikes' => $totalLikes
        ]);
    }

    /**
     * Store a new comment
     */
    public function komentar(Request $request)
    {
        $validated = $request->validate([
            'galeri_id' => 'required|exists:galeri,id',
            'nama' => 'required|string|max:100',
            'isi' => 'required|string|max:1000',
        ]);

        Komentar::create([
            'galeri_id' => $validated['galeri_id'],
            'nama' => $validated['nama'],
            'isi' => $validated['isi'],
            'status' => 'pending',
        ]);

        return response()->json([
            'message' => 'Komentar Anda telah dikirim dan menunggu persetujuan admin.'
        ]);
    }

    /**
     * Download a photo
     */
    public function download($id)
    {
        $galeri = Galeri::findOrFail($id);
        
        if (!Storage::exists($galeri->path)) {
            abort(404, 'File tidak ditemukan.');
        }

        return Storage::download($galeri->path, 
            Str::slug($galeri->judul) . '.' . pathinfo($galeri->path, PATHINFO_EXTENSION));
    }
}
