<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foto;
use App\Models\User;
use App\Models\DownloadLog;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GalleryReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->query('period', 'all'); // all, weekly, monthly

        // Get all photos with likes and download logs
        $query = Foto::with([
            'kategori', 
            'likes',
            'downloadLogs'
        ])->where('status','Aktif');

        // Apply period filter
        if ($period === 'weekly') {
            $query->where('created_at', '>=', now()->subWeek());
        } elseif ($period === 'monthly') {
            $query->where('created_at', '>=', now()->subMonth());
        }

        $fotos = $query->get();

        // Get all registered users
        $usersQuery = User::query();
        if ($period === 'weekly') {
            $usersQuery->where('created_at', '>=', now()->subWeek());
        } elseif ($period === 'monthly') {
            $usersQuery->where('created_at', '>=', now()->subMonth());
        }
        $users = $usersQuery->orderBy('created_at', 'desc')->get();

        // Calculate likes per foto
        $fotosWithLikes = $fotos->map(function($foto) use ($period) {
            $likesQuery = $foto->likes();
            if ($period === 'weekly') {
                $likesQuery->where('created_at', '>=', now()->subWeek());
            } elseif ($period === 'monthly') {
                $likesQuery->where('created_at', '>=', now()->subMonth());
            }
            $foto->likes_count_period = $likesQuery->count();
            return $foto;
        });

        // Calculate downloads per foto
        $fotosWithDownloads = $fotosWithLikes->map(function($foto) use ($period) {
            $downloadsQuery = $foto->downloadLogs();
            if ($period === 'weekly') {
                $downloadsQuery->where('created_at', '>=', now()->subWeek());
            } elseif ($period === 'monthly') {
                $downloadsQuery->where('created_at', '>=', now()->subMonth());
            }
            $foto->downloads_count_period = $downloadsQuery->count();
            return $foto;
        });

        // Calculate likes and downloads per kategori
        $kategoris = Kategori::with('fotos')->where('status', 'Aktif')->get();
        $kategoriStats = $kategoris->map(function($kategori) use ($period) {
            $fotosInKategori = $kategori->fotos->where('status', 'Aktif');
            
            $totalLikes = 0;
            $totalDownloads = 0;
            
            foreach ($fotosInKategori as $foto) {
                $likesQuery = $foto->likes();
                $downloadsQuery = $foto->downloadLogs();
                
                if ($period === 'weekly') {
                    $likesQuery->where('created_at', '>=', now()->subWeek());
                    $downloadsQuery->where('created_at', '>=', now()->subWeek());
                } elseif ($period === 'monthly') {
                    $likesQuery->where('created_at', '>=', now()->subMonth());
                    $downloadsQuery->where('created_at', '>=', now()->subMonth());
                }
                
                $totalLikes += $likesQuery->count();
                $totalDownloads += $downloadsQuery->count();
            }
            
            return [
                'nama' => $kategori->nama,
                'total_likes' => $totalLikes,
                'total_downloads' => $totalDownloads,
                'total_fotos' => $fotosInKategori->count()
            ];
        });

        // Calculate summary
        $summary = [
            'total_users' => $users->count(),
            'total_photos' => $fotos->count(),
            'total_likes' => $fotosWithLikes->sum('likes_count_period'),
            'total_downloads' => $fotosWithDownloads->sum('downloads_count_period'),
        ];

        // Get weekly and monthly statistics for comparison
        $weeklyStats = $this->getPeriodStats('weekly');
        $monthlyStats = $this->getPeriodStats('monthly');

        return view('admin.reports.gallery_index', compact(
            'fotos',
            'users',
            'summary',
            'kategoriStats',
            'period',
            'weeklyStats',
            'monthlyStats'
        ));
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

        $query = Foto::with(['likes', 'downloadLogs'])->where('status','Aktif');
        if ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }

        $fotos = $query->get();
        
        // Count likes filtered by period
        $totalLikes = 0;
        $totalDownloads = 0;
        
        foreach ($fotos as $foto) {
            $likesQuery = $foto->likes();
            $downloadsQuery = $foto->downloadLogs();
            
            if ($startDate) {
                $likesQuery->where('created_at', '>=', $startDate);
                $downloadsQuery->where('created_at', '>=', $startDate);
            }
            
            $totalLikes += $likesQuery->count();
            $totalDownloads += $downloadsQuery->count();
        }

        return [
            'total_photos' => $fotos->count(),
            'total_likes' => $totalLikes,
            'total_downloads' => $totalDownloads,
        ];
    }
    /**
     * Generate PDF report for gallery
     */
    public function generate(Request $request)
    {
        $period = $request->query('period', 'all'); // all, weekly, monthly
        
        // Get photos with their statistics
        $query = Foto::with(['kategori', 'likes', 'downloadLogs'])
            ->where('status', 'Aktif')
            ->orderBy('created_at', 'desc');
            
        // Apply period filter
        if ($period === 'weekly') {
            $query->where('created_at', '>=', now()->subWeek());
        } elseif ($period === 'monthly') {
            $query->where('created_at', '>=', now()->subMonth());
        }
        
        $fotos = $query->get();

        // Get users
        $usersQuery = User::query();
        if ($period === 'weekly') {
            $usersQuery->where('created_at', '>=', now()->subWeek());
        } elseif ($period === 'monthly') {
            $usersQuery->where('created_at', '>=', now()->subMonth());
        }
        $users = $usersQuery->orderBy('created_at', 'desc')->get();

        // Calculate likes and downloads per foto with period filter
        $totalLikes = 0;
        $totalDownloads = 0;
        
        foreach ($fotos as $foto) {
            $likesQuery = $foto->likes();
            $downloadsQuery = $foto->downloadLogs();
            
            if ($period === 'weekly') {
                $likesQuery->where('created_at', '>=', now()->subWeek());
                $downloadsQuery->where('created_at', '>=', now()->subWeek());
            } elseif ($period === 'monthly') {
                $likesQuery->where('created_at', '>=', now()->subMonth());
                $downloadsQuery->where('created_at', '>=', now()->subMonth());
            }
            
            $foto->likes_count_period = $likesQuery->count();
            $foto->downloads_count_period = $downloadsQuery->count();
            
            $totalLikes += $foto->likes_count_period;
            $totalDownloads += $foto->downloads_count_period;
        }

        // Calculate per kategori
        $kategoris = Kategori::with('fotos')->where('status', 'Aktif')->get();
        $kategoriStats = $kategoris->map(function($kategori) use ($period) {
            $fotosInKategori = $kategori->fotos->where('status', 'Aktif');
            
            $totalLikes = 0;
            $totalDownloads = 0;
            
            foreach ($fotosInKategori as $foto) {
                $likesQuery = $foto->likes();
                $downloadsQuery = $foto->downloadLogs();
                
                if ($period === 'weekly') {
                    $likesQuery->where('created_at', '>=', now()->subWeek());
                    $downloadsQuery->where('created_at', '>=', now()->subWeek());
                } elseif ($period === 'monthly') {
                    $likesQuery->where('created_at', '>=', now()->subMonth());
                    $downloadsQuery->where('created_at', '>=', now()->subMonth());
                }
                
                $totalLikes += $likesQuery->count();
                $totalDownloads += $downloadsQuery->count();
            }
            
            return [
                'nama' => $kategori->nama,
                'total_likes' => $totalLikes,
                'total_downloads' => $totalDownloads,
                'total_fotos' => $fotosInKategori->count()
            ];
        });

        // Set period label
        $periodLabel = 'Semua waktu';
        if ($period === 'weekly') {
            $periodLabel = '1 minggu terakhir';
        } elseif ($period === 'monthly') {
            $periodLabel = '1 bulan terakhir';
        }

        $data = [
            'fotos' => $fotos,
            'users' => $users,
            'kategoriStats' => $kategoriStats,
            'totalPhotos' => $fotos->count(),
            'totalUsers' => $users->count(),
            'totalLikes' => $totalLikes,
            'totalDownloads' => $totalDownloads,
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