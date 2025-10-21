@extends('layouts.admin')

@section('title', 'Kategori - Admin Panel')

@section('page-title', 'Kategori')

@section('content')
<!-- Success/Error Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle me-2"></i>
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fas fa-exclamation-circle me-2"></i>
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">
                    <i class="fas fa-tags me-2 text-primary"></i>
                    Manajemen Kategori
                </h2>
                <p class="text-muted mb-0">Kelola kategori foto galeri</p>
            </div>
            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>
                Tambah Kategori
            </a>
        </div>
    </div>
</div>

<!-- Categories List -->
<div class="row">
    <div class="col-12">
        @if($kategoris->count() > 0)
        <div class="list-group">
            @foreach($kategoris as $kategori)
            <div class="list-group-item">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="kategori-icon me-3">
                            <i class="fas fa-tag"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">{{ $kategori->nama }}</h6>
                            <small class="text-muted">
                                ID: {{ $kategori->id }} • 
                                Dibuat: {{ $kategori->created_at->format('d M Y') }}
                            </small>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <!-- Jumlah Foto Badge -->
                        <span class="badge bg-primary">
                            <i class="fas fa-images me-1"></i>
                            {{ $kategori->fotos()->count() }} foto
                        </span>
                        
                        @if($kategori->status === 'Aktif')
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>
                                Aktif
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="fas fa-times-circle me-1"></i>
                                Nonaktif
                            </span>
                        @endif
                        
                        <a href="{{ route('admin.kategori.edit', $kategori->id) }}" 
                           class="btn btn-sm btn-outline-warning" 
                           title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        
                        <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" 
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-sm btn-outline-danger" 
                                    title="Hapus"
                                    onclick="return confirm('Yakin hapus kategori ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <div class="empty-state">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada kategori</h5>
                <p class="text-muted">Mulai dengan membuat kategori pertama</p>
                <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Kategori
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@section('styles')
<style>
    .kategori-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 12px;
    }

    .list-group-item {
        border: 1px solid #e9ecef;
        border-radius: 8px !important;
        margin-bottom: 8px;
        padding: 1rem;
        transition: all 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }

    .list-group-item:last-child {
        margin-bottom: 0;
    }

    .badge {
        font-size: 0.65rem;
        padding: 0.3rem 0.5rem;
        border-radius: 4px;
    }
    
    .badge.bg-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        border: none;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
    }

    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.7rem;
        border-radius: 4px;
    }

    .empty-state {
        padding: 3rem 1rem;
    }

    .gap-2 {
        gap: 0.5rem !important;
    }

    h6 {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.25rem;
    }

    small {
        font-size: 0.8rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .list-group-item {
            padding: 0.75rem;
        }
        
        .btn-sm {
            padding: 0.2rem 0.4rem;
            font-size: 0.65rem;
        }
        
        .kategori-icon {
            width: 28px;
            height: 28px;
            font-size: 10px;
        }
        
        .d-flex.gap-2 {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 576px) {
        .d-flex.justify-content-between {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.5rem;
        }
        
        .d-flex.gap-2 {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>
@endsection
