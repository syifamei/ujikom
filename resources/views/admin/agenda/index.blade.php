@extends('layouts.admin')

@section('title', 'Kelola Agenda - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                <i class="fas fa-calendar-alt text-primary fs-4"></i>
                            </div>
                            <div>
                                <h2 class="h4 mb-0 fw-bold">Kelola Agenda</h2>
                                <p class="text-muted mb-0">Kelola agenda dan kegiatan sekolah</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            <span>Tambah Agenda</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Success Alert -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show agenda-alert" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Error Alert -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show agenda-alert" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Agenda List -->
            <div class="agenda-list-container">
                @forelse($agendas as $index => $agenda)
                <div class="agenda-list-item" data-id="{{ $agenda->id }}">
                    <div class="agenda-item-content">
                        <div class="agenda-item-header">
                            <div class="agenda-item-number">{{ $index + 1 }}</div>
                            <div class="agenda-item-title">{{ $agenda->title ?? 'Agenda' }}</div>
                            <div class="agenda-item-status">
                                <span class="badge {{ $agenda->status == 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $agenda->status }}
                                </span>
                            </div>
                        </div>
                        <div class="agenda-item-description">{{ $agenda->description ?? 'Tidak ada deskripsi' }}</div>
                        <div class="agenda-item-meta">
                            <span class="agenda-meta-item">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $agenda->scheduled_at ? $agenda->scheduled_at->format('d M Y') : 'Tidak ada tanggal' }}
                            </span>
                            @if($agenda->scheduled_at && $agenda->scheduled_at->format('H:i') !== '00:00')
                            <span class="agenda-meta-item">
                                <i class="fas fa-clock me-1"></i>
                                {{ $agenda->scheduled_at->format('H:i') }}
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="agenda-item-actions">
                        <button type="button" class="btn btn-sm btn-info-soft" 
                                onclick="viewAgenda({{ $agenda->id }})" 
                                title="Lihat">
                            <i class="fas fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning-soft" 
                                onclick="editAgenda({{ $agenda->id }})" 
                                title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger-soft" 
                                onclick="deleteAgenda({{ $agenda->id }}, '{{ $agenda->judul }}')" 
                                title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                @empty
                <div class="agenda-empty">
                    <div class="agenda-empty-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3 class="agenda-empty-title">Belum ada agenda</h3>
                    <p class="agenda-empty-subtitle">Mulai dengan menambahkan agenda baru</p>
                    <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        Tambah Agenda Pertama
                    </a>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($agendas->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $agendas->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">
                    <i class="fas fa-eye me-2"></i>
                    Detail Agenda
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="view-content">
                    <h6 id="viewTitle" class="view-title"></h6>
                    <p id="viewDescription" class="view-description"></p>
                    <div class="view-meta">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Tanggal:</strong> <span id="viewTanggal"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Waktu:</strong> <span id="viewWaktu"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Lokasi:</strong> <span id="viewLokasi"></span>
                            </div>
                            <div class="col-md-6">
                                <strong>Status:</strong> <span id="viewStatus"></span>
                            </div>
                        </div>
                    </div>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    Edit Agenda
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editJudul" class="form-label">Judul <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editJudul" name="judul" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editStatus" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="editDeskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="editDeskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="editTanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="editTanggal" name="tanggal" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="editWaktu" class="form-label">Waktu</label>
                            <input type="text" class="form-control" id="editWaktu" name="waktu" placeholder="Contoh: 08:00 - 12:00">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="editLokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="editLokasi" name="lokasi" placeholder="Contoh: Aula Utama">
                        </div>
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
    .agenda-header-section {
        background: linear-gradient(135deg, #ffffff 0%, #f7f9fc 100%);
        border: 1px solid #e7ecf3;
        border-radius: 10px;
        padding: 1.6rem;
        margin-bottom: 1.6rem;
        box-shadow: 0 6px 16px rgba(16, 24, 40, 0.06);
    }

    .agenda-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .agenda-header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .agenda-header-icon {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #28a745, #20c997);
        border-radius: 10px;
        color: white;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .agenda-header-title {
        font-size: 1.75rem;
        font-weight: 600;
        color: #212529;
        margin: 0;
        line-height: 1.2;
    }

    .agenda-header-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
        margin: 0.25rem 0 0 0;
    }

    .btn-add-agenda {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: 1px solid #20c997;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        color: white;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: background-color 0.2s ease, transform 0.08s ease;
        box-shadow: 0 6px 12px rgba(40, 167, 69, 0.15);
    }

    .btn-add-agenda:hover {
        background: linear-gradient(135deg, #20c997, #17a2b8);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 8px 16px rgba(40, 167, 69, 0.2);
    }

    /* Alert Styling */
    .agenda-alert {
        border-radius: 6px;
        margin-bottom: 1.5rem;
    }

    /* List Container */
    .agenda-list-container {
        background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        border: 1px solid #e7ecf3;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 8px 18px rgba(16, 24, 40, 0.05);
    }

    /* List Item */
    .agenda-list-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e9eef6;
        background: linear-gradient(180deg, rgba(255,255,255,0.98), rgba(249,251,255,0.98));
        transition: background 0.2s ease, box-shadow 0.2s ease;
        cursor: pointer;
    }
    .agenda-list-item:last-child {
        border-bottom: none;
    }
    .agenda-list-item:hover {
        background: linear-gradient(180deg, #f3f6fb, #eaf0fb);
        box-shadow: inset 0 0 0 1px rgba(40, 167, 69, 0.08);
    }

    .agenda-item-content {
        flex: 1;
        margin-right: 1rem;
        min-width: 0;
    }

    .agenda-item-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.35rem;
        min-width: 0;
    }

    /* Number pill */
    .agenda-item-number {
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #28a745, #20c997);
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

    .agenda-item-title {
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
        flex: 1;
    }

    .agenda-item-status {
        flex-shrink: 0;
    }

    .agenda-item-description {
        color: #6c757d;
        font-size: 0.92rem;
        line-height: 1.45;
        margin: 0 0 0.5rem 0;
        margin-left: 2.25rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .agenda-item-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-left: 2.25rem;
    }

    .agenda-meta-item {
        color: #6c757d;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
    }

    .agenda-item-actions {
        display: inline-flex;
        gap: 0.4rem;
        flex-shrink: 0;
    }

    .agenda-item-actions .btn {
        border-radius: 5px;
        padding: 0.35rem 0.65rem;
        font-size: 0.85rem;
        border-width: 1px;
        line-height: 1;
        transition: background-color 0.15s ease, color 0.15s ease, transform 0.08s ease;
    }

    .agenda-item-actions .btn:active {
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
    .agenda-empty {
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

    .agenda-empty-icon {
        width: 60px;
        height: 60px;
        background: #28a745;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2rem;
        margin-bottom: 1rem;
    }

    .agenda-empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
    }

    .agenda-empty-subtitle {
        color: #6c757d;
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }

    /* Modal Styling */
    .modal-content {
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .modal-header, .modal-footer { 
        background: linear-gradient(180deg, #f9fbfd, #f2f5fa); 
    }

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
        margin: 0 0 1rem 0;
    }

    .view-meta {
        background: #f8f9fa;
        padding: 1rem;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }

    /* Form Styling */
    .form-control, .form-select {
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 0.5rem 0.75rem;
        transition: border-color 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25);
    }

    .form-label {
        font-weight: 500;
        color: #212529;
        margin-bottom: 0.5rem;
    }
    
    /* Responsive */
    @media (max-width: 767px) {
        .agenda-list-item { 
            flex-direction: column; 
            align-items: flex-start; 
            gap: 0.75rem; 
        }
        .agenda-item-content { 
            margin-right: 0; 
            width: 100%; 
        }
        .agenda-item-description, .agenda-item-meta { 
            margin-left: 0; 
            margin-top: 0.35rem; 
        }
        .agenda-item-actions { 
            width: 100%; 
            justify-content: flex-end; 
        }
    }
</style>
@endsection

@section('scripts')
<script>
let currentEditId = null;

// Make rows clickable to open View, but ignore clicks on action buttons
(function attachRowClickHandlers() {
    document.addEventListener('click', function(e) {
        const actionArea = e.target.closest('.agenda-item-actions');
        if (actionArea) return; // ignore clicks on buttons area
        const row = e.target.closest('.agenda-list-item');
        if (!row) return;
        const id = row.getAttribute('data-id');
        if (!id) return;
        viewAgenda(id);
    });
})();

// View function - show modal with agenda details
async function viewAgenda(id) {
    try {
        console.log('Fetching agenda with ID:', id);
        
        // Try to get data from the row first (fallback)
        const card = document.querySelector(`[data-id="${id}"]`);
        if (card) {
            const titleEl = card.querySelector('.agenda-item-title');
            const descEl = card.querySelector('.agenda-item-description');
            if (titleEl && descEl) {
                document.getElementById('viewTitle').textContent = titleEl.textContent;
                document.getElementById('viewDescription').textContent = descEl.textContent;
                new bootstrap.Modal(document.getElementById('viewModal')).show();
                return;
            }
        }
        
        const response = await fetch(`/admin/agenda/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        console.log('Response status:', response.status);
        
        if (response.status === 404) {
            alert('Agenda tidak ditemukan!');
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
            document.getElementById('viewTitle').textContent = data.data.title || 'Agenda';
            document.getElementById('viewDescription').textContent = data.data.description || 'Tidak ada deskripsi';
            document.getElementById('viewTanggal').textContent = data.data.scheduled_at ? new Date(data.data.scheduled_at).toLocaleDateString('id-ID') : '-';
            document.getElementById('viewWaktu').textContent = data.data.scheduled_at ? new Date(data.data.scheduled_at).toLocaleTimeString('id-ID', {hour: '2-digit', minute: '2-digit'}) : '-';
            document.getElementById('viewLokasi').textContent = '-';
            document.getElementById('viewStatus').innerHTML = `<span class="badge ${data.data.status == 'Aktif' ? 'bg-success' : 'bg-secondary'}">${data.data.status}</span>`;
            new bootstrap.Modal(document.getElementById('viewModal')).show();
        } else {
            alert('Gagal memuat data agenda: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data agenda: ' + error.message);
    }
}

// Edit function - show modal with agenda form
async function editAgenda(id) {
    currentEditId = id;
    try {
        console.log('Editing agenda with ID:', id);
        
        const response = await fetch(`/admin/agenda/${id}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
        
        console.log('Response status:', response.status);
        
        if (response.status === 404) {
            alert('Agenda tidak ditemukan!');
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
            document.getElementById('editJudul').value = data.data.title || '';
            document.getElementById('editDeskripsi').value = data.data.description || '';
            document.getElementById('editTanggal').value = data.data.scheduled_at ? data.data.scheduled_at.split(' ')[0] : '';
            document.getElementById('editWaktu').value = data.data.scheduled_at ? data.data.scheduled_at.split(' ')[1] || '' : '';
            document.getElementById('editLokasi').value = '';
            document.getElementById('editStatus').value = data.data.status;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        } else {
            alert('Gagal memuat data agenda: ' + (data.message || 'Unknown error'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data agenda: ' + error.message);
    }
}

// Delete function - direct delete with confirmation
function deleteAgenda(id, judul) {
    if (confirm(`Yakin ingin menghapus agenda "${judul}"?`)) {
        try {
            console.log('Deleting agenda with ID:', id);
            
            // Create form dynamically
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/agenda/${id}`;
            
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
            alert('Terjadi kesalahan saat menghapus agenda: ' + error.message);
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
                alert('ID agenda tidak valid!');
                return;
            }
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
            submitBtn.disabled = true;
            
            try {
                console.log('Updating agenda with ID:', currentEditId);
                
                const response = await fetch(`/admin/agenda/${currentEditId}`, {
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
                    alert('Agenda tidak ditemukan!');
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
                    // If not JSON, it might be a redirect or HTML response
                    if (response.status === 200) {
                        // Success but not JSON - probably a redirect
                        bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                        alert('Agenda berhasil diupdate!');
                        location.reload();
                        return;
                    } else {
                        const text = await response.text();
                        console.error('Non-JSON response:', text);
                        alert('Server mengembalikan response yang tidak valid. Status: ' + response.status);
                        return;
                    }
                }
                
                const data = await response.json();
                console.log('Update response data:', data);
                
                if (data.success) {
                    bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
                    alert('Agenda berhasil diupdate!');
                    location.reload();
                } else {
                    alert('Gagal mengupdate agenda: ' + (data.message || 'Unknown error'));
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