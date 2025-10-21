@extends('layouts.admin')

@section('title', 'Detail Foto - Admin Panel')

@section('page-title', 'Detail Foto')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-image me-2"></i>
                    Detail Foto
                </h4>
                <a href="{{ route('admin.fotos.index') }}" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="photo-preview">
                            <img src="{{ asset('storage/' . $foto->path) }}" 
                                 alt="{{ $foto->judul }}" 
                                 class="img-fluid rounded shadow-sm"
                                 style="max-height: 400px; width: 100%; object-fit: contain;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="photo-details">
                            <h5 class="text-primary mb-3">{{ $foto->judul }}</h5>
                            
                            
                            <div class="detail-item mb-3">
                                <label class="fw-bold text-muted">Kategori:</label>
                                <span class="badge bg-info">{{ $foto->kategori ? $foto->kategori->nama : 'Belum ada kategori' }}</span>
                            </div>
                            
                            
                            <div class="detail-item mb-3">
                                <label class="fw-bold text-muted">Tanggal Upload:</label>
                                <p class="mb-0">{{ $foto->created_at->format('d M Y H:i') }}</p>
                            </div>
                            
                            <div class="detail-item mb-3">
                                <label class="fw-bold text-muted">Terakhir Diupdate:</label>
                                <p class="mb-0">{{ $foto->updated_at->format('d M Y H:i') }}</p>
                            </div>
                            
                            <div class="detail-item mb-3">
                                <label class="fw-bold text-muted">File Path:</label>
                                <p class="mb-0 text-muted small">{{ $foto->path }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .detail-item {
        border-bottom: 1px solid #eee;
        padding-bottom: 0.5rem;
    }
    
    .detail-item:last-child {
        border-bottom: none;
    }
    
    .photo-preview {
        text-align: center;
        background: #f8f9fa;
        border-radius: 8px;
        padding: 1rem;
    }
    
    .card {
        border: none;
        border-radius: 15px;
    }
    
    .card-header {
        border-radius: 15px 15px 0 0;
    }
    
    .badge {
        font-size: 0.8rem;
        padding: 0.5rem 0.75rem;
    }
</style>
@endsection







