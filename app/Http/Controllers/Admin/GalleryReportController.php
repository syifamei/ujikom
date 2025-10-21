<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use App\Models\Comment;
use App\Models\DownloadLog;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GalleryReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->query('period', 'all'); // all, weekly, monthly

        // Get all photos regardless of kategori
        $query = Foto::with([
            'kategori', 
            'comments' => function($q){ $q->where('status','approved'); },
            'pendingComments' => function($q){ $q->where('status','pending'); },
            'rejectedComments' => function($q){ $q->where('status','rejected'); },
            'downloadLogs'
        ])->where('status','Aktif');

        // Apply period filter
        if ($period === 'weekly') {
            $query->where('created_at', '>=', now()->subWeek());
        } elseif ($period === 'monthly') {
            $query->where('created_at', '>=', now()->subMonth());
        }

        $fotos = $query->get();

        // Calculate summary for all photos in the period
        $summary = [
            'likes' => (int) $fotos->sum('likes_count'),
            'dislikes' => (int) $fotos->sum('dislikes_count'),
            'comments' => (int) $fotos->sum(fn($f) => $f->comments->count()),
            'pending_comments' => (int) $fotos->sum(fn($f) => $f->pendingComments->count()),
            'rejected_comments' => (int) $fotos->sum(fn($f) => $f->rejectedComments->count()),
            'downloads' => (int) $fotos->sum(fn($f) => $f->downloadLogs->count()),
            'total_photos' => $fotos->count(),
        ];

        // Get weekly and monthly statistics for comparison
        $weeklyStats = $this->getPeriodStats('weekly');
        $monthlyStats = $this->getPeriodStats('monthly');

        $kategoris = \App\Models\Kategori::orderBy('nama','asc')->get();

        return view('admin.reports.gallery_index', compact('fotos','summary','kategoris','period','weeklyStats','monthlyStats'));
    }

    /**
     * Get statistics for a specific period
     */
    private function getPeriodStats($period)
    {
        $startDate = null;
        if ($period === 'weekly') {
            $startDate = now()->subWeek();
        } elseif ($period === 'monthly') {
            $startDate = now()->subMonth();
        }

        $query = Foto::where('status','Aktif');
        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }

        $fotos = $query->get();

        return [
            'total_photos' => $fotos->count(),
            'likes' => (int) $fotos->sum('likes_count'),
            'dislikes' => (int) $fotos->sum('dislikes_count'),
            'comments' => (int) $fotos->sum(fn($f) => $f->comments()->where('status','approved')->count()),
            'pending_comments' => (int) $fotos->sum(fn($f) => $f->comments()->where('status','pending')->count()),
            'rejected_comments' => (int) $fotos->sum(fn($f) => $f->comments()->where('status','rejected')->count()),
            'downloads' => (int) $fotos->sum(fn($f) => $f->downloadLogs->count()),
        ];
    }
    /**
     * Generate PDF report for gallery
     */
    public function generate(Request $request)
    {
        $period = $request->query('period', 'all'); // all, weekly, monthly
        
        // Get photos with their statistics, filtered by period only (no kategori filter)
        $query = Foto::with(['kategori', 'comments', 'downloadLogs'])
            ->where('status', 'Aktif')
            ->orderBy('created_at', 'desc');
            
        // Apply period filter
        if ($period === 'weekly') {
            $query->where('created_at', '>=', now()->subWeek());
        } elseif ($period === 'monthly') {
            $query->where('created_at', '>=', now()->subMonth());
        }
        
        $fotos = $query->get();

        // Calculate statistics based on period
        $totalPhotos = $fotos->count();
        $totalLikes = $fotos->sum('likes_count');
        
        // Filter comments and downloads by period
        $commentsQuery = Comment::where('status', 'approved');
        $downloadsQuery = DownloadLog::query();
        
        if ($period === 'weekly') {
            $commentsQuery->where('created_at', '>=', now()->subWeek());
            $downloadsQuery->where('created_at', '>=', now()->subWeek());
        } elseif ($period === 'monthly') {
            $commentsQuery->where('created_at', '>=', now()->subMonth());
            $downloadsQuery->where('created_at', '>=', now()->subMonth());
        }
        
        $totalComments = $commentsQuery->count();
        $totalDownloads = $downloadsQuery->count();

        // Get recent activity based on period
        $recentComments = $commentsQuery->with(['user', 'foto'])
            ->orderBy('created_at', 'desc')
            ->get();

        $recentDownloads = $downloadsQuery->with(['user', 'foto'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Get top photos by likes
        $topPhotos = $fotos->sortByDesc('likes_count')->take(10);

        // Get top photos by downloads
        $topDownloadedPhotos = $fotos->sortByDesc(function($foto) {
            return $foto->downloadLogs->count();
        })->take(10);

        // Set period label
        $periodLabel = 'Semua waktu';
        if ($period === 'weekly') {
            $periodLabel = '1 minggu terakhir';
        } elseif ($period === 'monthly') {
            $periodLabel = '1 bulan terakhir';
        }

        $data = [
            'fotos' => $fotos,
            'totalPhotos' => $totalPhotos,
            'totalLikes' => $totalLikes,
            'totalComments' => $totalComments,
            'totalDownloads' => $totalDownloads,
            'recentComments' => $recentComments,
            'recentDownloads' => $recentDownloads,
            'topPhotos' => $topPhotos,
            'topDownloadedPhotos' => $topDownloadedPhotos,
            'generatedAt' => now()->format('d F Y H:i:s'),
            'period' => $periodLabel,
            'periodType' => $period
        ];

        // Generate PDF
        $pdf = Pdf::loadView('admin.reports.gallery', $data);
        $pdf->setPaper('A4', 'portrait');

        $filename = 'laporan-galeri-' . $period . '-' . now()->format('Y-m-d-H-i-s') . '.pdf';
        return $pdf->download($filename);
    }
}