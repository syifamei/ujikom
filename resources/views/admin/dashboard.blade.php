@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('page-title', 'Dashboard')

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm bg-gradient-primary text-white">
            <div class="card-body text-center py-3">
                <h1 class="h4 mb-2">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Selamat Datang, {{ Session::get('admin_username') }}!
                </h1>
                <p class="mb-0 small">Kelola konten website SMKN 4 BOGOR dengan mudah</p>
            </div>
        </div>
    </div>
</div>

<!-- Main Stats Cards - Responsive Grid -->
<div class="row mb-4">
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100 stats-card">
            <div class="card-body text-center p-3">
                <div class="mb-2">
                    <i class="fas fa-images fa-2x text-primary"></i>
                </div>
                <h4 class="h3 mb-1 text-dark">{{ $totalFotos }}</h4>
                <p class="text-muted mb-0 small">Total Foto</p>
                <small class="text-info">
                    <i class="fas fa-arrow-up me-1"></i>
                    {{ $fotosBulanIni }} bulan ini
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100 stats-card">
            <div class="card-body text-center p-3">
                <div class="mb-2">
                    <i class="fas fa-calendar fa-2x text-success"></i>
                </div>
                <h4 class="h3 mb-1 text-dark">{{ $totalAgenda ?? 0 }}</h4>
                <p class="text-muted mb-0 small">Total Agenda</p>
                <small class="text-warning">
                    <i class="fas fa-clock me-1"></i>
                    Terjadwal
                </small>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
        <div class="card border-0 shadow-sm h-100 stats-card">
            <div class="card-body text-center p-3">
                <div class="mb-2">
                    <i class="fas fa-tags fa-2x text-warning"></i>
                </div>
                <h4 class="h3 mb-1 text-dark">{{ $totalKategoris }}</h4>
                <p class="text-muted mb-0 small">Kategori</p>
                <small class="text-primary">
                    <i class="fas fa-tag me-1"></i>
                    {{ $kategorisAktif }} aktif
                </small>
            </div>
        </div>
    </div>
</div>

<!-- Content Sections - Responsive Layout -->
<div class="row">
    <!-- Recent Photos - Mobile First -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-images me-2 text-primary"></i>
                        Preview Galeri
                    </h5>
                    <a href="{{ route('admin.fotos.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-cog me-1"></i>
                        Kelola Galeri
                    </a>
                </div>
            </div>
            <div class="card-body p-3">
                @if($recentFotos->count() > 0)
                <div class="row g-2">
                    @foreach($recentFotos->take(6) as $foto)
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $foto->path) }}" 
                                     class="card-img-top" 
                                     alt="{{ $foto->judul }}"
                                     style="height: 100px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 m-2">
                                    <span class="badge bg-primary bg-opacity-75">{{ $foto->kategori->nama ?? 'Umum' }}</span>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title text-truncate mb-1 small">{{ $foto->judul }}</h6>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $foto->created_at->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-4">
                    <i class="fas fa-images fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada foto</p>
                    <a href="{{ route('admin.fotos.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Foto
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Information & Agenda -->
    <div class="col-lg-4 mb-4">
        <!-- Recent Information -->
        <!-- Recent Agenda -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-calendar me-2 text-success"></i>
                        Agenda Terdekat
                    </h5>
                    <a href="{{ route('admin.agenda.index') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-eye me-1"></i>
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="card-body p-3">
                @if(isset($recentAgenda) && $recentAgenda->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($recentAgenda->take(2) as $agenda)
                    <div class="list-group-item border-0 px-0 py-2">
                        <div class="d-flex align-items-start">
                            <i class="fas fa-calendar-alt text-success me-2 mt-1"></i>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 small text-truncate">{{ $agenda->judul }}</h6>
                                <small class="text-muted">{{ $agenda->tanggal->format('d M Y') }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-3">
                    <i class="fas fa-calendar fa-2x text-muted mb-2"></i>
                    <p class="text-muted small">Belum ada agenda</p>
                </div>
                @endif
            </div>
        </div>
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
    
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: 1px solid #e9ecef;
        background: #f8f9fa;
    }
    
    /* Mobile First Responsive Design */
    @media (max-width: 576px) {
        .stats-card .card-body {
            padding: 1rem 0.75rem;
        }
        
        .stats-card h4 {
            font-size: 1.5rem;
        }
        
        .stats-card .fa-2x {
            font-size: 1.5rem;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        .btn-sm {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }
    }
    
    @media (max-width: 768px) {
        .stats-card .card-body {
            padding: 1rem;
        }
        
        .row.g-2 > * {
            margin-bottom: 0.5rem;
        }
        
        .card-body img {
            height: 80px !important;
        }
    }
    
    @media (max-width: 992px) {
        .col-lg-8, .col-lg-4 {
            margin-bottom: 1rem;
        }
    }
    
    /* Tablet and Desktop Optimizations */
    @media (min-width: 768px) {
        .stats-card:hover {
            transform: translateY(-3px);
        }
        
        .card:hover {
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
    }
    
    /* Large screens optimization */
    @media (min-width: 1200px) {
        .stats-card .card-body {
            padding: 1.5rem;
        }
    }
</style>
@endsection