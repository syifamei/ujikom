<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\GalleryLike;
use App\Models\GalleryComment;
use App\Models\GalleryDownload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PublicGalleryController extends Controller
{
    /**
     * Display gallery for public
     */
    public function index()
    {
        $galleryItems = GalleryItem::where('status', 'active')
            ->with(['approvedComments.user'])
            ->withCount(['likes as like_count' => function($query) {
                $query->where('type', 'like');
            }])
            ->withCount(['likes as dislike_count' => function($query) {
                $query->where('type', 'dislike');
            }])
            ->withCount('approvedComments as comment_count')
            ->withCount('downloads as download_count')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('gallery.public', compact('galleryItems'));
    }

    /**
     * Handle like/dislike
     */
    public function toggleLike(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|in:like,dislike'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid type'
            ], 400);
        }

        $galleryItem = GalleryItem::find($id);
        if (!$galleryItem) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery item not found'
            ], 404);
        }

        $userId = Auth::id();
        $ipAddress = $request->ip();
        $sessionId = session()->getId();
        $type = $request->type;

        // Check existing reaction
        $existingLike = null;
        if ($userId) {
            $existingLike = GalleryLike::where('gallery_item_id', $id)
                ->where('user_id', $userId)
                ->first();
        } else {
            $existingLike = GalleryLike::where('gallery_item_id', $id)
                ->where(function($query) use ($ipAddress, $sessionId) {
                    $query->where('ip_address', $ipAddress)
                          ->orWhere('session_id', $sessionId);
                })
                ->first();
        }

        if ($existingLike) {
            if ($existingLike->type === $type) {
                // Remove the like/dislike
                $existingLike->delete();
                $message = 'Removed ' . $type;
            } else {
                // Change type
                $existingLike->update(['type' => $type]);
                $message = 'Changed to ' . $type;
            }
        } else {
            // Create new like/dislike
            GalleryLike::create([
                'gallery_item_id' => $id,
                'user_id' => $userId,
                'ip_address' => $userId ? null : $ipAddress,
                'session_id' => $userId ? null : $sessionId,
                'type' => $type
            ]);
            $message = 'Added ' . $type;
        }

        // Get updated counts
        $likeCount = GalleryLike::where('gallery_item_id', $id)->where('type', 'like')->count();
        $dislikeCount = GalleryLike::where('gallery_item_id', $id)->where('type', 'dislike')->count();

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => [
                'like_count' => $likeCount,
                'dislike_count' => $dislikeCount
            ]
        ]);
    }

    /**
     * Add comment
     */
    public function addComment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|max:500',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        $galleryItem = GalleryItem::find($id);
        if (!$galleryItem) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery item not found'
            ], 404);
        }

        $comment = GalleryComment::create([
            'gallery_item_id' => $id,
            'user_id' => Auth::id(),
            'name' => Auth::id() ? null : $request->name,
            'email' => Auth::id() ? null : $request->email,
            'content' => $request->content,
            'status' => 'pending'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment submitted and waiting for approval',
            'data' => $comment
        ]);
    }

    /**
     * Download image (only for logged users)
     */
    public function download($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to download'
            ], 401);
        }

        $galleryItem = GalleryItem::find($id);
        if (!$galleryItem) {
            return response()->json([
                'success' => false,
                'message' => 'Gallery item not found'
            ], 404);
        }

        // Record download
        GalleryDownload::create([
            'gallery_item_id' => $id,
            'user_id' => Auth::id()
        ]);

        // Get download count
        $downloadCount = GalleryDownload::where('gallery_item_id', $id)->count();

        return response()->json([
            'success' => true,
            'message' => 'Download recorded',
            'data' => [
                'download_count' => $downloadCount,
                'download_url' => Storage::url($galleryItem->image_path)
            ]
        ]);
    }
}


