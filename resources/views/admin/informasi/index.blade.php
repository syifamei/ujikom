@extends('layouts.admin')

@section('title', 'Kelola Informasi - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="info-header-section">
                <div class="info-header-content">
                    <div class="info-header-left">
                        <div class="info-header-icon">
                            <i class="fas fa-newspaper"></i>
                        </div>
                        <div class="info-header-text">
                            <h1 class="info-header-title">Kelola Informasi</h1>
                            <p class="info-header-subtitle">Kelola informasi dan berita sekolah</p>
                        </div>
                    </div>
                    <div class="info-header-right">
                        <a href="{{ route('admin.informasi.create') }}" class="btn btn-add-info">
                            <i class="fas fa-plus"></i>
                            <span>Tambah Informasi</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success Alert -->
                    @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show info-alert" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

            <!-- Informasi List -->
            <div class="info-list-container">
                                @forelse($informasis as $index => $informasi)
                <div class="info-list-item" data-id="{{ $informasi->id }}">
                    <div class="info-item-content">
                        <div class="info-item-header">
                            <div class="info-item-number">{{ $index + 1 }}</div>
                            @if($informasi->gambar)
                            <div class="info-item-photo">
                                <img src="{{ $informasi->gambar_url }}" alt="{{ $informasi->judul }}" 
                                     style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px;">
                            </div>
                            @endif
                            <div class="info-item-title">{{ $informasi->judul }}</div>
                        </div>
                        <div class="info-item-description">{{ $informasi->deskripsi }}</div>
                                        </div>
                    <div class="info-item-actions">
                        <button type="button" class="btn btn-sm btn-info-soft" 
                                onclick="viewInformasi({{ $informasi->id }})" 
                                title="Lihat">
                                                <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning-soft" 
                                onclick="editInformasi({{ $informasi->id }})" 
                                title="Edit">
                                                <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger-soft" 
                                onclick="deleteInformasi({{ $informasi->id }}, '{{ $informasi->judul }}')" 
                                title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                </div>
                                @empty
                <div class="info-empty">
                    <div class="info-empty-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <h3 class="info-empty-title">Belum ada informasi</h3>
                    <p class="info-empty-subtitle">Mulai dengan menambahkan informasi baru</p>
                                            <a href="{{ route('admin.informasi.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i>
                                                Tambah Informasi Pertama
                                            </a>
                                        </div>
                                @endforelse
                    </div>

            <!-- Pagination -->
                    @if($informasis->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $informasis->links() }}
                        </div>
                    @endif
                </div>
            </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">
                    <i class="fas fa-eye me-2"></i>
                    Detail Informasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="view-content">
                    <h6 id="viewTitle" class="view-title"></h6>
                    <p id="viewDescription" class="view-description"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Edit Informasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="editJudul" class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editJudul" name="judul" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDeskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="editDeskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Background */
    body {
        background: linear-gradient(180deg, #f7f9fc 0%, #eef2f7 100%);
        min-height: 100vh;
    }

    /* Header Section */
    .info-header-section {
        background: linear-gradient(135deg, #ffffff 0%, #f7f9fc 100%);
        border: 1px solid #e7ecf3;
        border-radius: 10px;
        padding: 1.6rem;
        margin-bottom: 1.6rem;
        box-shadow: 0 6px 16px rgba(16, 24, 40, 0.06);
    }

    .info-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .info-header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .info-header-icon {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #6b7cff, #8aa0ff);
        border-radius: 10px;
        color: white;
        font-size: 1.5rem;
    }

    .info-header-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #212529;
        margin: 0;
        line-height: 1.2;
    }

    .info-header-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
        margin: 0.25rem 0 0 0;
    }

    .btn-add-info {
        background: linear-gradient(135deg, #74c0fc, #4dabf7);
        border: 1px solid #4dabf7;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        color: #0b2e59;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: background-color 0.2s ease, transform 0.08s ease;
        box-shadow: 0 6px 12px rgba(0,123,255,0.15);
    }

    .btn-add-info:hover {
        background: linear-gradient(135deg, #4dabf7, #339af0);
        color: #0b2e59;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 8px 16px rgba(0,86,179,0.2);
    }

    /* Alert Styling */
    .info-alert {
        border-radius: 6px;
        margin-bottom: 1.5rem;
    }

    /* List Container */
    .info-list-container {
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        border: 1px solid #e7ecf3;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 8px 18px rgba(16, 24, 40, 0.05);
    }

    /* List Item */
    .info-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e9eef6;
        background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(249,251,255,0.98));
        transition: background 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }
    .info-list-item:last-child {
        border-bottom: none;
    }
    .info-list-item:hover {
        background: linear-gradient(180deg, #f3f6fb, #eaf0fb);
        box-shadow: inset 0 0 0 1px rgba(107, 124, 255, 0.08);
    }

    .info-item-content {
        flex: 1;
        margin-right: 1rem;
        min-width: 0; /* enable text truncation within flex */
    }

    .info-item-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.35rem;
        min-width: 0;
    }
    
    .info-item-photo {
        flex-shrink: 0;
    }

    /* Number pill */
    .info-item-number {
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #a0aec0, #7f8ea3);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }

    .info-item-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: #212529;
        margin: 0;
        line-height: 1.3;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
    }

    .info-item-description {
        color: #6c757d;
        font-size: 0.92rem;
        line-height: 1.45;
        margin: 0;
        margin-left: 2.25rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .info-item-actions {
        display: inline-flex;
        gap: 0.4rem;
        flex-shrink: 0;
    }

    .info-item-actions .btn {
        border-radius: 5px;
        padding: 0.35rem 0.65rem;
        font-size: 0.85rem;
        border-width: 1px;
        line-height: 1;
        transition: background-color 0.15s ease, color 0.15s ease, transform 0.08s ease;
    }

    .info-item-actions .btn:active {
        transform: translateY(1px);
    }

    /* Soft buttons */
    .btn-info-soft {
        background: linear-gradient(135deg, #74c0fc, #4dabf7);
        border: 1px solid #4dabf7;
        color: #0b2e59;
    }
    .btn-info-soft:hover { background: linear-gradient(135deg, #4dabf7, #339af0); color: #0b2e59; }

    .btn-warning-soft {
        background: linear-gradient(135deg, #ffd08a, #ffc061);
        border: 1px solid #ffb84a;
        color: #5a3d06;
    }
    .btn-warning-soft:hover { background: linear-gradient(135deg, #ffc061, #ffb347); color: #5a3d06; }

    .btn-danger-soft {
        background: linear-gradient(135deg, #ffa8a8, #ff6b6b);
        border: 1px solid #ff6b6b;
        color: #5a0b0b;
    }
    .btn-danger-soft:hover { background: linear-gradient(135deg, #ff6b6b, #fa5252); color: #5a0b0b; }

    /* Empty State */
    .info-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 3rem 2rem;
        text-align: center;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.06);
    }

    .info-empty-icon {
        width: 60px;
        height: 60px;
        background: #6c757d;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .info-empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .info-empty-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .modal-header, .modal-footer { background: linear-gradient(180deg, #f9fbfd, #f2f5fa); }

    .modal-header {
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        border-radius: 8px 8px 0 0;
    }

    .modal-footer {
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        border-radius: 0 0 8px 8px;
    }

    .view-content { padding: 1rem 0; }

    .view-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.75rem;
    }

    .view-description {
        color: #6c757d;
        font-size: 0.95rem;
        line-height: 1.5;
        margin: 0;
    }

    /* Form Styling */
    .form-control {
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 0.5rem 0.75rem;
        transition: border-color 0.2s ease;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
    }

    .form-label {
        font-weight: 500;
        color: #212529;
        margin-bottom: 0.5rem;
    }
    
    /* Responsive */
    @media (max-width: 767px) {
        .info-list-item { flex-direction: column; align-items: flex-start; gap: 0.75rem; }
        .info-item-content { margin-right: 0; width: 100%; }
        .info-item-description { margin-left: 0; margin-top: 0.35rem; }
        .info-item-actions { width: 100%; justify-content: flex-end; }
    }
</style>
@endsection

@section('scripts')
<script>
let currentEditId = null;

// Make rows clickable to open View, but ignore clicks on action buttons
(function attachRowClickHandlers() {
    document.addEventListener('click', function(e) {
        const actionArea = e.target.closest('.info-item-actions');
        if (actionArea) return; // ignore clicks on buttons area
        const row = e.target.closest('.info-list-item');
        if (!row) return;
        const id = row.getAttribute('data-id');
        if (!id) return;
        viewInformasi(id);
    });
})();

// View function - show modal with only view and close
async function viewInformasi(id) {
    try {
        console.log('Fetching informasi with ID:', id);
        
        // Try to get data from the row first (fallback)
        const card = document.querySelector(`[data-id="${id}"]`);
        if (card) {
            const titleEl = card.querySelector('.info-item-title');
            const descEl = card.querySelector('.info-item-description');
            if (titleEl && descEl) {
                document.getElementById('viewTitle').textContent = titleEl.textContent;
                document.getElementById('viewDescription').textContent = descEl.textContent;
                new bootstrap.Modal(document.getElementById('viewModal')).show();
                return;
            }
        }
        
        const response = await fetch(`/admin/informasi/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        console.log('Response status:', response.status);
        
        if (response.status === 404) {
            alert('Informasi tidak ditemukan!');
            return;
        }
        
        if (response.status === 500) {
            alert('Terjadi kesalahan server. Silakan coba lagi.');
            return;
        }
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Non-JSON response:', text);
            alert('Server mengembalikan response yang tidak valid. Status: ' + response.status);
            return;
        }
        
        const data = await response.json();
        console.log('Response data:', data);
        
        if (data.success) {
            document.getElementById('viewTitle').textContent = data.data.judul;
            document.getElementById('viewDescription').textContent = data.data.deskripsi;
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        } else {
            alert('Gagal memuat data informasi: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data informasi: ' + error.message);
    }
}

// Edit function - show modal with only judul and deskripsi
async function editInformasi(id) {
    currentEditId = id;
    try {
        console.log('Editing informasi with ID:', id);
        
        // Try to get data from the row first (fallback)
        const card = document.querySelector(`[data-id="${id}"]`);
        if (card) {
            const titleEl = card.querySelector('.info-item-title');
            const descEl = card.querySelector('.info-item-description');
            if (titleEl && descEl) {
                document.getElementById('editJudul').value = titleEl.textContent;
                document.getElementById('editDeskripsi').value = descEl.textContent;
                new bootstrap.Modal(document.getElementById('editModal')).show();
                return;
            }
        }
        
        const response = await fetch(`/admin/informasi/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        console.log('Response status:', response.status);
        
        if (response.status === 404) {
            alert('Informasi tidak ditemukan!');
            return;
        }
        
        if (response.status === 500) {
            alert('Terjadi kesalahan server. Silakan coba lagi.');
            return;
        }
        
        // Check if response is JSON
        const contentType = response.headers.get('content-type');
        if (!contentType || !contentType.includes('application/json')) {
            const text = await response.text();
            console.error('Non-JSON response:', text);
            alert('Server mengembalikan response yang tidak valid. Status: ' + response.status);
            return;
        }
        
        const data = await response.json();
        console.log('Response data:', data);
        
        if (data.success) {
            document.getElementById('editJudul').value = data.data.judul;
            document.getElementById('editDeskripsi').value = data.data.deskripsi;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        } else {
            alert('Gagal memuat data informasi: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data informasi: ' + error.message);
    }
}

// Delete function - direct delete with confirmation
    function deleteInformasi(id, judul) {
        if (confirm(`Yakin ingin menghapus informasi "${judul}"?`)) {
        try {
            console.log('Deleting informasi with ID:', id);
            
            // Create form dynamically
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/informasi/${id}`;
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add method override
            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);
            
            // Submit form
            document.body.appendChild(form);
            form.submit();
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menghapus informasi: ' + error.message);
        }
    }
}

// Edit form submission
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editForm');
    if (editForm) {
        editForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            if (!currentEditId) {
                alert('ID informasi tidak valid!');
                return;
            }
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
            submitBtn.disabled = true;
            
            try {
                console.log('Updating informasi with ID:', currentEditId);
                
                const response = await fetch(`/admin/informasi/${currentEditId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: (() => {
                        formData.append('_method', 'PUT');
                        return formData;
                    })()
                });
                
                console.log('Update response status:', response.status);
                
                if (response.status === 404) {
                    alert('Informasi tidak ditemukan!');
                    return;
                }
                
                if (response.status === 422) {
                    const data = await response.json();
                    alert('Data tidak valid: ' + (data.message || 'Silakan periksa kembali form Anda.'));
                    return;
                }
                
                if (response.status === 500) {
                    alert('Terjadi kesalahan server. Silakan coba lagi.');
                    return;
                }
                
                // Check if response is JSON
                const contentType = response.headers.get('content-type');
                if (!contentType || !contentType.includes('application/json')) {
                    const text = await response.text();
                    console.error('Non-JSON response:', text);
                    alert('Server mengembalikan response yang tidak valid. Status: ' + response.status);
                    return;
                }
                
                const data = await response.json();
                console.log('Update response data:', data);
                
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                    alert('Informasi berhasil diupdate!');
                    location.reload();
                } else {
                    alert('Gagal mengupdate informasi: ' + (data.message || 'Unknown error'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan: ' + error.message);
            } finally {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }
        });
    }
});
</script>
@endsection
