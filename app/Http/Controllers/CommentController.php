<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foto;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, Foto $foto)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'komentar' => 'required|string|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $userId = auth()->id();

            // Simpan komentar dengan status pending
            $comment = Comment::create([
                'foto_id' => $foto->id,
                'user_id' => $userId,
                'nama' => $request->nama,
                'komentar' => $request->komentar,
                'status' => 'pending',
                'ip_address' => $request->ip(),
                'created_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Komentar berhasil dikirim, menunggu persetujuan admin',
                'comment' => [
                    'id' => $comment->id,
                    'nama' => $comment->nama,
                    'komentar' => $comment->komentar,
                    'created_at' => $comment->created_at->format('d/m/Y H:i')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getApprovedComments($fotoId)
    {
        try {
            $foto = Foto::findOrFail($fotoId);
            
            $comments = Comment::where('foto_id', $fotoId)
                ->where('status', 'approved')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function($comment) {
                    return [
                        'id' => $comment->id,
                        'nama' => $comment->nama,
                        'komentar' => $comment->komentar,
                        'created_at' => $comment->created_at->format('d/m/Y H:i')
                    ];
                });

            return response()->json([
                'success' => true,
                'comments' => $comments,
                'total' => $comments->count()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
