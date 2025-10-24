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
    /* Header Styles */
    .info-header-section {
        background: linear-gradient(135deg, #4e54c8, #8f94fb);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2.5rem;
        color: white;
        box-shadow: 0 10px 30px rgba(78, 84, 200, 0.15);
    }

    .info-header-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1.5rem;
    }

    .info-header-icon i {
        font-size: 1.75rem;
        color: white;
    }

    .info-header-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        color: white;
    }

    .info-header-subtitle {
        color: rgba(255, 255, 255, 0.9);
        margin: 0;
        font-size: 1.1rem;
        font-weight: 400;
    }

    /* Card Styles */
    .info-card {
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #e9ecef;
        background: white;
        overflow: hidden;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .info-image {
        height: 180px;
        overflow: hidden;
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
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .info-date {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    .info-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 0.75rem 0;
        color: #2d3748;
        line-height: 1.4;
    }

    .info-excerpt {
        color: #4a5568;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        flex-grow: 1;
    }

    .read-more {
        color: #4e54c8;
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s ease;
    }

    .read-more:hover {
        color: #3a3f9e;
    }

    .read-more i {
        margin-left: 0.5rem;
        transition: transform 0.2s ease;
    }

    .read-more:hover i {
        transform: translateX(3px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        background: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 12px;
        margin: 2rem 0;
    }

    .empty-state i {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
        opacity: 0.7;
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <!-- Header Section -->
    <div class="info-header-section mb-5">
        <div class="info-header-content">
            <div class="info-header-left">
                <div class="info-header-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="info-header-text">
                    <h1 class="info-header-title">Informasi Sekolah</h1>
                    <p class="info-header-subtitle">Informasi terbaru dan pengumuman dari SMKN 4 Bogor</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="row g-4">
                @forelse($informasiList as $info)
                    <div class="col-md-6">
                        <div class="info-card">
                            @if($info->gambar)
                            <div class="info-image">
                                <img src="{{ asset('storage/' . $info->gambar) }}" alt="{{ $info->judul }}" class="img-fluid">
                            </div>
                            @endif
                            <div class="info-content">
                                <div class="info-date">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $info->created_at->translatedFormat('l, d F Y') }}
                                </div>
                                <h3 class="info-title">{{ $info->judul }}</h3>
                                <p class="info-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($info->isi), 140) }}</p>
                                <a href="{{ route('informasi.show', $info->id) }}" class="read-more">
                                    Baca selengkapnya <i class="fas fa-arrow-right"></i>
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
                @endforese
            </div>

            <!-- Pagination -->
            @if($informasiList->hasPages())
                <div class="mt-5 d-flex justify-content-center">
                    {{ $informasiList->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Search Box -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-search me-2"></i> Cari Informasi</h5>
                        <form action="{{ route('informasi.search') }}" method="GET">
                            <div class="input-group">
                                <input type="text" name="q" class="form-control" placeholder="Kata kunci..." style="border-top-right-radius: 0; border-bottom-right-radius: 0;">
                                <button class="btn btn-primary" type="submit" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Kategori -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3"><i class="fas fa-folder me-2"></i> Kategori</h5>
                        <div class="list-group list-group-flush">
                            @foreach(\App\Models\Kategori::all() as $kategori)
                                <a href="{{ route('kategori.show', $kategori->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    {{ $kategori->nama }}
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill">{{ $kategori->posts_count ?? 0 }}</span>
                                </a>
                            @endforeach
                        </div>
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
