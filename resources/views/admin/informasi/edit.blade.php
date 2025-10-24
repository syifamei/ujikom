@extends('layouts.admin')

@section('title', 'Edit Informasi - Admin')

@push('styles')
<style>
    .spinner-border {
        display: none;
        width: 1.5rem;
        height: 1.5rem;
        margin-left: 0.5rem;
    }
    .btn-save:disabled {
        cursor: not-allowed;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Informasi
                    </h4>
                </div>
                <div class="card-body">
                    <div id="alert-container"></div>
                    <form id="editInformasiForm" action="{{ route('admin.informasi.update', $informasi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="_method" value="PUT">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Informasi <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                                           id="judul" name="judul" value="{{ old('judul', $informasi->judul) }}" 
                                           placeholder="Masukkan judul informasi" required>
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="gambar" class="form-label">Foto Informasi</label>
                                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                                           id="gambar" name="gambar" accept="image/*">
                                    @if($informasi->gambar)
                                        <div class="mt-2">
                                            <small class="text-muted">Foto saat ini:</small><br>
                                            <img src="{{ $informasi->gambar_url }}" alt="Current photo" 
                                                 class="img-thumbnail" style="max-width: 150px; max-height: 150px;">
                                        </div>
                                    @endif
                                    <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB</div>
                                    @error('gambar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Singkat <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                              id="deskripsi" name="deskripsi" rows="3" 
                                              placeholder="Masukkan deskripsi singkat informasi" required>{{ old('deskripsi', $informasi->deskripsi) }}</textarea>
                                    <div class="form-text">Maksimal 500 karakter</div>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="konten" class="form-label">Konten Lengkap <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('konten') is-invalid @enderror" 
                                              id="konten" name="konten" rows="6" 
                                              placeholder="Masukkan konten lengkap informasi" required>{{ old('konten', $informasi->konten) }}</textarea>
                                    @error('konten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.informasi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>
                                Kembali
                            </a>
                            <button type="submit" class="btn btn-primary btn-save" id="saveButton">
                                <i class="fas fa-save me-1"></i>
                                <span>Update Informasi</span>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize CKEditor if needed
    if (typeof CKEDITOR !== 'undefined') {
        CKEDITOR.replace('konten', {
            toolbar: [
                { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat'] },
                { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
                { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
                '/',
                { name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize'] },
                { name: 'colors', items: ['TextColor', 'BGColor'] },
                { name: 'tools', items: ['Maximize', 'ShowBlocks'] },
                { name: 'document', items: ['Source'] }
            ],
            height: 300,
            filebrowserUploadUrl: '{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}',
            filebrowserUploadMethod: 'form'
        });
    }
    
    // Handle form submission
    $('#editInformasiForm').on('submit', function(e) {
        e.preventDefault();
        
        // Show loading state
        const submitBtn = $('#saveButton');
        const originalBtnText = submitBtn.html();
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...');
        
        // Clear previous alerts
        $('#alert-container').html('');
        
        // If using CKEditor, update textarea content
        if (typeof CKEDITOR !== 'undefined' && CKEDITOR.instances.konten) {
            CKEDITOR.instances.konten.updateElement();
        }
        
        // Create FormData object
        const formData = new FormData(this);
        
        // Log form data for debugging
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        // Send AJAX request
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    window.location.href = '{{ route('admin.informasi.index') }}';
                }
            },
            error: function(xhr) {
                console.error('Error response:', xhr);
                let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                let errorDetails = '';
                
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    errorDetails = '<ul class="mb-0">';
                    
                    for (const field in errors) {
                        errorDetails += '<li><strong>' + field + ':</strong> ' + errors[field][0] + '</li>';
                        // Add error class to the corresponding input
                        $('[name="' + field + '"]').addClass('is-invalid').next('.invalid-feedback').text(errors[field][0]);
                    }
                    
                    errorDetails += '</ul>';
                    
                    $('#alert-container').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<h5 class="alert-heading">Validasi gagal!</h5>' + 
                        '<div class="small">Silakan periksa isian form di bawah:</div>' +
                        errorDetails +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>'
                    );
                } else if (xhr.status === 500) {
                    // Server error
                    $('#alert-container').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<h5 class="alert-heading">Kesalahan Server!</h5>' +
                        '<p class="mb-0">' + (xhr.responseJSON?.message || 'Terjadi kesalahan server. Silakan coba lagi.') + '</p>' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>'
                    );
                } else {
                    // Other errors
                    $('#alert-container').html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<h5 class="alert-heading">Error!</h5>' +
                        '<p class="mb-0">' + errorMessage + '</p>' +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                        '</div>'
                    );
                }
                
                // Re-enable submit button
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                // Scroll to top to show error message
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        });
    });
        
        // Disable button and show spinner
        saveButton.prop('disabled', true);
        spinner.show();
        buttonText.text('Menyimpan...');
        
        // Clear previous alerts
        $('#alert-container').empty();
        
        // Submit the form via AJAX
        $.ajax({
            url: '{{ route('admin.informasi.update', $informasi->id) }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    const alert = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            ${response.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    $('#alert-container').html(alert);
                    
                    // Redirect after a short delay
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1500);
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    // Handle validation errors
                    const errors = xhr.responseJSON.errors;
                    errorMessage = '';
                    
                    for (const field in errors) {
                        errorMessage += errors[field].join('<br>') + '<br>';
                    }
                }
                
                const alert = `
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        ${errorMessage}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                
                $('#alert-container').html(alert);
            },
            complete: function() {
                // Re-enable button and hide spinner
                saveButton.prop('disabled', false);
                spinner.hide();
                buttonText.text('Update Informasi');
                
                // Scroll to top to show alert
                $('html, body').animate({
                    scrollTop: 0
                }, 200);
            }
        });
    });
});
</script>
@endpush

@endsection
