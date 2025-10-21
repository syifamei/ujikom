@extends('layouts.admin')

@section('title', 'Detail Informasi - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-eye me-2"></i>
                        Detail Informasi
                    </h4>
                    <div>
                        <a href="{{ route('admin.informasi.edit', $informasi->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>
                            Edit
                        </a>
                        <a href="{{ route('admin.informasi.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>
                            Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <h3 class="text-primary">{{ $informasi->judul }}</h3>
                                <div class="d-flex align-items-center text-muted mb-3">
                                    <i class="fas fa-calendar me-2"></i>
                                    <span>{{ $informasi->tanggal_posting ? $informasi->tanggal_posting->format('d F Y') : 'Tidak ada tanggal' }}</span>
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-user me-2"></i>
                                    <span>{{ $informasi->admin->name ?? 'Admin' }}</span>
                                    <span class="mx-2">•</span>
                                    <span class="badge {{ $informasi->status === 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $informasi->status ?? 'Tidak ada status' }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5>Deskripsi Singkat</h5>
                                <p class="text-muted">{{ $informasi->deskripsi }}</p>
                            </div>

                            <div class="mb-4">
                                <h5>Konten Lengkap</h5>
                                <div class="border rounded p-3 bg-light">
                                    {!! nl2br(e($informasi->konten ?? $informasi->deskripsi)) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Aksi</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.informasi.edit', $informasi->id) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit me-1"></i>
                                            Edit Informasi
                                        </a>
                                        
                                        
                                        <form action="{{ route('admin.informasi.destroy', $informasi->id) }}" 
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-danger btn-sm w-100"
                                                    onclick="return confirm('Yakin ingin menghapus informasi ini? Tindakan ini tidak dapat dibatalkan.')">
                                                <i class="fas fa-trash me-1"></i>
                                                Hapus Informasi
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
