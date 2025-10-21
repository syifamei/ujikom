@extends('layouts.app')

@section('title', 'Informasi Sekolah - SMKN 4 BOGOR')

@section('styles')
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .card:hover {
        transform: translateY(-5px);
        transition: all 0.3s ease;
    }
    
    .input-group-text {
        border: none;
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    /* Text-only info item */
    .info-item {
        border-left: 4px solid #667eea;
        border-radius: 12px;
        transition: background-color .2s ease, box-shadow .2s ease, transform .2s ease;
    }
    .info-item:hover {
        background: #f8faff;
        box-shadow: 0 8px 24px rgba(0,0,0,.06);
        transform: translateY(-2px);
    }
    .info-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: .25rem;
        line-height: 1.35;
    }
    .info-title a { text-decoration: none; color: inherit; }
    .info-title a:hover { color: #3b82f6; }
    .info-meta { color: #6b7280; font-size: .875rem; }
    .info-desc { color: #475569; font-size: .975rem; }
    .info-bullet { width: 10px; height: 10px; background: #667eea; border-radius: 999px; display: inline-block; margin-right: .5rem; }
    .info-date-pill {
        background: #eef2ff;
        color: #4338ca;
        border: 1px solid #e0e7ff;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: .85rem;
        font-weight: 700;
        white-space: nowrap;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-primary text-white">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="fw-bold mb-3" style="font-size: 2rem;">
                    <i class="fas fa-newspaper me-2"></i>
                    Informasi Sekolah
                </h1>
                <p class="lead">Informasi terbaru dan penting seputar kegiatan sekolah SMKN 4 BOGOR</p>
            </div>
        </div>
    </div>
</section>

<!-- Informasi List Section -->
<section class="section-padding">
    <div class="container">
        <!-- Search and Filter Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <form action="{{ route('informasi.index') }}" method="GET" class="d-flex">
                                    <div class="input-group">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" name="search" class="form-control" 
                                               placeholder="Cari informasi..." 
                                               value="{{ request('search') }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search me-1"></i>Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-10 mx-auto">
                @forelse($informasis as $informasi)
                <div class="card border-0 shadow-sm mb-3 info-item">
                    <div class="card-body p-3 p-md-4">
                        <div class="row">
                            @if($informasi->gambar)
                            <div class="col-md-3 mb-3 mb-md-0">
                                <img src="{{ $informasi->gambar_url }}" alt="{{ $informasi->judul }}" 
                                     class="img-fluid rounded" style="width: 100%; height: 150px; object-fit: cover;">
                            </div>
                            <div class="col-md-9">
                            @else
                            <div class="col-12">
                            @endif
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                                    <div class="me-md-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="info-date-pill me-2"><i class="fas fa-calendar-day me-1"></i>{{ $informasi->tanggal_posting->format('d F Y') }}</span>
                                            <h5 class="info-title mb-0">
                                                <a href="{{ route('informasi.show', $informasi->id) }}">{{ $informasi->judul }}</a>
                                            </h5>
                                        </div>
                                        <p class="info-desc mb-0">{{ $informasi->deskripsi }}</p>
                                    </div>
                                    <div class="mt-3 mt-md-0">
                                        <a href="{{ route('informasi.show', $informasi->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-book-open me-1"></i>Baca selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5 text-center">
                        <i class="fas fa-newspaper text-muted mb-3" style="font-size: 3rem;"></i>
                        <h5 class="text-muted">Belum ada informasi</h5>
                        <p class="text-muted">Informasi sekolah akan ditampilkan di sini</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        @if($informasis->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $informasis->links() }}
        </div>
        @endif
    </div>
</section>
@endsection

