@extends('layouts.app')

@section('title', 'Informasi Sekolah')

@php
    $informasiList = \App\Models\Informasi::latest()->paginate(9);
    $agendaKategori = \App\Models\Kategori::where('nama', 'Agenda Sekolah')->first();
    $agendas = $agendaKategori 
        ? \App\Models\Post::where('kategori_id', $agendaKategori->id)->latest()->take(5)->get()
        : collect();
@endphp

@section('styles')
<style>
    .info-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    
    .info-image {
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    
    .info-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .info-card:hover .info-image img {
        transform: scale(1.05);
    }
    
    .info-content {
        padding: 20px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .info-date {
        font-size: 0.85rem;
        color: #6c757d;
        margin-bottom: 8px;
    }
    
    .info-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #2c3e50;
    }
    
    .info-excerpt {
        color: #6c757d;
        margin-bottom: 15px;
        flex-grow: 1;
    }
    
    .read-more {
        color: #0d6efd;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: color 0.3s ease;
    }
    
    .read-more:hover {
        color: #0a58ca;
    }
    
    .read-more i {
        margin-left: 5px;
        transition: transform 0.3s ease;
    }
    
    .read-more:hover i {
        transform: translateX(3px);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #0d6efd;
        opacity: 0.5;
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<section class="py-4" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="fw-bold text-white" style="font-size: 1.5rem;">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi Sekolah
                </h1>
                <p class="text-white-50 small">
                    Informasi terbaru dan pengumuman dari sekolah kami
            </div>
            <div class="col-lg-6">
                <nav aria-label="breadcrumb" class="justify-content-lg-end d-flex">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Informasi</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Informasi Grid -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="row g-4">
                    @forelse($informasiList as $info)
                        <div class="col-md-6">
                            <div class="info-card h-100">
                                <div class="info-image">
                                    @if($info->gambar)
                                        <img src="{{ asset('storage/' . $info->gambar) }}" alt="{{ $info->judul }}" class="img-fluid">
                                    @else
                                        <img src="https://via.placeholder.com/600x400?text=No+Image" alt="No Image" class="img-fluid">
                                    @endif
                                </div>
                                <div class="info-content">
                                    <div class="info-date">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $info->created_at->translatedFormat('d F Y') }}
                                    </div>
                                    <h3 class="info-title">{{ $info->judul }}</h3>
                                    <p class="info-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($info->isi), 120) }}</p>
                                    <a href="{{ route('informasi.show', $info->id) }}" class="read-more">
                                        Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="far fa-newspaper"></i>
                                <h4>Belum ada informasi</h4>
                                <p>Tidak ada informasi yang tersedia saat ini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($informasiList->hasPages())
                    <div class="d-flex justify-content-center mt-5">
                        {{ $informasiList->links() }}
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Search Box -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-search me-2"></i> Cari Informasi</h5>
                        <form action="{{ route('informasi.search') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Kata kunci...">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Kategori -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-tags me-2"></i> Kategori Informasi</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('informasi.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Semua Informasi
                            <span class="badge bg-primary rounded-pill">{{ \App\Models\Informasi::count() }}</span>
                        </a>
                        <a href="{{ route('informasi.kategori', 'berita') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Berita Sekolah
                            <span class="badge bg-primary rounded-pill">{{ \App\Models\Informasi::where('kategori', 'berita')->count() }}</span>
                        </a>
                        <a href="{{ route('informasi.kategori', 'pengumuman') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Pengumuman
                            <span class="badge bg-primary rounded-pill">{{ \App\Models\Informasi::where('kategori', 'pengumuman')->count() }}</span>
                        </a>
                        <a href="{{ route('informasi.kategori', 'kegiatan') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Kegiatan
                            <span class="badge bg-primary rounded-pill">{{ \App\Models\Informasi::where('kategori', 'kegiatan')->count() }}</span>
                        </a>
                    </div>
                </div>
                
                
                <!-- Informasi Populer -->
                <div class="card mt-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-fire me-2"></i> Populer</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        @php
                            $popularInfo = \App\Models\Informasi::orderBy('dilihat', 'desc')->take(3)->get();
                        @endphp
                        
                        @forelse($popularInfo as $info)
                            <a href="{{ route('informasi.show', $info->id) }}" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $info->judul }}</h6>
                                    <small class="text-muted">{{ $info->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 small text-muted">
                                    <i class="far fa-eye me-1"></i> {{ $info->dilihat }}x dilihat
                                </p>
                            </a>
                        @empty
                            <div class="p-3 text-center text-muted">
                                <i class="fas fa-info-circle fa-2x mb-2"></i>
                                <p class="mb-0">Belum ada informasi populer</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
