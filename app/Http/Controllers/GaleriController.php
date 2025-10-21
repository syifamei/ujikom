<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Foto;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class GaleriController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Foto::with(['kategori', 'likes'])
            ->withCount(['comments as comments_count' => function($query) {
                $query->where('status', 'approved');
            }])
            ->withCount('likes as likes_count')
            ->where('status', 'Aktif')
            ->when($user, function($q) use ($user) {
                $q->with(['likes' => function($query) use ($user) {
                    $query->where('user_id', $user->id);
                }]);
            });

        // Filter berdasarkan kategori
        if ($request->has('kategori') && $request->kategori) {
            $kategoriSlug = $request->kategori;
            
            // Cari kategori berdasarkan slug yang dibuat dari nama
            $kategori = Kategori::where('status', 'Aktif')->get()->first(function($k) use ($kategoriSlug) {
                $kategoriSlugFromName = strtolower(str_replace([' ', '&'], ['', ''], $k->nama));
                return $kategoriSlugFromName === $kategoriSlug;
            });
            
            if ($kategori) {
                $query->where('kategori_id', $kategori->id);
            }
        }

        $fotos = $query->orderBy('created_at', 'desc')->get();
        
        // Ambil hanya kategori yang memiliki foto aktif untuk filter
        $kategoris = Kategori::where('status', 'Aktif')
            ->whereHas('fotos', function($q) {
                $q->where('status', 'Aktif');
            })
            ->orderBy('nama', 'asc')
            ->get();

        // Add is_liked status to each foto
        $fotos->each(function($foto) use ($user) {
            $foto->is_liked = $user ? $foto->likes->contains('user_id', $user->id) : false;
        });

        return view('galeri', compact('fotos', 'kategoris'))->with('galeri', $fotos);
    }

    /**
     * Handle like/unlike action (works for both authenticated and unauthenticated users)
     */
    public function like(Request $request, $fotoId)
    {
        $foto = Foto::findOrFail($fotoId);
        $userId = auth()->id();
        $ipAddress = $request->ip();
        $sessionId = session()->getId();
        
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
            $message = 'Suka dihapus';
        } else {
            // Add new like
            $foto->likes()->create([
                'user_id' => $userId,
                'ip_address' => $userId ? null : $ipAddress,
                'session_id' => $userId ? null : $sessionId,
            ]);
            $isLiked = true;
            $message = 'Berhasil menyukai foto';
        }
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'likes_count' => $foto->likes()->count(),
            'is_liked' => $isLiked
        ]);
    }

    /**
     * Get approved comments for a photo (public access)
     */
    public function comments($fotoId)
    {
        $foto = Foto::findOrFail($fotoId);
        
        // Only show approved comments
        $comments = $foto->approvedComments()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($comment) {
                return [
                    'user_name' => $comment->user ? $comment->user->name : ($comment->author_name ?? 'Anonim'),
                    'isi_komentar' => $comment->content,
                    'tanggal_komentar' => $comment->created_at->toDateTimeString()
                ];
            });

        return response()->json($comments);
    }

    /**
     * Add a comment to a photo (works for both authenticated and unauthenticated users)
     */
    public function addComment(Request $request, $fotoId = null)
    {
        // Handle both route parameter and form data for foto_id
        $fotoId = $fotoId ?? $request->input('foto_id');
        $foto = Foto::findOrFail($fotoId);
        
        $user = auth()->user();
        
        $request->validate([
            'isi_komentar' => 'required|string|min:3|max:500',
            'name' => $user ? 'nullable|string|max:255' : 'required|string|max:255',
            'email' => 'nullable|email|max:255'
        ]);

        $commentData = [
            'content' => $request->isi_komentar,
            'status' => 'pending', // All comments require admin approval
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ];

        if ($user) {
            $commentData['user_id'] = $user->id;
        } else {
            $commentData['author_name'] = $request->name;
            $commentData['author_email'] = $request->email;
        }

        $comment = $foto->comments()->create($commentData);

        // In a real app, you might want to notify admins about new comments
        // Notification::send(User::where('role', 'admin')->get(), new NewCommentNotification($comment));

        return response()->json([
            'success' => true,
            'message' => 'Komentar berhasil dikirim dan sedang menunggu persetujuan admin.',
            'comment' => [
                'user_name' => $user ? $user->name : ($request->name ?? 'Anonim'),
                'isi_komentar' => $comment->content,
                'tanggal_komentar' => $comment->created_at->toDateTimeString()
            ]
        ]);
    }

    /**
     * Track file downloads
     */
    public function trackDownload(Foto $foto)
    {
        try {
            // Log the download (you might want to save this to a downloads table)
            // DownloadLog::create([
            //     'foto_id' => $foto->id,
            //     'user_id' => auth()->id(),
            //     'ip_address' => request()->ip(),
            //     'user_agent' => request()->userAgent()
            // ]);

            // Increment download count
            $foto->increment('download_count');

            return response()->json([
                'success' => true,
                'download_url' => route('galeri.download', ['id' => $foto->id])
            ]);
        } catch (\Exception $e) {
            \Log::error('Download tracking error: ' . $e->getMessage());
            return response()->json([
                'success' => true, // Still return success to not block the download
                'download_url' => route('galeri.download', ['id' => $foto->id])
            ]);
        }
    }

    /**
     * Download the specified photo.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        // Require session consent from authDownload
        if (!session()->has('download_consent')) {
            return redirect()->back()->with('error', 'Silakan isi formulir persetujuan sebelum mengunduh.');
        }

        $foto = Foto::where('status', 'Aktif')->find($id);
        if (!$foto) {
            return redirect()->back()->with('error', 'Foto tidak ditemukan atau tidak aktif.');
        }
        
        // Resolve file location across possible storage paths
        $originalName = basename($foto->path ?: $foto->file ?: 'download.jpg');
        $candidates = [];
        if (!empty($foto->path)) {
            $candidates[] = Storage::path('public/' . ltrim($foto->path, '/'));
            $candidates[] = public_path('storage/' . ltrim($foto->path, '/'));
            $candidates[] = public_path(ltrim($foto->path, '/'));
        }
        if (!empty($foto->file)) {
            $candidates[] = Storage::path('public/' . ltrim($foto->file, '/'));
            $candidates[] = public_path('storage/' . ltrim($foto->file, '/'));
            $candidates[] = public_path(ltrim($foto->file, '/'));
        }
        $candidates[] = public_path('images/' . $originalName);

        $absolutePath = null;
        foreach ($candidates as $cand) {
            if ($cand && file_exists($cand)) {
                $absolutePath = $cand;
                break;
            }
        }
        
        if (!$absolutePath) {
            return redirect()->back()->with('error', 'File tidak ditemukan di penyimpanan.');
        }

        // Log the download (no auth required, log consent data if available)
        $logData = [
            'foto_id' => $foto->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];
        $currentUserId = auth()->id();
        if ($currentUserId) {
            $logData['user_id'] = $currentUserId;
        }
        try {
            \App\Models\DownloadLog::create($logData);
        } catch (\Throwable $e) {
            // Ignore logging failure (likely due to user_id not nullable on older schema)
        }

        // Clear consent after one use
        session()->forget('download_consent');

        return response()->download($absolutePath, $originalName);
    }

    /**
     * Simple consent/login form handler before allowing download.
     */
    public function authDownload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'foto_id' => 'required|integer',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'status' => 'required|string|max:100',
            'tujuan' => 'required|string|max:255',
            'agree' => 'accepted'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ensure foto exists without relying on table name in validation
        $foto = Foto::find($request->foto_id);
        if (!$foto) {
            return redirect()->back()->with('error', 'Foto tidak ditemukan.')->withInput();
        }

        // Store minimal consent proof in session (expires automatically)
        session([
            'download_consent' => [
                'foto_id' => (int) $foto->id,
                'nama' => $request->nama,
                'email' => $request->email,
                'status' => $request->status,
                'tujuan' => $request->tujuan,
                'time' => now()->toDateTimeString(),
                'ip' => $request->ip(),
            ]
        ]);

        return redirect()->route('galeri.download', ['id' => (int) $foto->id]);
    }

    
    
}
