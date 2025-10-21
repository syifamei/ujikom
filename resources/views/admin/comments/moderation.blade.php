@extends('layouts.admin')

@section('title', 'Moderasi Komentar - Admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
<div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-comments me-2"></i>
                        Moderasi Komentar
                    </h3>
                </div>
    <div class="card-body">
                    <!-- Filter Tabs -->
                    <ul class="nav nav-tabs" id="commentTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                                <i class="fas fa-clock me-1"></i>
                                Menunggu Persetujuan
                                <span class="badge bg-warning ms-2" id="pending-count">0</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab">
                                <i class="fas fa-check-circle me-1"></i>
                                Disetujui
                                <span class="badge bg-success ms-2" id="approved-count">0</span>
                            </button>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="commentTabsContent">
                        <!-- Pending Comments -->
                        <div class="tab-pane fade show active" id="pending" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Komentar</th>
                                            <th>Penulis</th>
                                            <th>Tanggal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pending-comments">
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Approved Comments -->
                        <div class="tab-pane fade" id="approved" role="tabpanel">
            <div class="table-responsive">
                                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Komentar</th>
                                            <th>Penulis</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                                    <tbody id="approved-comments">
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                </table>
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load pending comments
    loadPendingComments();
    loadApprovedComments();
    loadPendingCount();

    // Auto refresh every 30 seconds
    setInterval(() => {
        loadPendingCount();
        if (document.getElementById('pending-tab').classList.contains('active')) {
            loadPendingComments();
        }
    }, 30000);

    function loadPendingComments() {
        fetch('/admin/comments/pending')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayComments(data.comments, 'pending-comments');
                }
            })
            .catch(error => {
                console.error('Error loading pending comments:', error);
                document.getElementById('pending-comments').innerHTML = 
                    '<tr><td colspan="5" class="text-center text-danger">Gagal memuat komentar</td></tr>';
            });
    }

    function loadApprovedComments() {
        fetch('/admin/comments/approved')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    displayComments(data.comments, 'approved-comments');
                }
            })
            .catch(error => {
                console.error('Error loading approved comments:', error);
                document.getElementById('approved-comments').innerHTML = 
                    '<tr><td colspan="5" class="text-center text-danger">Gagal memuat komentar</td></tr>';
            });
    }

    function loadPendingCount() {
        fetch('/admin/comments/pending/count')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('pending-count').textContent = data.count;
                }
            })
            .catch(error => {
                console.error('Error loading pending count:', error);
            });
    }

    function displayComments(comments, containerId) {
        const container = document.getElementById(containerId);
        
        if (comments.length === 0) {
            container.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Tidak ada komentar</td></tr>';
            return;
        }

        container.innerHTML = comments.map(comment => `
            <tr>
                <td>
                    <div class="d-flex align-items-center">
                        <img src="/storage/${comment.foto.path}" alt="${comment.foto.judul}" 
                             class="img-thumbnail me-2" style="width: 50px; height: 50px; object-fit: cover;">
                        <div>
                            <div class="fw-bold">${comment.foto.judul}</div>
                            <small class="text-muted">${comment.foto.kategori?.nama || 'Lainnya'}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="comment-content">
                        <p class="mb-1">${comment.content}</p>
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            ${new Date(comment.created_at).toLocaleString('id-ID')}
                        </small>
                    </div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                            ${comment.user ? comment.user.name.charAt(0).toUpperCase() : (comment.author_name ? comment.author_name.charAt(0).toUpperCase() : 'A')}
                        </div>
                        <div>
                            <div class="fw-bold">${comment.user ? comment.user.name : comment.author_name}</div>
                            <small class="text-muted">${comment.user ? 'User Terdaftar' : 'Guest'}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <small class="text-muted">
                        ${new Date(comment.created_at).toLocaleDateString('id-ID')}
                    </small>
                </td>
                <td>
                    <div class="btn-group" role="group">
                        ${comment.status === 'pending' ? `
                            <button class="btn btn-success btn-sm" onclick="moderateComment(${comment.id}, 'approved')" title="Setujui">
                                <i class="fas fa-check"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="moderateComment(${comment.id}, 'rejected')" title="Tolak">
                                <i class="fas fa-times"></i>
                            </button>
                        ` : `
                            <button class="btn btn-warning btn-sm" onclick="moderateComment(${comment.id}, 'pending')" title="Kembalikan ke Pending">
                                <i class="fas fa-undo"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="moderateComment(${comment.id}, 'rejected')" title="Tolak">
                                <i class="fas fa-times"></i>
                            </button>
                        `}
                    </div>
                </td>
            </tr>
        `).join('');
    }

    // Global function for moderation
    window.moderateComment = function(commentId, status) {
        if (!confirm(`Apakah Anda yakin ingin ${status === 'approved' ? 'menyetujui' : status === 'rejected' ? 'menolak' : 'mengembalikan'} komentar ini?`)) {
            return;
        }

        fetch(`/admin/comments/${commentId}/moderate`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showToast(`Komentar berhasil ${status === 'approved' ? 'disetujui' : status === 'rejected' ? 'ditolak' : 'dikembalikan'}`, 'success');
                
                // Reload the current tab
                if (document.getElementById('pending-tab').classList.contains('active')) {
                    loadPendingComments();
                } else {
                    loadApprovedComments();
                }
                
                // Update counts
                loadPendingCount();
            } else {
                showToast('Gagal memoderasi komentar', 'error');
            }
        })
        .catch(error => {
            console.error('Error moderating comment:', error);
            showToast('Terjadi kesalahan saat memoderasi komentar', 'error');
        });
    };

    // Show toast notification
    function showToast(message, type = 'info') {
        const toast = document.createElement('div');
        toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} border-0`;
        toast.setAttribute('role', 'alert');
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove from DOM after hiding
        toast.addEventListener('hidden.bs.toast', () => {
            document.body.removeChild(toast);
        });
    }
});
</script>
@endpush