@extends('layouts.app')

@section('title', $jurusan['nama'] . ' - ' . $jurusan['nama_lengkap'] . ' - SMKN 4 BOGOR')

@section('styles')
<style>
    .hero-section {
        position: relative;
        overflow: hidden;
        min-height: 60vh;
        display: flex;
        align-items: center;
    }
    
    .hero-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }
    
    .hero-slideshow {
        position: relative;
        width: 100%;
        height: 100%;
    }
    
    .hero-bg-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0;
        transition: opacity 1s ease-in-out;
    }
    
    .hero-bg-image.active {
        opacity: 1;
    }
    
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(118, 75, 162, 0.8) 100%);
        z-index: 2;
    }
    
    .hero-content {
        position: relative;
        z-index: 3;
    }
    
    .jurusan-icon-large {
        width: 120px;
        height: 120px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: var(--bs-primary);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        margin: 0 auto 2rem;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section text-white">
    <div class="hero-background">
        <div class="hero-slideshow">
            <img src="{{ asset($jurusan['foto']) }}" class="hero-bg-image active" alt="{{ $jurusan['nama'] }} Background">
        </div>
    </div>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="jurusan-icon-large">
                    <i class="{{ $jurusan['icon'] }}"></i>
                </div>
                <h1 class="display-4 fw-bold mb-3">{{ $jurusan['nama'] }}</h1>
                <h2 class="h4 mb-4">{{ $jurusan['nama_lengkap'] }}</h2>
                <p class="lead">{{ $jurusan['deskripsi'] }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Detail Section -->
<section class="section-padding">
    <div class="container">
        <div class="row g-4">
            <!-- Kompetensi -->
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-primary text-white text-center">
                        <h3 class="h5 mb-0">
                            <i class="fas fa-star me-2"></i>
                            Kompetensi Keahlian
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach($jurusan['kompetensi'] as $kompetensi)
                        <div class="d-flex align-items-center py-2">
                            <i class="fas fa-check-circle text-primary me-3"></i>
                            <span>{{ $kompetensi }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Prospek Kerja -->
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-success text-white text-center">
                        <h3 class="h5 mb-0">
                            <i class="fas fa-briefcase me-2"></i>
                            Prospek Kerja
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach($jurusan['prospek_kerja'] as $prospek)
                        <div class="d-flex align-items-center py-2">
                            <i class="fas fa-arrow-right text-success me-3"></i>
                            <span>{{ $prospek }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Fasilitas -->
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-info text-white text-center">
                        <h3 class="h5 mb-0">
                            <i class="fas fa-tools me-2"></i>
                            Fasilitas
                        </h3>
                    </div>
                    <div class="card-body">
                        @foreach($jurusan['fasilitas'] as $fasilitas)
                        <div class="d-flex align-items-center py-2">
                            <i class="fas fa-check text-info me-3"></i>
                            <span>{{ $fasilitas }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</section>
@endsection
