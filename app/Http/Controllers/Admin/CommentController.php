<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function moderation()
    {
        return view('admin.comments.moderation');
    }
    /**
     * Get pending comments
     */
    public function pending()
    {
        $comments = Comment::with(['user', 'foto'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }

    /**
     * Get approved comments
     */
    public function approved()
    {
        $comments = Comment::with(['user', 'foto'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }

    /**
     * Get pending comments count
     */
    public function pendingCount()
    {
        $count = Comment::where('status', 'pending')->count();

        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Moderate a comment (approve/reject)
     */
    public function moderate(Request $request, Comment $comment)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $comment->update([
            'status' => $request->status
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dimoderasi',
            'comment' => $comment->load(['user', 'foto'])
        ]);
    }
}