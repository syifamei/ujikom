@extends('layouts.admin')

@section('title', 'Tambah Foto - Admin Panel')

@section('page-title', 'Tambah Foto Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-camera me-2"></i>
                    Tambah Foto Baru
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.fotos.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                    @csrf
                    
                    <!-- Two Column Layout for Judul and Kategori -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="judul" class="form-label fw-semibold">
                                Judul Foto <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                   id="judul" name="judul" value="{{ old('judul') }}" required 
                                   placeholder="Contoh: Upacara Bendera">
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="kategori_id" class="form-label fw-semibold">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('kategori_id') is-invalid @enderror" 
                                    id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" 
                                            {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    
                    <!-- Upload Section -->
                    <div class="mb-3">
                        <label for="foto" class="form-label fw-semibold">
                            Upload Foto <span class="text-danger">*</span>
                        </label>
                        <div class="upload-area" id="uploadArea">
                            <div class="upload-content" id="uploadContent">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                <p class="mb-2">Drag & drop foto di sini atau</p>
                                <button type="button" class="btn btn-outline-primary" id="browseBtn">
                                    <i class="fas fa-folder-open me-2"></i>Pilih File
                                </button>
                                <input type="file" class="form-control d-none @error('foto') is-invalid @enderror" 
                                       id="foto" name="foto" accept="image/*" required>
                            </div>
                            <div class="file-selected-content d-none" id="fileSelectedContent">
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-image fa-2x text-success me-3"></i>
                                        <div>
                                            <p class="mb-1 fw-semibold" id="fileName">Foto dipilih</p>
                                            <small class="text-muted" id="fileSize">-</small>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" id="changeFileBtn">
                                        <i class="fas fa-edit me-1"></i>Ganti
                                    </button>
                                </div>
                                <div id="previewContainer" class="d-none">
                                    <div class="position-relative d-inline-block">
                                        <img id="imagePreview" class="img-fluid rounded shadow-sm" style="max-height: 150px;">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1" id="removeImageBtn" title="Hapus foto">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @error('foto')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                        
                        <small class="text-muted mt-2 d-block">
                            <i class="fas fa-info-circle me-1"></i>
                            Format: JPG, PNG, GIF. Maks: 5MB
                        </small>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-3 pt-3 border-top">
                        <a href="{{ route('admin.fotos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            Batal
                        </a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <i class="fas fa-upload me-2"></i>
                            Upload Foto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Form Container */
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: none;
        padding: 0.75rem 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    /* Form Controls */
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #e0e0e0;
        padding: 0.5rem 0.7rem;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        background-color: #fff;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        outline: none;
    }
    
    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
    }
    
    /* Upload Area */
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        padding: 2rem 1rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background-color: #f8f9fa;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .upload-area:hover {
        border-color: #0d6efd;
        background-color: #f0f8ff;
    }
    
    .upload-area.dragover {
        border-color: #0d6efd;
        background-color: #e3f2fd;
        transform: scale(1.02);
    }
    
    .upload-content {
        color: #6c757d;
    }
    
    .upload-content i {
        color: #adb5bd;
    }
    
    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #0b5ed7, #0a58ca);
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
            padding: 1.5rem;
        }
        
        .upload-area {
            padding: 2rem 1rem;
            min-height: 150px;
        }
        
        .btn {
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }
    }
    
    /* Preview Image */
    #imagePreview {
        border: 2px solid #e0e0e0;
        border-radius: 8px;
    }
    
    /* Loading State */
    .btn:disabled {
        opacity: 0.7;
        transform: none;
    }
    
    /* Remove Image Button */
    #removeImageBtn {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    #removeImageBtn:hover {
        transform: scale(1.1);
    }
    
    /* File Selected Content */
    .file-selected-content {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 8px;
        border: 2px solid #28a745;
    }
    
    .file-selected-content .text-success {
        color: #28a745 !important;
    }
    
    .file-selected-content .btn-outline-danger {
        border-color: #dc3545;
        color: #dc3545;
    }
    
    .file-selected-content .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadArea = document.getElementById('uploadArea');
    const fileInput = document.getElementById('foto');
    const browseBtn = document.getElementById('browseBtn');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const uploadForm = document.getElementById('uploadForm');
    const submitBtn = document.getElementById('submitBtn');
    const removeImageBtn = document.getElementById('removeImageBtn');
    const uploadContent = document.getElementById('uploadContent');
    const fileSelectedContent = document.getElementById('fileSelectedContent');
    const fileName = document.getElementById('fileName');
    const fileSize = document.getElementById('fileSize');
    const changeFileBtn = document.getElementById('changeFileBtn');

    // Browse button click
    browseBtn.addEventListener('click', () => fileInput.click());

    // Change file button click
    changeFileBtn.addEventListener('click', () => fileInput.click());

    // Remove image button click
    removeImageBtn.addEventListener('click', function() {
        // Clear file input
        fileInput.value = '';
        
        // Hide preview and file selected content
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.classList.add('d-none');
        fileSelectedContent.classList.add('d-none');
        
        // Show upload area content again
        uploadContent.classList.remove('d-none');
    });

    // File input change
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            showFileSelected(file);
            previewImage(file);
        }
    });

    // Drag and drop functionality
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', function() {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        uploadArea.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            fileInput.files = e.dataTransfer.files;
            showFileSelected(file);
            previewImage(file);
        }
    });

    function showFileSelected(file) {
        // Hide upload content and show file selected content
        uploadContent.classList.add('d-none');
        fileSelectedContent.classList.remove('d-none');
        
        // Update file info
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        
        // Show preview container inside the upload area
        const previewContainer = document.getElementById('previewContainer');
        previewContainer.classList.remove('d-none');
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function previewImage(file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            imagePreview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Form submission
    uploadForm.addEventListener('submit', function(e) {
        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';
        submitBtn.disabled = true;

        // Let the form submit naturally (no preventDefault)
        // The controller will handle the redirect
    });
});
</script>
@endsection

