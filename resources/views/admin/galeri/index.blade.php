@extends('layouts.admin')

@section('title', 'Galeri - Admin Panel')

@section('page-title', 'Galeri')

@section('content')

<!-- Header Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">
                    <i class="fas fa-images me-2 text-primary"></i>
                    Manajemen Galeri
                </h2>
                <p class="text-muted mb-0">Kelola koleksi foto sekolah</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.fotos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Tambah Foto
                </a>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#commentModerationModal">
                    <i class="fas fa-comments me-2"></i>
                    Moderasi Komentar
                    @if($pendingCommentsCount > 0)
                        <span class="badge bg-danger ms-1">{{ $pendingCommentsCount }}</span>
                    @endif
                </button>
                <button class="btn btn-info" onclick="generateReport()">
                    <i class="fas fa-file-pdf me-2"></i>
                    Generate Laporan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Gallery Content -->
<div class="gallery-container">
    @forelse($fotos as $foto)
    <div class="gallery-item">
        <div class="gallery-card">
            <div class="gallery-card-header">
                <div class="gallery-actions">
                    <a href="{{ route('admin.fotos.show', $foto->id) }}" class="gallery-action action-view" title="Lihat">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.fotos.edit', $foto->id) }}" class="gallery-action action-edit" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.fotos.destroy', $foto->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="gallery-action action-delete" title="Hapus" onclick="return confirm('Hapus foto ini?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="gallery-thumb-wrapper">
                <img src="{{ asset('storage/'.$foto->path) }}" alt="{{ $foto->judul }}" class="gallery-thumb">
                <div class="gallery-overlay">
                    <div class="gallery-overlay-content">
                        <i class="fas fa-search-plus"></i>
                    </div>
                </div>
            </div>
            <div class="gallery-card-body">
                <div class="gallery-title">{{ $foto->judul }}</div>
                <div class="gallery-category">
                    <i class="fas fa-tag"></i>
                    <span>{{ $foto->kategori ? $foto->kategori->nama : 'Belum ada kategori' }}</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="gallery-empty">
        <div class="gallery-empty-icon">
            <i class="fas fa-images"></i>
        </div>
        <h3 class="gallery-empty-title">Belum ada foto</h3>
        <p class="gallery-empty-subtitle">Mulai dengan menambahkan foto pertama ke galeri</p>
        <a href="{{ route('admin.fotos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Foto Pertama
        </a>
    </div>
    @endforelse
</div>

@endsection

