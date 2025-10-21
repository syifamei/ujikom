@extends('layouts.admin')

@section('title', 'Petugas - Admin Panel')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0">
                <i class="fas fa-users me-2 text-primary"></i>
                Manajemen Petugas
            </h2>
            <p class="text-muted mb-0">Kelola data petugas admin</p>
        </div>
        <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            Tambah Petugas
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            @if($petugas->count())
                <div class="list-group">
                    @foreach($petugas as $p)
                    <div class="list-group-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <div class="petugas-icon me-3">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">{{ $p->username }}</h6>
                                    <small class="text-muted">
                                        ID: {{ $p->id }} • 
                                        Dibuat: {{ $p->created_at->format('d M Y H:i') }}
                                    </small>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center gap-2">
                                <!-- Password Badge -->
                                <span class="badge bg-primary">
                                    <i class="fas fa-key me-1"></i>
                                    {{ $p->password }}
                                </span>
                                
                                <a href="{{ route('admin.petugas.edit', $p->id) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('admin.petugas.destroy', $p->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Hapus"
                                            onclick="return confirm('Yakin hapus petugas ini?')">
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
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Belum ada petugas</h5>
                        <p class="text-muted">Mulai dengan membuat petugas pertama</p>
                        <a href="{{ route('admin.petugas.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Petugas
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($petugas->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $petugas->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .petugas-icon {
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

    /* Card styling untuk konsistensi */
    .card {
        border: 1px solid #e7ecf3;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 18px rgba(16,24,40,.05);
    }

    .card-header {
        background: linear-gradient(135deg, #ffffff, #f7f9fc);
        border-bottom: 1px solid #e7ecf3;
    }

    .card-title {
        color: #364152;
        font-weight: 700;
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
        
        .petugas-icon {
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
@endpush