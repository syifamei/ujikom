@extends('layouts.app')

@section('title', $informasi->judul . ' - SMKN 4 BOGOR')

@section('content')
<!-- Hero Section -->
<section class="py-3" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('informasi.index') }}" class="text-white-50">Informasi</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($informasi->judul, 50) }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Informasi Detail Section -->
<section class="py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-3 p-md-4">
                        <div class="mb-3">
                            <h1 class="h4 fw-bold text-primary mb-2">{{ $informasi->judul }}</h1>
                            <div class="d-flex align-items-center text-muted mb-2 small">
                                <i class="fas fa-calendar me-1"></i>
                                <span>{{ $informasi->tanggal_posting->format('d F Y') }}</span>
                                <span class="mx-2">•</span>
                                <i class="fas fa-user me-1"></i>
                                <span>{{ $informasi->admin->name ?? 'Admin' }}</span>
                            </div>
                        </div>
                        
                        @if($informasi->gambar)
                        <div class="mb-4">
                            <img src="{{ $informasi->gambar_url }}" alt="{{ $informasi->judul }}" 
                                 class="img-fluid rounded shadow-sm" style="width: 100%; max-height: 400px; object-fit: cover;">
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <p class="text-muted small">{{ $informasi->deskripsi }}</p>
                        </div>
                        
                        <div class="informasi-content" style="font-size: 0.95rem; line-height: 1.6;">
                            {!! $informasi->konten !!}
                        </div>
                        
                        <hr class="my-3">
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('informasi.index') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>
                                Kembali
                            </a>
                            <div class="text-muted small">
                                <i class="fas fa-clock me-1"></i>
                                {{ $informasi->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


