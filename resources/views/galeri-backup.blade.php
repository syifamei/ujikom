@extends('layouts.app')

@section('title', 'Galeri - SMKN 4 BOGOR')

@push('styles')
<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Alpine.js -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- NUCLEAR CSS - FORCE GALLERY GRID -->
<link rel="stylesheet" href="{{ asset('css/gallery-super.css') }}">
<style>
/* Reset semua margin dan padding yang mengganggu */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
    overflow-x: hidden;
    font-family: 'Poppins', sans-serif;
    }

/* Hero Section - Sesuai dengan gambar */
    .gallery-hero {
    background: linear-gradient(135deg, #3B82F6 0%, #60A5FA 100%) !important;
    color: white !important;
    padding: 5rem 1rem 4rem !important;
    text-align: center !important;
    margin-top: 80px !important;
    width: 100% !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
        position: relative;
        overflow: hidden;
    }
    
    .gallery-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Ccircle cx='30' cy='30' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.6;
        z-index: 0;
    }

    .gallery-hero-content {
        position: relative;
        z-index: 1;
    }

.gallery-hero h1 {
    font-size: 3.5rem !important;
    font-weight: 700 !important;
    margin: 0 0 1rem !important;
    color: white !important;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
    line-height: 1.2 !important;
    letter-spacing: -0.02em !important;
}

.gallery-hero p {
    font-size: 1.25rem !important;
    color: rgba(255, 255, 255, 0.95) !important;
    margin: 0 auto 3rem !important;
    max-width: 700px !important;
    line-height: 1.7 !important;
    font-weight: 400 !important;
}

.gallery-icon {
    font-size: 3rem !important;
    margin: 0 auto 2rem !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: white !important;
    background: rgba(255, 255, 255, 0.2) !important;
    width: 100px !important;
    height: 100px !important;
    border-radius: 50% !important;
    backdrop-filter: blur(10px) !important;
    -webkit-backdrop-filter: blur(10px) !important;
    box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2) !important;
    border: 2px solid rgba(255, 255, 255, 0.3) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
}

.gallery-icon:hover {
    transform: translateY(-8px) scale(1.1) !important;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3) !important;
    background: rgba(255, 255, 255, 0.25) !important;
}

/* Category Filters - Sesuai dengan gambar */
    .category-filters {
    width: 100% !important;
    margin: -3rem auto 5rem !important;
    padding: 0 2rem !important;
    position: relative !important;
    z-index: 10 !important;
    }

    .filters-container {
    background: white !important;
    border-radius: 1.5rem !important;
    padding: 2rem 2.5rem !important;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    border: 1px solid #E5E7EB !important;
    width: 100% !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .filters-container:hover {
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-3px) !important;
    }

    .filters-title {
    font-size: 1.4rem !important;
    font-weight: 600 !important;
    margin-bottom: 1.5rem !important;
    color: #1F2937 !important;
    display: flex !important;
    align-items: center !important;
    gap: 0.75rem !important;
    text-align: center !important;
    justify-content: center !important;
    }
    
    .filters-title i {
    color: #3B82F6 !important;
    font-size: 1.6rem !important;
    }

    .filters {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 0.75rem !important;
    justify-content: center !important;
    margin: 0 !important;
    padding: 0.75rem 0 !important;
    overflow-x: auto !important;
    scrollbar-width: thin !important;
    scrollbar-color: #60A5FA #F3F4F6 !important;
    }
    
    .filters::-webkit-scrollbar {
    height: 6px !important;
    }
    
    .filters::-webkit-scrollbar-track {
    background: #F3F4F6 !important;
    border-radius: 3px !important;
    }
    
    .filters::-webkit-scrollbar-thumb {
    background-color: #60A5FA !important;
    border-radius: 3px !important;
    }

    .filter-btn {
    background: #93C5FD !important;
    border: 2px solid #93C5FD !important;
    color: #1D4ED8 !important;
    padding: 0.75rem 1.75rem !important;
    border-radius: 9999px !important;
    font-size: 1rem !important;
    font-weight: 500 !important;
    cursor: pointer !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.75rem !important;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    margin: 0.25rem !important;
    white-space: nowrap !important;
    }

    .filter-btn:hover {
    background: #60A5FA !important;
    color: white !important;
    border-color: #60A5FA !important;
    transform: translateY(-3px) !important;
    box-shadow: 0 8px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
    }
    
    .filter-btn.active {
    background: #3B82F6 !important;
    color: white !important;
    border-color: #3B82F6 !important;
    transform: translateY(-3px) !important;
    box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4) !important;
    }
    
    .filter-btn:active {
    transform: translateY(-1px) !important;
    }

    .filter-btn i {
    font-size: 1.2rem !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .filter-btn:hover i, .filter-btn.active i {
    transform: scale(1.15) !important;
    }

/* GALLERY GRID - GRID 3 KOLOM SESUAI GAMBAR! */
    .gallery-container {
    width: 100% !important;
    margin: 0 auto !important;
    padding: 0 2rem 8rem !important;
    }

    .gallery-grid {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 1.5rem !important;
    padding: 2rem 0 !important;
    width: 100% !important;
    max-width: none !important;
    margin: 0 !important;
}

/* NUCLEAR OPTION - Override ALL possible CSS */
html body .gallery-container,
html body .gallery-grid,
html body #galleryGrid,
html body .gallery-container .gallery-grid,
html body .gallery-container #galleryGrid,
* .gallery-container,
* .gallery-grid,
* #galleryGrid,
* .gallery-container .gallery-grid,
* .gallery-container #galleryGrid {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 1.5rem !important;
    padding: 1rem 0 !important;
    width: 100% !important;
    max-width: none !important;
    margin: 0 !important;
    position: relative !important;
    z-index: 9999 !important;
    flex-direction: unset !important;
    flex-wrap: unset !important;
    justify-content: unset !important;
    align-items: unset !important;
    flex: unset !important;
    order: unset !important;
    float: none !important;
    clear: both !important;
}

