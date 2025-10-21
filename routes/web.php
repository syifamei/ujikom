<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\Admin\FotoController as AdminFotoController;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri');
// Gated download routes for public gallery
Route::post('/galeri/download/auth', [GaleriController::class, 'authDownload'])->name('galeri.download.auth');
Route::get('/galeri/download/{id}', [GaleriController::class, 'download'])->name('galeri.download');

// Like, Comment, and Download routes for gallery
Route::post('/galeri/{foto}/like', [GaleriController::class, 'like'])->name('galeri.like');
Route::get('/galeri/{foto}/comments', [GaleriController::class, 'comments'])->name('galeri.comments');
Route::post('/galeri/comment/{foto}', [GaleriController::class, 'addComment'])->name('galeri.comment');
Route::post('/galeri/download/{foto}', [GaleriController::class, 'trackDownload'])->name('galeri.download.track');

// Aliases for "/gallery" path (English URL)
Route::get('/gallery', [GaleriController::class, 'index'])->name('gallery');
Route::post('/gallery/download/auth', [GaleriController::class, 'authDownload'])->name('gallery.download.auth');
Route::get('/gallery/download/{id}', [GaleriController::class, 'download'])->name('gallery.download');
Route::get('/jurusan/{slug}', [HomeController::class, 'jurusan'])->name('jurusan');
Route::get('/kategori/{id}', [HomeController::class, 'kategori'])->name('kategori');
Route::get('/kontak', function () {
    $profile = \App\Models\Profile::first();
    return view('kontak', compact('profile'));
})->name('kontak');

// Public Informasi Routes
Route::get('/informasi', [InformasiController::class, 'publicIndex'])->name('informasi.index');
Route::get('/informasi/{informasi}', [InformasiController::class, 'publicShow'])->name('informasi.show');

// Public Agenda Routes
Route::get('/agenda', [AgendaController::class, 'publicIndex'])->name('agenda.index');
Route::get('/agenda/{agenda}', [AgendaController::class, 'publicShow'])->name('agenda.show');

// Authentication Routes
Route::get('/login', [AdminController::class, 'login'])->name('login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

// Admin Authentication Routes
Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('/profile', [AdminController::class, 'updateProfile'])->name('updateProfile');
    
    // Posts Management
    Route::resource('posts', PostController::class);
    
    // Categories Management
    Route::resource('kategori', AdminKategoriController::class);
    
    // Photos Management (Admin UI)
    Route::get('/galeri', [App\Http\Controllers\Admin\FotoController::class, 'index'])->name('fotos.index');
    Route::get('/galeri/create', [App\Http\Controllers\Admin\FotoController::class, 'create'])->name('fotos.create');
    Route::post('/fotos', [App\Http\Controllers\Admin\FotoController::class, 'store'])->name('fotos.store');
    Route::get('/fotos/{foto}', [App\Http\Controllers\Admin\FotoController::class, 'show'])->name('fotos.show');
    Route::get('/fotos/{foto}/edit', [App\Http\Controllers\Admin\FotoController::class, 'edit'])->name('fotos.edit');
    Route::put('/fotos/{foto}', [App\Http\Controllers\Admin\FotoController::class, 'update'])->name('fotos.update');
    Route::delete('/fotos/{foto}', [App\Http\Controllers\Admin\FotoController::class, 'destroy'])->name('fotos.destroy');
    Route::patch('/fotos/{foto}/status', [App\Http\Controllers\Admin\FotoController::class, 'updateStatus'])->name('fotos.status');
    
    // Comment moderation routes
    Route::get('/comments/pending', [App\Http\Controllers\Admin\CommentController::class, 'pending'])->name('comments.pending');
    Route::get('/comments/approved', [App\Http\Controllers\Admin\CommentController::class, 'approved'])->name('comments.approved');
    Route::get('/comments/pending/count', [App\Http\Controllers\Admin\CommentController::class, 'pendingCount'])->name('comments.pending.count');
    Route::post('/comments/{comment}/moderate', [App\Http\Controllers\Admin\CommentController::class, 'moderate'])->name('comments.moderate');
    
    // Gallery report route
    Route::get('/gallery/report', [App\Http\Controllers\Admin\GalleryReportController::class, 'generate'])->name('gallery.report');
    // Reporting page
    Route::get('/reports/gallery', [App\Http\Controllers\Admin\GalleryReportController::class, 'index'])->name('reports.gallery.index');
    // Comment moderation page
    Route::get('/comments/moderation', [App\Http\Controllers\Admin\CommentController::class, 'moderation'])->name('comments.moderation');
    Route::post('/fotos/bulk-delete', [App\Http\Controllers\Admin\FotoController::class, 'bulkDelete'])->name('fotos.bulk-delete');
    
    // Note: API routes for fotos should live in routes/api.php to avoid conflicts with Admin UI
    
    // Profile Management
    Route::resource('profiles', ProfileController::class);
    
    // Petugas Management
    Route::resource('petugas', PetugasController::class);
    
    // Agenda Management
    Route::resource('agenda', AgendaController::class);
    
    // Informasi Management
    Route::resource('informasi', InformasiController::class);
    
    
    // Contact Messages Management
});