@section('styles')
<style>
    /* CSS Variables */
    :root {
        --primary-color: #667eea;
        --secondary-color: #f093fb;
        --success-color: #4facfe;
        --info-color: #43e97b;
        --warning-color: #fa709a;
        --glass-bg: rgba(255, 255, 255, 0.25);
        --glass-border: rgba(255, 255, 255, 0.18);
        --shadow-light: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        --shadow-medium: 0 15px 35px rgba(0, 0, 0, 0.1);
        --shadow-heavy: 0 20px 40px rgba(0, 0, 0, 0.15);
    }


    /* Background */
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
    }


    /* Gallery Container */
    .gallery-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.5rem;
        width: 100%;
        max-width: 100%;
        padding: 0;
    }

    .gallery-item {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    /* Gallery Card */
    .gallery-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: var(--shadow-light);
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        min-height: 350px;
        position: relative;
        width: 100%;
        max-width: 100%;
    }

    .gallery-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-heavy);
    }

    /* Gallery Card Header */
    .gallery-card-header {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        padding: 1rem 1rem 0.5rem;
        position: relative;
        z-index: 2;
    }


    .gallery-actions {
        display: flex;
        gap: 0.5rem;
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    .gallery-card:hover .gallery-actions {
        opacity: 1;
    }
    /* Gallery Thumbnail */
    .gallery-thumb-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3;
        overflow: hidden;
        background: #f8f9fa;
        margin: 0 1rem;
        border-radius: 15px;
    }

    .gallery-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }

    .gallery-card:hover .gallery-thumb {
        transform: scale(1.05);
    }

    .gallery-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .gallery-card:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-overlay-content {
        color: white;
        font-size: 2rem;
    }

    /* Gallery Actions */
    .gallery-actions {
        display: flex;
        gap: 0.5rem;
        opacity: 1;
        transition: opacity 0.3s ease;
    }

    .gallery-card:hover .gallery-actions {
        opacity: 1;
    }

    .gallery-action {
        width: 36px !important;
        height: 36px !important;
        border-radius: 8px !important;
        border: none !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-size: 0.9rem !important;
        transition: all 0.3s ease !important;
        text-decoration: none !important;
        color: white !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
        background: #17a2b8 !important;
    }

    .gallery-action:hover {
        transform: scale(1.1) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
        text-decoration: none !important;
        color: white !important;
    }

    .action-view {
        background: #17a2b8 !important;
        color: white !important;
    }

    .action-view:hover {
        background: #17a2b8 !important;
        color: white !important;
    }

    .action-view:active,
    .action-view:focus,
    .action-view:focus-visible {
        background: #17a2b8 !important;
        color: white !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
        transform: none !important;
        outline: none !important;
    }

    .action-edit {
        background: #ffc107 !important;
        color: #000 !important;
    }

    .action-edit:hover {
        background: #ffc107 !important;
        color: #000 !important;
    }

    .action-delete {
        background: #dc3545 !important;
        color: white !important;
    }

    .action-delete:hover {
        background: #dc3545 !important;
        color: white !important;
    }
    /* Gallery Card Body */
    .gallery-card-body {
        padding: 1rem 1.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        flex: 1 1 auto;
    }

    .gallery-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .gallery-category {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
    }

    .gallery-category i {
        font-size: 0.8rem;
        color: var(--primary-color);
    }


    /* Gallery Empty State */
    .gallery-empty {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 4rem 2rem;
        text-align: center;
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        border: 1px solid var(--glass-border);
        border-radius: 20px;
        box-shadow: var(--shadow-light);
    }

    .gallery-empty-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-color);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
        animation: pulse 2s infinite;
    }

    .gallery-empty-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }

    .gallery-empty-subtitle {
        color: #6c757d;
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    /* Animations */
    @keyframes pulse {
        0%, 100% { 
            transform: scale(1); 
        }
        50% { 
            transform: scale(1.05); 
        }
    }

    @keyframes fadeInUp {
        from { 
            opacity: 0; 
            transform: translateY(30px);
        }
        to { 
            opacity: 1; 
            transform: translateY(0);
        }
    }

    /* Staggered Animation */
    .gallery-item:nth-child(1) { animation: fadeInUp 0.6s ease-out 0.1s both; }
    .gallery-item:nth-child(2) { animation: fadeInUp 0.6s ease-out 0.2s both; }
    .gallery-item:nth-child(3) { animation: fadeInUp 0.6s ease-out 0.3s both; }
    .gallery-item:nth-child(4) { animation: fadeInUp 0.6s ease-out 0.4s both; }
    .gallery-item:nth-child(5) { animation: fadeInUp 0.6s ease-out 0.5s both; }
    .gallery-item:nth-child(6) { animation: fadeInUp 0.6s ease-out 0.6s both; }
    .gallery-item:nth-child(7) { animation: fadeInUp 0.6s ease-out 0.7s both; }
    .gallery-item:nth-child(8) { animation: fadeInUp 0.6s ease-out 0.8s both; }

    /* Responsive */
    @media (max-width: 1200px) {
        .gallery-container {
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }
    }

    @media (max-width: 991px) {
        .gallery-header-title { 
            font-size: 1.7rem; 
        }
        .gallery-card { 
            min-height: 320px; 
        }
        .gallery-container {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
    }

    @media (max-width: 767px) {
        .gallery-header-section {
            padding: 1.5rem;
        }
        
        .gallery-header-title { 
            font-size: 1.5rem; 
        }
        
        .gallery-header-subtitle {
            font-size: 0.9rem;
        }
        
        .gallery-card { 
            min-height: 280px; 
        }
        
        .gallery-card-body { 
            padding: 0.8rem 1rem 1rem; 
        }
        
        .gallery-container {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 0.75rem;
        }
    }

    @media (max-width: 575px) {
        .gallery-header-section {
            padding: 1rem;
        }
        
        .gallery-header-content {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }
        
        .gallery-header-left {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }
        
        .gallery-header-icon { 
            width: 50px; 
            height: 50px; 
            font-size: 1.5rem; 
        }
        
        .gallery-header-title {
            font-size: 1.3rem;
        }
        
        .btn-add-foto { 
            font-size: 0.9rem; 
            padding: 0.6rem 1.2rem; 
        }
        
        .gallery-card { 
            border-radius: 15px; 
            min-height: 250px;
        }
        
        .gallery-container {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .gallery-empty {
            padding: 2rem 1rem;
        }
        
        .gallery-empty-icon {
            width: 60px;
            height: 60px;
            font-size: 2rem;
        }

        /* Header responsive adjustments */
        .d-flex.justify-content-between {
            flex-direction: column;
            align-items: stretch !important;
            gap: 1rem;
        }

        .d-flex.gap-2 {
            flex-direction: column;
            width: 100%;
        }

        .d-flex.gap-2 .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .btn {
            font-size: 0.85rem;
            padding: 0.6rem 1rem;
        }
    }

    /* Extra responsive for very small screens */
    @media (max-width: 400px) {
        .gallery-card {
            min-height: 220px;
        }

        .gallery-title {
            font-size: 0.95rem;
        }

        .gallery-action {
            width: 32px !important;
            height: 32px !important;
            font-size: 0.8rem !important;
        }

        h2 {
            font-size: 1.2rem;
        }

        .btn {
            font-size: 0.8rem;
            padding: 0.5rem 0.8rem;
        }
    }

    /* Modal responsiveness */
    @media (max-width: 767px) {
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100% - 1rem);
        }

        .modal-xl {
            max-width: calc(100% - 1rem);
        }

        .modal-body .row .col-md-6 {
            margin-bottom: 1rem;
        }

        .comments-section {
            max-height: 300px;
        }

        .comment-item {
            font-size: 0.85rem;
        }
    }
</style>

<!-- Comment Moderation Modal -->
<div class="modal fade" id="commentModerationModal" tabindex="-1" aria-labelledby="commentModerationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModerationModalLabel">
                    <i class="fas fa-comments me-2"></i>
                    Moderasi Komentar
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-warning">
                            <i class="fas fa-clock me-2"></i>
                            Komentar Menunggu Persetujuan
                        </h6>
                        <div id="pendingComments" class="comments-section">
                            <!-- Pending comments will be loaded here -->
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">
                            <i class="fas fa-check me-2"></i>
                            Komentar Disetujui
                        </h6>
                        <div id="approvedComments" class="comments-section">
                            <!-- Approved comments will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function loadComments() {
    // Load pending comments
    fetch('/admin/comments/pending')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayComments(data.comments, 'pendingComments');
            }
        });

    // Load approved comments
    fetch('/admin/comments/approved')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayComments(data.comments, 'approvedComments');
            }
        });
}