/* FORCE ALL GALLERY CARDS TO BE GRID ITEMS */
html body .gallery-card,
* .gallery-card,
    .gallery-card {
    display: block !important;
    width: 100% !important;
    max-width: none !important;
    margin: 0 !important;
    padding: 0 !important;
    flex: unset !important;
    order: unset !important;
    float: none !important;
    clear: both !important;
    background: white !important;
    border-radius: 16px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    height: 100% !important;
    flex-direction: column !important;
    border: 1px solid rgba(0, 0, 0, 0.05) !important;
    cursor: pointer !important;
}

/* Gallery Card - Sesuai dengan gambar */
.gallery-card {
    background: white !important;
    border-radius: 16px !important;
    overflow: hidden !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    height: 100% !important;
    display: flex !important;
    flex-direction: column !important;
    border: 1px solid rgba(0, 0, 0, 0.05) !important;
    cursor: pointer !important;
    margin-bottom: 0 !important;
    }
    
    .gallery-card:hover {
    transform: translateY(-8px) !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15) !important;
}

/* Additional Enhancements */
.gallery-card::before {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(96, 165, 250, 0.05) 100%) !important;
    opacity: 0 !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    z-index: 1 !important;
    pointer-events: none !important;
}

.gallery-card:hover::before {
    opacity: 1 !important;
}

.gallery-card-content {
    position: relative !important;
    z-index: 2 !important;
    }

    .gallery-img-container {
    position: relative !important;
    width: 100% !important;
    padding-top: 100% !important;
    overflow: hidden !important;
    background: #F9FAFB !important;
    aspect-ratio: 1/1 !important;
    }
    
    .gallery-img-container img {
    transition: transform 0.6s ease !important;
    }
    
    .gallery-card:hover .gallery-img-container img {
    transform: scale(1.08) !important;
    }

    .gallery-image {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1) !important;
    will-change: transform !important;
    }

    .gallery-card-content {
    padding: 1.5rem !important;
    flex-grow: 1 !important;
    display: flex !important;
    flex-direction: column !important;
    background: white !important;
    }

    .gallery-title {
    font-size: 1.1rem !important;
    font-weight: 600 !important;
    color: #1F2937 !important;
    margin: 0 0 0.5rem !important;
    line-height: 1.4 !important;
}

.gallery-category {
    font-size: 0.85rem !important;
    color: #6B7280 !important;
    margin-bottom: 1rem !important;
    display: flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
}

.gallery-category i {
    font-size: 0.9rem !important;
    color: #3B82F6 !important;
    }

    .gallery-actions {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    margin-top: auto !important;
    padding-top: 1rem !important;
    border-top: 1px solid #E5E7EB !important;
    }

    .action-btn {
    background: none !important;
    border: none !important;
    color: #6B7280 !important;
    font-size: 1rem !important;
    display: flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
    cursor: pointer !important;
    padding: 0.75rem !important;
    border-radius: 12px !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    position: relative !important;
    overflow: hidden !important;
    min-width: 44px !important;
    min-height: 44px !important;
    justify-content: center !important;
    text-decoration: none !important;
    }
    
    .action-btn::after {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1) 0%, rgba(96, 165, 250, 0.1) 100%) !important;
    opacity: 0 !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    z-index: -1 !important;
    }

    .action-btn:hover {
    color: #3B82F6 !important;
    transform: translateY(-2px) !important;
    }
    
    .action-btn:hover::after {
    opacity: 1 !important;
}

.action-btn.liked {
    color: #ef4444 !important;
}

