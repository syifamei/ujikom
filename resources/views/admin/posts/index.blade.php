@extends('layouts.admin')

@section('title', 'Kelola Informasi - Admin Panel')

@section('page-title', 'Kelola Informasi')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">
                        <i class="fas fa-newspaper me-2"></i>
                        Daftar Informasi
                    </h3>
                    <p class="text-muted mb-0">Kelola semua informasi dan berita sekolah</p>
                </div>
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Informasi Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Posts List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Semua Informasi
                    </h5>
                </div>
                <div class="card-body">
                    @if($posts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover custom-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $index => $post)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $post->judul }}</strong>
                                                @if($post->isi)
                                                    <br>
                                                    <small class="text-muted">{{ Str::limit($post->isi, 150) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($post->created_at)
                                                    @if($post->created_at instanceof \Carbon\Carbon)
                                                        {{ $post->created_at->format('d M Y H:i') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($post->created_at)->format('d M Y H:i') }}
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.posts.show', $post->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.posts.edit', $post->id) }}" 
                                                       class="btn btn-sm btn-warning" 
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus informasi ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger" 
                                                                title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        @if($posts->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-newspaper text-muted fa-4x mb-3"></i>
                            <h5 class="text-muted">Belum ada informasi</h5>
                            <p class="text-muted">Mulai dengan menambahkan informasi baru</p>
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                Tambah Informasi Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Custom Table Styling */
    .custom-table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border: none;
    }
    
    .custom-table thead {
        background: linear-gradient(135deg, #4a90e2, #7bb3f0);
    }
    
    .custom-table thead th {
        border: none;
        color: white;
        font-weight: 600;
        padding: 15px 10px;
        font-size: 0.9rem;
    }
    
    .custom-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f0f0f0;
    }
    
    .custom-table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .custom-table tbody td {
        padding: 15px 10px;
        vertical-align: middle;
        border: none;
    }
    
    /* Card Styling */
    .card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-bottom: 1px solid #dee2e6;
        padding: 1.5rem;
    }
</style>
@endsection
