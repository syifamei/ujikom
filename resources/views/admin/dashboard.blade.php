@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-gradient-primary text-white">
            <div class="card-body text-center py-4">
                <h1 class="h3 mb-2">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Selamat Datang, {{ Session::get('admin_username') }}!
                </h1>
                <p class="mb-0">Kelola konten website SMKN 4 BOGOR dengan mudah</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-images fa-2x text-primary"></i>
                </div>
                <h3 class="h2 mb-1 text-dark">{{ $totalFotos }}</h3>
                <p class="text-muted mb-0">Total Foto</p>
                <small class="opacity-75">
                    <i class="fas fa-arrow-up me-1"></i>
                    {{ $fotosBulanIni }} bulan ini
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-tags fa-2x text-success"></i>
                </div>
                <h3 class="h2 mb-1 text-dark">{{ $totalKategoris }}</h3>
                <p class="text-muted mb-0">Kategori</p>
                <small class="text-info">
                    <i class="fas fa-check-circle me-1"></i>
                    {{ $kategorisAktif }} aktif
                </small>
            </div>
        </div>
    </div>
    
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-users fa-2x text-warning"></i>
                </div>
                <h3 class="h2 mb-1 text-dark">{{ $totalPetugas }}</h3>
                <p class="text-muted mb-0">Petugas</p>
                <small class="text-secondary">
                    <i class="fas fa-user-shield me-1"></i>
                    Admin aktif
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Additional Stats Row -->
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-newspaper fa-2x text-primary"></i>
                </div>
                <h4 class="h3 mb-1 text-dark">{{ $totalPosts }}</h4>
                <p class="text-muted mb-0">Posts</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-info-circle fa-2x text-info"></i>
                </div>
                <h4 class="h3 mb-1 text-dark">{{ $totalInformasi }}</h4>
                <p class="text-muted mb-0">Informasi</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-chart-pie fa-2x text-success"></i>
                </div>
                <h4 class="h3 mb-1 text-dark">{{ $kategorisAktif }}</h4>
                <p class="text-muted mb-0">Kategori Aktif</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Photos and Kategori Stats -->
<div class="row mb-4">
    <!-- Recent Photos -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-images me-2 text-primary"></i>
                    Foto Terbaru
                </h5>
            </div>
            <div class="card-body">
                @if($recentFotos->count() > 0)
                <div class="row">
                    @foreach($recentFotos as $foto)
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="card border-0 shadow-sm">
                            <img src="{{ asset('storage/' . $foto->path) }}" 
                                 class="card-img-top" 
                                 alt="{{ $foto->judul }}"
                                 style="height: 120px; object-fit: cover;">
                            <div class="card-body p-2">
                                <h6 class="card-title text-truncate mb-1">{{ $foto->judul }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ $foto->kategori->nama ?? 'Tanpa Kategori' }}
                                </small>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $foto->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.fotos.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye me-2"></i>
                        Lihat Semua Foto
                    </a>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada foto</p>
                    <a href="{{ route('admin.fotos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Foto Pertama
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Kategori Stats -->
    <div class="col-lg-4 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2 text-success"></i>
                    Statistik Kategori
                </h5>
            </div>
            <div class="card-body">
                @if($fotoPerKategori->count() > 0)
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold">Kategori Populer:</span>
                        @if($kategoriPopuler)
                        <span class="badge bg-primary">{{ $kategoriPopuler->nama }}</span>
                        @endif
                    </div>
                    <div class="progress mb-3" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 100%"></div>
                    </div>
                </div>
                
                <div class="kategori-stats">
                    @foreach($fotoPerKategori as $kategori)
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-tag text-muted me-2"></i>
                            <span class="small">{{ $kategori->nama }}</span>
                        </div>
                        <span class="badge bg-light text-dark">{{ $kategori->fotos_count }}</span>
                    </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-cog me-2"></i>
                        Kelola Kategori
                    </a>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada kategori</p>
                    <a href="{{ route('admin.kategori.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Kategori
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-12">
        <h4 class="mb-3 text-dark">
            <i class="fas fa-tools me-2 text-primary"></i>
            Quick Actions
        </h4>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6 mb-3">
        <a href="{{ route('admin.fotos.index') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 action-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-images fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title text-dark">Kelola Galeri</h5>
                    <p class="card-text text-muted small">Kelola foto dan galeri sekolah</p>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 action-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-tags fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title text-dark">Kelola Kategori</h5>
                    <p class="card-text text-muted small">Kelola kategori foto</p>
                </div>
            </div>
        </a>
    </div>
    
    
    <div class="col-lg-3 col-md-6 mb-3">
        <a href="{{ route('admin.petugas.index') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 action-card">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-warning"></i>
                    </div>
                    <h5 class="card-title text-dark">Kelola Petugas</h5>
                    <p class="card-text text-muted small">Manajemen akun admin</p>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stats-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-left: 4px solid transparent;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
    }
    
    .stats-card:nth-child(1) {
        border-left-color: #0d6efd;
    }
    
    .stats-card:nth-child(2) {
        border-left-color: #198754;
    }
    
    .stats-card:nth-child(3) {
        border-left-color: #0dcaf0;
    }
    
    .stats-card:nth-child(4) {
        border-left-color: #ffc107;
    }
    
    .action-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .action-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    
    .action-card:hover .fa-3x {
        transform: scale(1.1);
        transition: transform 0.2s ease;
    }
    
    .fa-3x {
        transition: transform 0.2s ease;
    }
    
    .kategori-stats .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
    
    .card {
        border-radius: 15px;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: 1px solid #e9ecef;
        background: #f8f9fa;
    }
    
    .progress {
        border-radius: 10px;
    }
    
    .progress-bar {
        border-radius: 10px;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .stats-card .card-body {
            padding: 1rem;
        }
        
        .action-card .card-body {
            padding: 1rem;
        }
    }
</style>
@endsection