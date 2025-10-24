<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foto;
use App\Models\FotoLike;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
    public function store(Request $request, Foto $foto)
    {
        try {
            $ip = $request->ip();
            $sessionId = session()->getId();
            $userId = auth()->id();

            // Cek apakah user sudah like foto ini
            $existingLike = FotoLike::where('foto_id', $foto->id)
                ->where(function($query) use ($userId, $ip, $sessionId) {
                    if ($userId) {
                        $query->where('user_id', $userId);
                    } else {
                        $query->where('ip_address', $ip)
                              ->orWhere('session_id', $sessionId);
                    }
                })
                ->first();

            if ($existingLike) {
                // Unlike - hapus like yang ada
                $existingLike->delete();
                $action = 'unliked';
            } else {
                // Like - tambah like baru
                FotoLike::create([
                    'foto_id' => $foto->id,
                    'user_id' => $userId,
                    'ip_address' => $ip,
                    'session_id' => $sessionId,
                    'created_at' => now()
                ]);
                $action = 'liked';
            }

            // Hitung total like terbaru
            $totalLikes = FotoLike::where('foto_id', $foto->id)->count();

            return response()->json([
                'success' => true,
                'action' => $action,
                'total_likes' => $totalLikes,
                'message' => $action === 'liked' ? 'Foto berhasil di-like!' : 'Like berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