function displayComments(comments, containerId) {
    const container = document.getElementById(containerId);
    if (comments.length === 0) {
        container.innerHTML = '<p class="text-muted text-center">Tidak ada komentar</p>';
        return;
    }

    let html = '';
    comments.forEach(comment => {
        const isPending = containerId === 'pendingComments';
        html += `
            <div class="comment-item border rounded p-3 mb-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <strong>${comment.user ? comment.user.name : comment.author_name}</strong>
                        <small class="text-muted d-block">${new Date(comment.created_at).toLocaleString()}</small>
                    </div>
                    <div class="comment-actions">
                        ${isPending ? `
                            <button class="btn btn-sm btn-success me-1" onclick="moderateComment(${comment.id}, 'approved')" title="Setujui">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="moderateComment(${comment.id}, 'rejected')" title="Tolak">
                                <i class="fas fa-times"></i>
                            </button>
                        ` : `
                            <button class="btn btn-sm btn-warning" onclick="moderateComment(${comment.id}, 'pending')" title="Kembalikan ke Pending">
                                <i class="fas fa-undo"></i>
                            </button>
                        `}
                    </div>
                </div>
                <p class="mb-2">${comment.content}</p>
                <small class="text-muted">
                    <i class="fas fa-image me-1"></i>
                    Foto: ${comment.foto.judul}
                </small>
            </div>
        `;
    });
    container.innerHTML = html;
}

function moderateComment(commentId, status) {
    fetch(`/admin/comments/${commentId}/moderate`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ status: status })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadComments(); // Reload comments
            // Update pending count if needed
            if (status === 'approved' || status === 'rejected') {
                updatePendingCount();
            }
        } else {
            alert('Gagal memoderasi komentar: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memoderasi komentar');
    });
}

function updatePendingCount() {
    fetch('/admin/comments/pending/count')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const badge = document.querySelector('.badge.bg-danger');
                if (data.count > 0) {
                    if (badge) {
                        badge.textContent = data.count;
                    } else {
                        const button = document.querySelector('[data-bs-target="#commentModerationModal"]');
                        button.innerHTML += ` <span class="badge bg-danger ms-1">${data.count}</span>`;
                    }
                } else if (badge) {
                    badge.remove();
                }
            }
        });
}

function generateReport() {
    // Generate PDF report
    window.open('/admin/gallery/report', '_blank');
}

// Load comments when modal is shown
document.getElementById('commentModerationModal').addEventListener('shown.bs.modal', function () {
    loadComments();
});
</script>

<style>
.comments-section {
    max-height: 500px;
    overflow-y: auto;
}

.comment-item {
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.comment-item:hover {
    background: #e9ecef;
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.comment-actions .btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
</style>
@endsection