.action-btn.liked:hover {
    color: #dc2626 !important;
    }

    .action-btn i {
    font-size: 1.2rem !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    
    .action-btn:hover i {
    transform: scale(1.2) !important;
}

.action-count {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    margin-left: 0.25rem !important;
}

/* Toast Notifications */
.toast-notification {
    position: fixed !important;
    bottom: 30px !important;
    right: 30px !important;
    background: white !important;
    color: #1F2937 !important;
    padding: 1rem 1.5rem !important;
    border-radius: 12px !important;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
    z-index: 9999 !important;
    transform: translateY(100px) scale(0.9) !important;
    opacity: 0 !important;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
    max-width: 400px !important;
    font-size: 0.95rem !important;
    line-height: 1.5 !important;
    border-left: 4px solid #3B82F6 !important;
    backdrop-filter: blur(10px) !important;
    -webkit-backdrop-filter: blur(10px) !important;
}

.toast-notification.show {
    transform: translateY(0) scale(1) !important;
    opacity: 1 !important;
}

.toast-notification.success {
    border-left-color: #10B981 !important;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(16, 185, 129, 0.05) 100%) !important;
}

.toast-notification.error {
    border-left-color: #EF4444 !important;
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%) !important;
    }

    /* Empty State */
    .empty-gallery {
    grid-column: 1 / -1 !important;
    text-align: center !important;
    padding: 5rem 2rem !important;
    border-radius: 1.5rem !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
    margin: 2rem 0 !important;
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(96, 165, 250, 0.05) 100%) !important;
    border: 2px dashed #93C5FD !important;
    position: relative !important;
    overflow: hidden !important;
    }
    
    .empty-gallery::before {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    height: 4px !important;
    background: linear-gradient(90deg, #3B82F6, #60A5FA) !important;
    }

    .empty-gallery i {
    font-size: 4rem !important;
    margin-bottom: 1.75rem !important;
    color: #93C5FD !important;
    opacity: 0.8 !important;
    }

    .empty-gallery h3 {
    margin-bottom: 0.75rem !important;
    font-size: 1.75rem !important;
    font-weight: 700 !important;
    color: #3B82F6 !important;
    }

    .empty-gallery p {
    max-width: 450px !important;
    margin: 0 auto 2rem !important;
    font-size: 1.1rem !important;
    line-height: 1.7 !important;
    color: #6B7280 !important;
}

/* Enhanced animations */
@keyframes heartBeat {
    0% { transform: scale(1); }
    25% { transform: scale(1.2); }
    50% { transform: scale(1); }
    75% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.action-btn.liked i {
    animation: heartBeat 0.6s ease-in-out !important;
}

/* Better focus states for accessibility */
.filter-btn:focus,
.action-btn:focus {
    outline: 2px solid #3B82F6 !important;
    outline-offset: 2px !important;
}

/* Smooth transitions for all interactive elements */
.filter-btn,
.action-btn,
.gallery-card {
    will-change: transform !important;
    }
    
    /* Responsive */
    @media (max-width: 1200px) {
        .gallery-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1.25rem !important;
    }
    
    .gallery-container {
        padding: 0 1.5rem 6rem !important;
        }
    }
    
    @media (max-width: 992px) {
        .gallery-hero {
        padding: 4rem 1.5rem 3rem !important;
        }
        
        .gallery-hero h1 {
        font-size: 3rem !important;
        }
        
        .gallery-hero p {
        font-size: 1.2rem !important;
    }
    
    .gallery-icon {
        width: 90px !important;
        height: 90px !important;
        font-size: 2.8rem !important;
    }
    
    .category-filters {
        margin: -2.5rem auto 4rem !important;
        padding: 0 1.5rem !important;
        }
        
        .filters-container {
        padding: 1.75rem 2rem !important;
        }
        
    .filter-btn {
        padding: 0.7rem 1.5rem !important;
        font-size: 0.95rem !important;
        }
    }

    @media (max-width: 768px) {
        .gallery-hero {
        padding: 3.5rem 1.25rem 2.5rem !important;
        }
        
        .gallery-hero h1 {
        font-size: 2.5rem !important;
    }
    
    .gallery-hero p {
        font-size: 1.15rem !important;
        }
        
        .gallery-icon {
        width: 80px !important;
        height: 80px !important;
        font-size: 2.5rem !important;
        }
        
        .category-filters {
        margin: -2rem auto 3.5rem !important;
        padding: 0 1.25rem !important;
        }
        
        .filters-container {
        padding: 1.5rem 1.75rem !important;
        }
        
    .filters-title {
        font-size: 1.3rem !important;
        }
        
        .filter-btn {
        padding: 0.65rem 1.4rem !important;
        font-size: 0.9rem !important;
        }
        
        .gallery-container {
        padding: 0 1.25rem 5rem !important;
        }
        
        .gallery-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1rem !important;
    }
    
    .gallery-card-content {
        padding: 1.25rem !important;
    }
    
    .gallery-title {
        font-size: 1rem !important;
    }
    
    .gallery-category {
        font-size: 0.8rem !important;
        }
    }
    
    @media (max-width: 576px) {
        .gallery-hero {
        padding: 3rem 1rem 2rem !important;
        }
        
        .gallery-hero h1 {
        font-size: 2rem !important;
        line-height: 1.3 !important;
        }
        
        .gallery-hero p {
        font-size: 1rem !important;
        line-height: 1.6 !important;
        }
        
        .gallery-icon {
        width: 70px !important;
        height: 70px !important;
        font-size: 2rem !important;
        }
        
        .category-filters {
        margin: -1.5rem auto 3rem !important;
        padding: 0 1rem !important;
    }
    
    .filters-container {
        padding: 1.25rem 1.5rem !important;
    }
    
    .filters-title {
        font-size: 1.2rem !important;
        margin-bottom: 1.25rem !important;
    }
    
    .filters {
        gap: 0.5rem !important;
        padding: 0.5rem 0 !important;
    }
    
    .filter-btn {
        font-size: 0.85rem !important;
        padding: 0.6rem 1.2rem !important;
        gap: 0.5rem !important;
    }
    
    .filter-btn i {
        font-size: 1rem !important;
        }
        
        .gallery-container {
        padding: 0 1rem 4rem !important;
        }
        
        .gallery-grid {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
        }
        
        .gallery-card {
        max-width: 100% !important;
        margin: 0 !important;
    }
    
    .gallery-card-content {
        padding: 1rem !important;
    }
    
    .gallery-title {
        font-size: 0.95rem !important;
    }
    
    .gallery-category {
        font-size: 0.75rem !important;
        }
        
        .action-btn {
        padding: 0.6rem !important;
        min-width: 40px !important;
        min-height: 40px !important;
    }
    
    .action-btn i {
        font-size: 1.1rem !important;
    }
    
    .action-count {
        font-size: 0.8rem !important;
    }
    
    /* Mobile toast adjustments */
    .toast-notification {
        bottom: 20px !important;
        right: 20px !important;
        left: 20px !important;
        max-width: none !important;
        padding: 0.875rem 1.25rem !important;
        font-size: 0.9rem !important;
    }
    
    /* Mobile filter scroll improvements */
    .filters {
        padding-bottom: 1rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .filters::-webkit-scrollbar {
        height: 8px !important;
    }
    
    .filters::-webkit-scrollbar-thumb {
        background-color: #3B82F6 !important;
        border-radius: 4px !important;
    }
    
    .filters::-webkit-scrollbar-track {
        background: #F3F4F6 !important;
        border-radius: 4px !important;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="gallery-hero">
    <div class="gallery-hero-content">
        <div class="gallery-icon">
            <i class="fas fa-camera"></i>
        </div>
        <h1>Galeri Foto Sekolah</h1>
        <p>Jelajahi berbagai momen berharga dan kegiatan sekolah kami</p>
    </div>
</section>

<!-- Category Filters -->
<div class="category-filters">
    <div class="filters-container">
        <div class="filters-title">
            <i class="fas fa-filter"></i>
            Filter Kategori
        </div>
        <div class="filters">
            <button class="filter-btn active" data-category="all">
                <i class="fas fa-th-large"></i> Semua
            </button>
            @foreach($kategoris as $kategori)
                @php
                    $slug = strtolower(str_replace([' ', '&'], ['', ''], $kategori->nama));
                @endphp
                <button class="filter-btn" data-category="{{ $slug }}">
                    @switch($slug)
                        @case('lombakemerdekaan')
                            <i class="fas fa-trophy"></i>
                            @break
                        @case('classmeet')
                            <i class="fas fa-users"></i>
                            @break
                        @case('p5')
                            <i class="fas fa-star"></i>
                            @break
                        @case('moontour')
                            <i class="fas fa-moon"></i>
                            @break
                        @case('pensi')
                            <i class="fas fa-music"></i>
                            @break
                        @case('prestasi&penghargaan')
                            <i class="fas fa-award"></i>
                            @break
                        @default
                            <i class="fas fa-folder"></i>
                    @endswitch
                    <span>{{ $kategori->nama }}</span>
                </button>
            @endforeach
        </div>
    </div>
</div>

<!-- Gallery Grid -->
<div class="gallery-container" style="width: 100% !important; margin: 0 auto !important; padding: 0 2rem 4rem !important;">
    @if($fotos->count() > 0)
        <div class="gallery-grid" id="galleryGrid" style="display: grid !important; grid-template-columns: repeat(3, 1fr) !important; gap: 1.5rem !important; padding: 1rem 0 !important; width: 100% !important; max-width: none !important; margin: 0 !important;">
            @foreach($fotos as $foto)
                @php
                    $kategoriSlug = strtolower(str_replace([' ', '&'], ['', ''], $foto->kategori->nama));
                @endphp
                <div class="gallery-card" data-category="{{ $kategoriSlug }}">
                    <div class="gallery-img-container">
                        <img 
                            src="{{ Storage::url($foto->path) }}" 
                            alt="{{ $foto->judul }}" 
                            class="gallery-image"
                            loading="lazy"
                        >
                    </div>
                    <div class="gallery-card-content">
                        <div class="gallery-category">
                            <i class="fas fa-folder"></i>
                            {{ $foto->kategori->nama }}
                        </div>
                        <h3 class="gallery-title">{{ $foto->judul }}</h3>
                        <div class="gallery-actions">
                            <button class="action-btn like-btn {{ $foto->isLikedByUser() ? 'liked' : '' }}" data-foto-id="{{ $foto->id }}" aria-label="Suka">
                                <i class="{{ $foto->isLikedByUser() ? 'fas' : 'far' }} fa-heart"></i>
                                @if($foto->likes->count() > 0)
                                    <span class="action-count">{{ $foto->likes->count() }}</span>
                                @endif
                            </button>
                            <button class="action-btn comment-btn" data-foto-id="{{ $foto->id }}" aria-label="Komentar">
                                <i class="far fa-comment"></i>
                                @if($foto->comments_count > 0)
                                    <span class="action-count">{{ $foto->comments_count }}</span>
                                @endif
                            </button>
                            <a href="{{ route('galeri.download', $foto->id) }}" class="action-btn download-btn" data-foto-id="{{ $foto->id }}" aria-label="Unduh" download>
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-gallery">
            <i class="far fa-images"></i>
            <h3>Belum Ada Foto</h3>
            <p>Maaf, belum ada foto yang tersedia di galeri saat ini. Silakan kembali lagi nanti.</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category Filtering with smooth animation
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-card');
    const galleryGrid = document.getElementById('galleryGrid');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Update active state
            filterButtons.forEach(btn => {
                btn.classList.remove('active');
            });
            
            this.classList.add('active');
            
            const category = this.dataset.category;
            
                // Filter items with animation
                galleryItems.forEach(item => {
                const itemCategory = item.dataset.category;
                const shouldShow = category === 'all' || itemCategory === category;
                
                if (shouldShow) {
                        item.style.display = 'flex';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'translateY(0)';
                        }, 50);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
        });
    });

    // Like functionality with enhanced UX
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            e.stopPropagation();

            const card = this.closest('.gallery-card');
            const fotoId = this.dataset.fotoId;
            const likeCount = this.querySelector('.action-count');
            const icon = this.querySelector('i');
            
            // Visual feedback
            this.disabled = true;
            this.style.pointerEvents = 'none';
            
            // Optimistic UI update with enhanced animation
            const currentLikes = parseInt(likeCount.textContent) || 0;
            const isLiked = this.classList.contains('liked');
            const newLikes = isLiked ? currentLikes - 1 : currentLikes + 1;
            
            // Update counter with animation
            likeCount.textContent = newLikes;
            likeCount.style.transform = 'scale(1.2)';
            likeCount.style.color = '#ef4444';
            setTimeout(() => {
                likeCount.style.transform = 'scale(1)';
                likeCount.style.color = '';
            }, 300);
            
            if (!isLiked) {
                // Like animation with heart beat
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.classList.add('liked');
                icon.style.color = '#ef4444';
                icon.style.transform = 'scale(1.4) rotate(10deg)';
                
                // Heart beat effect
                setTimeout(() => {
                    icon.style.transform = 'scale(1.2) rotate(0deg)';
                }, 150);
                setTimeout(() => {
                    icon.style.transform = 'scale(1) rotate(0deg)';
                }, 300);
                
                // Add pulse effect to button
                this.style.background = 'rgba(239, 68, 68, 0.1)';
                setTimeout(() => {
                    this.style.background = '';
                }, 500);
            } else {
                // Unlike animation
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.classList.remove('liked');
                icon.style.color = '#6B7280';
                icon.style.transform = 'scale(0.7) rotate(-10deg)';
            
            setTimeout(() => {
                    icon.style.transform = 'scale(1) rotate(0deg)';
            }, 200);
            }
            
            try {
                const response = await fetch(`/galeri/${fotoId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    credentials: 'same-origin'
                });
                
                const data = await response.json();
                
                if (!response.ok) {
                    // Revert optimistic update on error
                    likeCount.textContent = currentLikes;
                    if (isLiked) {
                        icon.classList.remove('far');
                        icon.classList.add('fas');
                        this.classList.add('liked');
                        icon.style.color = '#ef4444';
                    } else {
                        icon.classList.remove('fas');
                        icon.classList.add('far');
                        this.classList.remove('liked');
                        icon.style.color = '';
                    }
                    
                    throw new Error(data.message || 'Gagal menyukai foto');
                }
                
                // Update with actual count from server
                likeCount.textContent = data.likes_count;
                
            } catch (error) {
                console.error('Error:', error);
                showToast(error.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
            } finally {
                this.disabled = false;
                this.style.pointerEvents = 'auto';
            }
        });
    });

    // Comment button click handler
    document.querySelectorAll('.comment-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const fotoId = this.dataset.fotoId;
            showCommentModal(fotoId);
        });
    });
    
    // Comment modal function
    function showCommentModal(fotoId) {
        const modal = document.createElement('div');
        modal.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">
                <div style="background: white; border-radius: 16px; padding: 2rem; max-width: 500px; width: 90%; max-height: 80vh; overflow-y: auto;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="margin: 0; color: #1F2937; font-size: 1.5rem;">💬 Komentar</h3>
                        <button onclick="this.closest('div').parentElement.remove()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6B7280;">&times;</button>
                    </div>
                    <form id="commentForm" style="margin-bottom: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 500;">Nama:</label>
                            <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 1rem;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 500;">Email (opsional):</label>
                            <input type="email" name="email" style="width: 100%; padding: 0.75rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 1rem;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 500;">Komentar:</label>
                            <textarea name="content" required rows="4" style="width: 100%; padding: 0.75rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 1rem; resize: vertical;"></textarea>
                        </div>
                        <button type="submit" style="background: #3B82F6; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-size: 1rem; cursor: pointer; width: 100%;">Kirim Komentar</button>
                    </form>
                    <div style="background: #F3F4F6; padding: 1rem; border-radius: 8px; text-align: center; color: #6B7280; font-size: 0.9rem;">
                        <i class="fas fa-info-circle"></i> Komentar akan ditinjau oleh admin sebelum ditampilkan
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Handle form submission
        document.getElementById('commentForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('foto_id', fotoId);
            formData.append('_token', '{{ csrf_token() }}');
            
            try {
                const response = await fetch('/galeri/comment', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    showToast('Komentar berhasil dikirim! Akan ditinjau oleh admin.', 'success');
                    modal.remove();
                } else {
                    showToast(data.message || 'Gagal mengirim komentar', 'error');
                }
            } catch (error) {
                showToast('Terjadi kesalahan saat mengirim komentar', 'error');
            }
        });
    }

    // Download button click handler
    document.querySelectorAll('.download-btn').forEach(button => {
        button.addEventListener('click', function(e) {
                e.preventDefault();
            const fotoId = this.dataset.fotoId;
            
            // Check if user is logged in
            @guest
                // Redirect to login for guests
                window.location.href = '{{ route('login') }}';
            @else
                // Show download form for logged-in users
                showDownloadForm(fotoId);
            @endguest
        });
    });

    // Download form function
    function showDownloadForm(fotoId) {
        const modal = document.createElement('div');
        modal.innerHTML = `
            <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; display: flex; align-items: center; justify-content: center;">
                <div style="background: white; border-radius: 16px; padding: 2rem; max-width: 500px; width: 90%; max-height: 80vh; overflow-y: auto;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                        <h3 style="margin: 0; color: #1F2937; font-size: 1.5rem;">⬇️ Download Foto</h3>
                        <button onclick="this.closest('div').parentElement.remove()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #6B7280;">&times;</button>
                    </div>
                    <form id="downloadForm" style="margin-bottom: 1.5rem;">
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 500;">Nama Lengkap:</label>
                            <input type="text" name="nama" required style="width: 100%; padding: 0.75rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 1rem;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 500;">Email Aktif:</label>
                            <input type="email" name="email" required style="width: 100%; padding: 0.75rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 1rem;">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 500;">Status / Peran:</label>
                            <input type="text" name="status" required style="width: 100%; padding: 0.75rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 1rem;" placeholder="Contoh: Siswa, Guru, Alumni">
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: block; margin-bottom: 0.5rem; color: #374151; font-weight: 500;">Tujuan Penggunaan:</label>
                            <select name="tujuan" required style="width: 100%; padding: 0.75rem; border: 1px solid #D1D5DB; border-radius: 8px; font-size: 1rem;">
                                <option value="">Pilih tujuan penggunaan</option>
                                <option value="tugas_sekolah">Tugas Sekolah</option>
                                <option value="presentasi">Presentasi</option>
                                <option value="dokumentasi">Dokumentasi</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div style="margin-bottom: 1rem;">
                            <label style="display: flex; align-items: center; gap: 0.5rem; color: #374151; font-weight: 500;">
                                <input type="checkbox" name="agree" required style="transform: scale(1.2);">
                                Saya menyetujui syarat dan ketentuan penggunaan foto
                            </label>
                        </div>
                        <button type="submit" style="background: #3B82F6; color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 8px; font-size: 1rem; cursor: pointer; width: 100%;">Download Foto</button>
                    </form>
                    <div style="background: #FEF3C7; padding: 1rem; border-radius: 8px; text-align: center; color: #92400E; font-size: 0.9rem;">
                        <i class="fas fa-exclamation-triangle"></i> Foto ini dilindungi hak cipta. Gunakan dengan bijak dan sesuai tujuan yang telah dijelaskan.
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        
        // Handle form submission
        document.getElementById('downloadForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('foto_id', fotoId);
            formData.append('_token', '{{ csrf_token() }}');
            
            try {
                const response = await fetch('/galeri/download/auth', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                if (response.ok) {
                    showToast('Formulir berhasil dikirim! Download akan dimulai...', 'success');
                    modal.remove();
                    
                    // Start download
                    window.open(`/galeri/${fotoId}/download`, '_blank');
                } else {
                    const data = await response.json();
                    showToast(data.message || 'Gagal mengirim formulir', 'error');
                }
            } catch (error) {
                showToast('Terjadi kesalahan saat mengirim formulir', 'error');
            }
        });
    }
    
    // Show toast notification
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast-notification toast-${type}`;
        toast.textContent = message;
        
        document.body.appendChild(toast);
        
        // Show toast
        setTimeout(() => {
            toast.classList.add('show');
        }, 100);
        
        // Hide after 3 seconds
        setTimeout(() => {
            toast.classList.remove('show');
            
            // Remove from DOM after animation
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 300);
        }, 3000);
    }
    
    // NUCLEAR FORCE GRID LAYOUT - Run every 5ms
    const nuclearForceGrid = () => {
        const galleryGrid = document.getElementById('galleryGrid');
        if (galleryGrid) {
            // Force grid layout with maximum specificity
            galleryGrid.style.cssText = `
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 1.5rem !important;
                padding: 2rem 0 !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                position: relative !important;
                z-index: 99999 !important;
                flex-direction: unset !important;
                flex-wrap: unset !important;
                justify-content: unset !important;
                align-items: unset !important;
                flex: unset !important;
                order: unset !important;
                float: none !important;
                clear: both !important;
                overflow: visible !important;
                visibility: visible !important;
                opacity: 1 !important;
            `;
            
            // Force all cards to be grid items
            const cards = galleryGrid.querySelectorAll('.gallery-card');
            cards.forEach(card => {
                card.style.cssText = `
                    display: block !important;
                    width: 100% !important;
                    max-width: none !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    flex: unset !important;
                    order: unset !important;
                    float: none !important;
                    clear: both !important;
                `;
            });
            
            // Force container to be grid
            const container = document.querySelector('.gallery-container');
            if (container) {
                container.style.cssText = `
                    width: 100% !important;
                    margin: 0 auto !important;
                    padding: 0 2rem 8rem !important;
                    display: block !important;
                `;
            }
        }
    };
    
     // Run nuclear force every 1ms (SUPER AGGRESSIVE!)
     setInterval(nuclearForceGrid, 1);
     
     // Run on all events
     ['click', 'scroll', 'mousemove', 'touchstart', 'keypress', 'keydown', 'focus', 'blur', 'resize', 'load', 'DOMContentLoaded', 'mouseenter', 'mouseleave', 'touchmove', 'touchend'].forEach(event => {
         document.addEventListener(event, nuclearForceGrid);
     });
     
     // Force immediately multiple times
     nuclearForceGrid();
     setTimeout(nuclearForceGrid, 10);
     setTimeout(nuclearForceGrid, 50);
     setTimeout(nuclearForceGrid, 100);
     setTimeout(nuclearForceGrid, 500);
     setTimeout(nuclearForceGrid, 1000);
     
     // Force on window load
     window.addEventListener('load', () => {
         nuclearForceGrid();
         setTimeout(nuclearForceGrid, 100);
         setTimeout(nuclearForceGrid, 500);
     });
     
     // Force on DOM mutations
     const observer = new MutationObserver(() => {
         nuclearForceGrid();
     });
     observer.observe(document.body, { childList: true, subtree: true, attributes: true });
    
    // ULTIMATE FORCE - Run every 1ms
    const ultimateForce = () => {
        const galleryGrid = document.getElementById('galleryGrid');
        if (galleryGrid) {
            // ULTIMATE FORCE - Override everything
            galleryGrid.style.cssText = `
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 1.5rem !important;
                padding: 1rem 0 !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                position: relative !important;
                z-index: 99999 !important;
                flex-direction: unset !important;
                flex-wrap: unset !important;
                justify-content: unset !important;
                align-items: unset !important;
                flex: unset !important;
                order: unset !important;
                float: none !important;
                clear: both !important;
                overflow: visible !important;
                visibility: visible !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
                backdrop-filter: none !important;
                -webkit-backdrop-filter: none !important;
            `;
            
            // Force all cards
            const cards = galleryGrid.querySelectorAll('.gallery-card');
            cards.forEach(card => {
                card.style.cssText = `
                    display: block !important;
                    width: 100% !important;
                    max-width: none !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    flex: unset !important;
                    order: unset !important;
                    float: none !important;
                    clear: both !important;
                    background: white !important;
                    border-radius: 16px !important;
                    overflow: hidden !important;
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                    position: relative !important;
                    height: 100% !important;
                    flex-direction: column !important;
                    border: 1px solid rgba(0, 0, 0, 0.05) !important;
                    cursor: pointer !important;
                    transform: none !important;
                    filter: none !important;
                `;
            });
        }
    };
    
    // Run ultimate force every 1ms
    setInterval(ultimateForce, 1);
    
    // Run on all events
    ['click', 'scroll', 'mousemove', 'touchstart', 'keypress', 'keydown', 'focus', 'blur', 'resize', 'load', 'DOMContentLoaded', 'mouseenter', 'mouseleave', 'touchmove', 'touchend'].forEach(event => {
        document.addEventListener(event, ultimateForce);
    });
    
    // Force immediately
    ultimateForce();
    setTimeout(ultimateForce, 10);
    setTimeout(ultimateForce, 50);
    setTimeout(ultimateForce, 100);
    setTimeout(ultimateForce, 500);
    setTimeout(ultimateForce, 1000);
    
    // Force on window load
    window.addEventListener('load', () => {
        ultimateForce();
        setTimeout(ultimateForce, 100);
        setTimeout(ultimateForce, 500);
    });
    
    // Force on DOM mutations
    const ultimateObserver = new MutationObserver(() => {
        ultimateForce();
    });
    ultimateObserver.observe(document.body, { childList: true, subtree: true, attributes: true });
            // Force grid layout with maximum specificity
            galleryGrid.style.cssText = `
                display: grid !important;
                grid-template-columns: repeat(3, 1fr) !important;
                gap: 1.5rem !important;
                padding: 2rem 0 !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                position: relative !important;
                z-index: 99999 !important;
                flex-direction: unset !important;
                flex-wrap: unset !important;
                justify-content: unset !important;
                align-items: unset !important;
                flex: unset !important;
                order: unset !important;
                float: none !important;
                clear: both !important;
                overflow: visible !important;
                visibility: visible !important;
                opacity: 1 !important;
                transform: none !important;
                filter: none !important;
                backdrop-filter: none !important;
                clip-path: none !important;
                mask: none !important;
                -webkit-mask: none !important;
            `;
            
            // Force all cards to be grid items
            const cards = galleryGrid.querySelectorAll('.gallery-card');
            cards.forEach(card => {
                card.style.cssText = `
                    display: block !important;
                    width: 100% !important;
                    max-width: none !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    flex: unset !important;
                    order: unset !important;
                    float: none !important;
                    clear: both !important;
                    transform: none !important;
                    filter: none !important;
                `;
            });
            
            // Force container to be grid
            const container = document.querySelector('.gallery-container');
            if (container) {
                container.style.cssText = `
                    width: 100% !important;
                    margin: 0 auto !important;
                    padding: 0 2rem 8rem !important;
                    display: block !important;
                `;
            }
        }
    };
    
    // Run ultimate force every 1ms
    setInterval(ultimateForce, 1);
    
    // Run on all events
    ['click', 'scroll', 'mousemove', 'touchstart', 'keypress', 'keydown', 'focus', 'blur', 'resize', 'load', 'DOMContentLoaded'].forEach(event => {
        document.addEventListener(event, ultimateForce);
    });
    
    // Force immediately
    ultimateForce();
});

// NUCLEAR FORCE GRID LAYOUT - ULTIMATE OPTION
function nuclearForceGrid() {
    const galleryGrid = document.getElementById('galleryGrid');
    if (galleryGrid) {
        // FORCE GRID LAYOUT WITH MAXIMUM SPECIFICITY
        galleryGrid.style.display = 'grid';
        galleryGrid.style.gridTemplateColumns = 'repeat(3, 1fr)';
        galleryGrid.style.gap = '1.5rem';
        galleryGrid.style.padding = '1rem 0';
        galleryGrid.style.width = '100%';
        galleryGrid.style.maxWidth = 'none';
        galleryGrid.style.margin = '0';
        galleryGrid.style.position = 'relative';
        galleryGrid.style.zIndex = '99999';
        galleryGrid.style.flexDirection = 'unset';
        galleryGrid.style.flexWrap = 'unset';
        galleryGrid.style.justifyContent = 'unset';
        galleryGrid.style.alignItems = 'unset';
        galleryGrid.style.flex = 'unset';
        galleryGrid.style.order = 'unset';
        galleryGrid.style.float = 'none';
        galleryGrid.style.clear = 'both';
        galleryGrid.style.overflow = 'visible';
        galleryGrid.style.visibility = 'visible';
        galleryGrid.style.opacity = '1';
        galleryGrid.style.transform = 'none';
        galleryGrid.style.filter = 'none';
        galleryGrid.style.backdropFilter = 'none';
        galleryGrid.style.webkitBackdropFilter = 'none';
        galleryGrid.style.gridAutoFlow = 'row';
        galleryGrid.style.gridAutoRows = 'auto';
        galleryGrid.style.alignContent = 'start';
        galleryGrid.style.justifyItems = 'stretch';
        galleryGrid.style.alignItems = 'start';
        
        // FORCE ALL CARDS TO BE GRID ITEMS
        const cards = galleryGrid.querySelectorAll('.gallery-card');
        cards.forEach(card => {
            card.style.cssText = `
                display: block !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                flex: unset !important;
                order: unset !important;
                float: none !important;
                clear: both !important;
                background: white !important;
                border-radius: 16px !important;
                overflow: hidden !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                position: relative !important;
                height: 100% !important;
                flex-direction: column !important;
                border: 1px solid rgba(0, 0, 0, 0.05) !important;
                cursor: pointer !important;
                transform: none !important;
                filter: none !important;
            `;
        });
    }
}

// Run immediately
nuclearForceGrid();

// Run on load
window.addEventListener('load', nuclearForceGrid);

// Run on resize
window.addEventListener('resize', nuclearForceGrid);

// Run every 10ms (ULTRA AGGRESSIVE!)
setInterval(nuclearForceGrid, 10);

// Run on all events
['click', 'scroll', 'mousemove', 'touchstart', 'keypress', 'keydown', 'focus', 'blur', 'resize', 'load', 'DOMContentLoaded', 'mouseenter', 'mouseleave', 'touchmove', 'touchend'].forEach(event => {
    document.addEventListener(event, nuclearForceGrid);
});

// Force on DOM mutations
const observer = new MutationObserver(() => {
    nuclearForceGrid();
});
observer.observe(document.body, { childList: true, subtree: true, attributes: true });

// ULTIMATE FORCE - Run every 1ms
const ultimateForce = () => {
    const galleryGrid = document.getElementById('galleryGrid');
    if (galleryGrid) {
        // ULTIMATE FORCE - Override everything
        galleryGrid.style.display = 'grid';
        galleryGrid.style.gridTemplateColumns = 'repeat(3, 1fr)';
        galleryGrid.style.gap = '1.5rem';
        galleryGrid.style.padding = '1rem 0';
        galleryGrid.style.width = '100%';
        galleryGrid.style.maxWidth = 'none';
        galleryGrid.style.margin = '0';
        galleryGrid.style.position = 'relative';
        galleryGrid.style.zIndex = '99999';
        galleryGrid.style.flexDirection = 'unset';
        galleryGrid.style.flexWrap = 'unset';
        galleryGrid.style.justifyContent = 'unset';
        galleryGrid.style.alignItems = 'unset';
        galleryGrid.style.flex = 'unset';
        galleryGrid.style.order = 'unset';
        galleryGrid.style.float = 'none';
        galleryGrid.style.clear = 'both';
        galleryGrid.style.overflow = 'visible';
        galleryGrid.style.visibility = 'visible';
        galleryGrid.style.opacity = '1';
        galleryGrid.style.transform = 'none';
        galleryGrid.style.filter = 'none';
        galleryGrid.style.backdropFilter = 'none';
        galleryGrid.style.webkitBackdropFilter = 'none';
        galleryGrid.style.gridAutoFlow = 'row';
        galleryGrid.style.gridAutoRows = 'auto';
        galleryGrid.style.alignContent = 'start';
        galleryGrid.style.justifyItems = 'stretch';
        galleryGrid.style.alignItems = 'start';
        
        // Force all cards
        const cards = galleryGrid.querySelectorAll('.gallery-card');
        cards.forEach(card => {
            card.style.cssText = `
                display: block !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                flex: unset !important;
                order: unset !important;
                float: none !important;
                clear: both !important;
                background: white !important;
                border-radius: 16px !important;
                overflow: hidden !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                position: relative !important;
                height: 100% !important;
                flex-direction: column !important;
                border: 1px solid rgba(0, 0, 0, 0.05) !important;
                cursor: pointer !important;
                transform: none !important;
                filter: none !important;
            `;
        });
    }
};

// Run ultimate force every 1ms
setInterval(ultimateForce, 1);

// ULTIMATE FORCE CARDS - Run every 1ms
const ultimateForceCards = () => {
    const cards = document.querySelectorAll('.gallery-card');
    cards.forEach(card => {
        card.style.cssText = `
            display: block !important;
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            padding: 0 !important;
            flex: unset !important;
            order: unset !important;
            float: none !important;
            clear: both !important;
            background: white !important;
            border-radius: 16px !important;
            overflow: hidden !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            position: relative !important;
            height: 100% !important;
            flex-direction: column !important;
            border: 1px solid rgba(0, 0, 0, 0.05) !important;
            cursor: pointer !important;
            transform: none !important;
            filter: none !important;
        `;
    });
};

// Run ultimate force cards every 1ms
setInterval(ultimateForceCards, 1);

// FINAL FORCE - Run every 1ms
const finalForce = () => {
    const galleryGrid = document.getElementById('galleryGrid');
    if (galleryGrid) {
        // FORCE GRID LAYOUT WITH MAXIMUM SPECIFICITY
        galleryGrid.style.cssText = `
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 1.5rem !important;
            padding: 1rem 0 !important;
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            position: relative !important;
            z-index: 99999 !important;
            flex-direction: unset !important;
            flex-wrap: unset !important;
            justify-content: unset !important;
            align-items: unset !important;
            flex: unset !important;
            order: unset !important;
            float: none !important;
            clear: both !important;
            overflow: visible !important;
            visibility: visible !important;
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            grid-auto-flow: row !important;
            grid-auto-rows: auto !important;
            align-content: start !important;
            justify-items: stretch !important;
            align-items: start !important;
        `;
        
        // FORCE ALL CARDS TO BE GRID ITEMS
        const cards = galleryGrid.querySelectorAll('.gallery-card');
        cards.forEach(card => {
            card.style.cssText = `
                display: block !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                flex: unset !important;
                order: unset !important;
                float: none !important;
                clear: both !important;
                background: white !important;
                border-radius: 16px !important;
                overflow: hidden !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                position: relative !important;
                height: 100% !important;
                flex-direction: column !important;
                border: 1px solid rgba(0, 0, 0, 0.05) !important;
                cursor: pointer !important;
                transform: none !important;
                filter: none !important;
            `;
        });
    }
};

// Run final force every 1ms
setInterval(finalForce, 1);

// SUPER FORCE - Run every 1ms
const superForce = () => {
    const galleryGrid = document.getElementById('galleryGrid');
    if (galleryGrid) {
        // FORCE GRID LAYOUT WITH MAXIMUM SPECIFICITY
        galleryGrid.style.cssText = `
            display: grid !important;
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 1.5rem !important;
            padding: 1rem 0 !important;
            width: 100% !important;
            max-width: none !important;
            margin: 0 !important;
            position: relative !important;
            z-index: 99999 !important;
            flex-direction: unset !important;
            flex-wrap: unset !important;
            justify-content: unset !important;
            align-items: unset !important;
            flex: unset !important;
            order: unset !important;
            float: none !important;
            clear: both !important;
            overflow: visible !important;
            visibility: visible !important;
            opacity: 1 !important;
            transform: none !important;
            filter: none !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            grid-auto-flow: row !important;
            grid-auto-rows: auto !important;
            align-content: start !important;
            justify-items: stretch !important;
            align-items: start !important;
        `;
        
        // FORCE ALL CARDS TO BE GRID ITEMS
        const cards = galleryGrid.querySelectorAll('.gallery-card');
        cards.forEach(card => {
            card.style.cssText = `
                display: block !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
                flex: unset !important;
                order: unset !important;
                float: none !important;
                clear: both !important;
                background: white !important;
                border-radius: 16px !important;
                overflow: hidden !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                position: relative !important;
                height: 100% !important;
                flex-direction: column !important;
                border: 1px solid rgba(0, 0, 0, 0.05) !important;
                cursor: pointer !important;
                transform: none !important;
                filter: none !important;
            `;
        });
    }
};

// Run super force every 1ms
setInterval(superForce, 1);

// Run on all events
['click', 'scroll', 'mousemove', 'touchstart', 'keypress', 'keydown', 'focus', 'blur', 'resize', 'load', 'DOMContentLoaded', 'mouseenter', 'mouseleave', 'touchmove', 'touchend'].forEach(event => {
    document.addEventListener(event, ultimateForce);
});

// Force immediately
ultimateForce();
setTimeout(ultimateForce, 10);
setTimeout(ultimateForce, 50);
setTimeout(ultimateForce, 100);
setTimeout(ultimateForce, 500);
setTimeout(ultimateForce, 1000);

// Force on window load
window.addEventListener('load', () => {
    ultimateForce();
    setTimeout(ultimateForce, 100);
    setTimeout(ultimateForce, 500);
});

// Force on DOM mutations
const ultimateObserver = new MutationObserver(() => {
    ultimateForce();
});
ultimateObserver.observe(document.body, { childList: true, subtree: true, attributes: true });
</script>
@endpush