@extends('layouts.admin')

@section('title', 'Tambah Informasi Baru - Admin Panel')

@section('page-title', 'Tambah Informasi Baru')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="mb-1">
                        <i class="fas fa-plus me-2"></i>
                        Tambah Informasi Baru
                    </h3>
                    <p class="text-muted mb-0">Buat informasi atau berita baru untuk website sekolah</p>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Form Informasi
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Judul -->
                        <div class="mb-3">
                            <label for="judul" class="form-label">
                                <i class="fas fa-heading me-1"></i>
                                Judul Informasi <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" 
                                   name="judul" 
                                   value="{{ old('judul') }}" 
                                   placeholder="Masukkan judul informasi"
                                   required>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi/Isi -->
                        <div class="mb-3">
                            <label for="isi" class="form-label">
                                <i class="fas fa-align-left me-1"></i>
                                Deskripsi/Isi Informasi <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('isi') is-invalid @enderror" 
                                      id="isi" 
                                      name="isi" 
                                      rows="8" 
                                      placeholder="Tulis deskripsi atau isi informasi lengkap"
                                      required>{{ old('isi') }}</textarea>
                            @error('isi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                Simpan Informasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Auto-resize textarea
    const textarea = document.getElementById('isi');
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });
</script>
@endsection
