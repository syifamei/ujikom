<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Get comments for a photo
     */
    public function index(Foto $foto)
    {
        $comments = $foto->comments()
            ->where('status', 'approved')
            ->with('user')
            ->latest()
            ->get()
            ->map(function($comment) {
                $commenterName = $comment->user ? $comment->user->name : $comment->author_name;
                $commenterAvatar = $comment->user ? 
                    'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=random' :
                    'https://ui-avatars.com/api/?name=' . urlencode($comment->author_name ?? 'Anonymous') . '&background=random';
                    
                return [
                    'id' => $comment->id,
                    'content' => $comment->content,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'user' => [
                        'name' => $commenterName,
                        'avatar' => $commenterAvatar
                    ]
                ];
            });

        return response()->json($comments);
    }

    /**
     * Store a new comment (works for both logged and non-logged users)
     */
    public function store(Request $request, Foto $foto)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:500',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $userId = Auth::id();
        
        $comment = $foto->comments()->create([
            'user_id' => $userId,
            'author_name' => $userId ? null : $request->name,
            'content' => $request->content,
            'status' => 'pending', // Comments need admin approval
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        $commenterName = $userId ? Auth::user()->name : $request->name;
        $commenterAvatar = $userId ? 
            'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=random' :
            'https://ui-avatars.com/api/?name=' . urlencode($request->name ?? 'Anonymous') . '&background=random';

        return response()->json([
            'message' => 'Komentar berhasil dikirim dan menunggu persetujuan admin',
            'comment' => [
                'id' => $comment->id,
                'content' => $comment->content,
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => [
                    'name' => $commenterName,
                    'avatar' => $commenterAvatar
                ]
            ]
        ], 201);
    }
}
