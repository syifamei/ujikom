@extends('layouts.admin')

@section('title', 'Detail Informasi - Admin Panel')

@section('page-title', 'Detail Informasi')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">
                        <i class="fas fa-eye me-2"></i>
                        Detail Informasi
                    </h3>
                    <p class="text-muted mb-0">Lihat detail lengkap informasi</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>
                        Edit
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Post Details -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-newspaper me-2"></i>
                        {{ $post->judul }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Post Meta Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-calendar text-primary me-2"></i>
                                <strong>Tanggal dibuat:</strong>
                                <span class="ms-2">
                                    @if($post->created_at)
                                        @if($post->created_at instanceof \Carbon\Carbon)
                                            {{ $post->created_at->format('d M Y H:i') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($post->created_at)->format('d M Y H:i') }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($post->updated_at && $post->updated_at != $post->created_at)
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-edit text-primary me-2"></i>
                                    <strong>Terakhir diupdate:</strong>
                                    <span class="ms-2">
                                        @if($post->updated_at)
                                            @if($post->updated_at instanceof \Carbon\Carbon)
                                                {{ $post->updated_at->format('d M Y H:i') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($post->updated_at)->format('d M Y H:i') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Post Content -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">
                            <i class="fas fa-align-left me-2"></i>
                            Isi Informasi:
                        </h6>
                        <div class="border rounded p-3 bg-light">
                            {!! nl2br(e($post->isi)) !!}
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus informasi ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>
                                    Hapus
                                </button>
                            </form>
                        </div>
                        <div>
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary me-2">
                                <i class="fas fa-list me-2"></i>
                                Daftar Semua
                            </a>
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
