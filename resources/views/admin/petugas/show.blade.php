@extends('layouts.admin')

@section('title', 'Detail Petugas - Admin Panel')

@section('page-title', 'Detail Petugas')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    Detail Petugas: {{ $petugas->username }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Username:</label>
                            <p class="mb-0">{{ $petugas->username }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tanggal Dibuat:</label>
                            <p class="mb-0">{{ $petugas->created_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Terakhir Diupdate:</label>
                            <p class="mb-0">{{ $petugas->updated_at->format('d F Y, H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status:</label>
                            <span class="badge bg-success">Aktif</span>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.petugas.edit', $petugas->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit Petugas
                    </a>
                    <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                    <form action="{{ route('admin.petugas.destroy', $petugas->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">
                            <i class="fas fa-trash me-2"></i>
                            Hapus Petugas
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card {
    max-width: 100%;
    overflow: hidden;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.btn {
    max-width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
}

/* Responsive */
@media (max-width: 768px) {
    .d-flex.gap-2 {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .btn {
        width: 100%;
    }
}
</style>
@endpush




























































