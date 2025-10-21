<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use App\Models\FotoLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    /**
     * Get like count for a photo
     */
    public function index(Foto $foto)
    {
        $userId = Auth::id();
        $ipAddress = request()->ip();
        $sessionId = session()->getId();
        
        // Check if current visitor has liked this photo
        $isLiked = false;
        if ($userId) {
            $isLiked = $foto->isLikedBy($userId);
        } else {
            // Check by IP or session for non-logged users
            $isLiked = $foto->likes()
                ->where(function($query) use ($ipAddress, $sessionId) {
                    $query->where('ip_address', $ipAddress)
                          ->orWhere('session_id', $sessionId);
                })
                ->exists();
        }
        
        return response()->json([
            'likes_count' => $foto->likes()->count(),
            'is_liked' => $isLiked
        ]);
    }

    /**
     * Toggle like for a photo (works for both logged and non-logged users)
     */
    public function toggle(Request $request, Foto $foto)
    {
        $userId = Auth::id();
        $ipAddress = $request->ip();
        $sessionId = session()->getId();
        
        return DB::transaction(function () use ($userId, $ipAddress, $sessionId, $foto) {
            // Check existing like
            $existingLike = null;
            if ($userId) {
                $existingLike = $foto->likes()->where('user_id', $userId)->first();
            } else {
                $existingLike = $foto->likes()
                    ->where(function($query) use ($ipAddress, $sessionId) {
                        $query->where('ip_address', $ipAddress)
                              ->orWhere('session_id', $sessionId);
                    })
                    ->first();
            }
            
            if ($existingLike) {
                // Remove the like (unlike)
                $existingLike->delete();
                $isLiked = false;
                $message = 'Photo unliked';
            } else {
                // Add new like
                $foto->likes()->create([
                    'user_id' => $userId,
                    'ip_address' => $userId ? null : $ipAddress,
                    'session_id' => $userId ? null : $sessionId,
                ]);
                $isLiked = true;
                $message = 'Photo liked';
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'likes_count' => $foto->likes()->count(),
                'is_liked' => $isLiked
            ]);
        });
    }
}
