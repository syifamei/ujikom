@extends('layouts.admin')

@section('title', 'Detail Kategori - Admin Panel')

@section('page-title', 'Detail Kategori')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tag me-2"></i>
                    Detail Kategori
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center mb-4">
                            <div class="kategori-icon mx-auto mb-3">
                                <i class="fas fa-tag fa-3x"></i>
                            </div>
                            <h3>{{ $kategori->nama }}</h3>
                            @if($kategori->status === 'Aktif')
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary fs-6">
                                    <i class="fas fa-times-circle me-1"></i>
                                    Nonaktif
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%" class="fw-bold">ID Kategori:</td>
                                <td>{{ $kategori->id }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Nama:</td>
                                <td>{{ $kategori->nama }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Deskripsi:</td>
                                <td>{{ $kategori->deskripsi ?: '-' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Status:</td>
                                <td>
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
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Jumlah Foto:</td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="fas fa-images me-1"></i>
                                        {{ $kategori->fotos()->count() }} foto
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Dibuat:</td>
                                <td>{{ $kategori->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="fw-bold">Diupdate:</td>
                                <td>{{ $kategori->updated_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Photos in this category -->
                @if($kategori->fotos()->count() > 0)
                <div class="mt-4">
                    <h5 class="mb-3">
                        <i class="fas fa-images me-2"></i>
                        Foto dalam Kategori Ini
                    </h5>
                    <div class="row">
                        @foreach($kategori->fotos()->latest()->take(6)->get() as $foto)
                        <div class="col-md-4 col-sm-6 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $foto->path) }}" 
                                     class="card-img-top" 
                                     alt="{{ $foto->judul }}"
                                     style="height: 150px; object-fit: cover;">
                                <div class="card-body p-2">
                                    <h6 class="card-title text-truncate mb-1">{{ $foto->judul }}</h6>
                                    <small class="text-muted">{{ $foto->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if($kategori->fotos()->count() > 6)
                    <div class="text-center mt-3">
                        <a href="{{ route('admin.fotos.index') }}?kategori={{ $kategori->id }}" 
                           class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i>
                            Lihat Semua {{ $kategori->fotos()->count() }} Foto
                        </a>
                    </div>
                    @endif
                </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-3 pt-3 border-top mt-4">
                    <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit Kategori
                    </a>
                    <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" 
                          method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-danger" 
                                onclick="return confirm('Yakin hapus kategori ini?')">
                            <i class="fas fa-trash me-2"></i>
                            Hapus Kategori
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .kategori-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #17a2b8, #138496);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        box-shadow: 0 4px 15px rgba(23, 162, 184, 0.3);
    }

    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        border-bottom: none;
        padding: 1rem 1.5rem;
    }
    
    .card-body {
        padding: 1.5rem;
    }

    .table td {
        padding: 0.75rem 0.5rem;
        border: none;
        vertical-align: middle;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.5rem 0.75rem;
    }

    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
    }
    
    .btn-info:hover {
        background: linear-gradient(135deg, #138496, #117a8b);
    }
    
    .btn-warning {
        background: linear-gradient(135deg, #ffc107, #ffb300);
        color: #000;
    }
    
    .btn-warning:hover {
        background: linear-gradient(135deg, #ffb300, #ff8f00);
        color: #000;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
    }
    
    .btn-danger:hover {
        background: linear-gradient(135deg, #c82333, #bd2130);
    }
    
    .btn-secondary {
        background: #6c757d;
    }
    
    .btn-secondary:hover {
        background: #5a6268;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
        
        .d-flex.gap-3 {
            flex-direction: column;
            gap: 0.5rem !important;
        }
        
        .btn {
            width: 100%;
        }
    }
</style>
@endsection




















































