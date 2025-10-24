@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
<style>
/* Gaya Dasar */
body {
    font-family: 'Poppins', sans-serif;
    background-color: #f8f9fa;
    color: #333;
}

/* Kontainer Utama */
.galeri-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

/* Judul Halaman */
.judul-halaman {
    text-align: center;
    margin-bottom: 2rem;
}

.judul-halaman h1 {
    font-size: 2.2rem;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.judul-halaman p {
    color: #7f8c8d;
    font-size: 1.1rem;
}

/* Grid Galeri */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-top: 2rem;
}

/* Responsive adjustments */
@media (max-width: 992px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}

/* Item Galeri */
.gallery-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.gallery-image-container {
    width: 100%;
    height: 220px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.gallery-card:hover .gallery-image {
    transform: scale(1.05);
}

.gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    padding: 1rem;
    color: white;
    pointer-events: none;
}

.gallery-stats {
    margin-top: 0.5rem;
    font-size: 0.9rem;
    opacity: 0.9;
}

.gallery-stats span {
    margin-right: 1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.25rem;
}

.gallery-title {
    font-size: 1rem;
    font-weight: 600;
    margin: 0 0 0.25rem 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.gallery-date {
    font-size: 0.8rem;
    opacity: 0.9;
    margin: 0;
}

/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.modal-overlay.active {
    opacity: 1;
    visibility: visible;
}

.modal-content {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 1000px;
    max-height: 90vh;
    overflow: hidden;
    display: flex;
    transform: translateY(20px);
    transition: transform 0.3s ease;
}

.modal-overlay.active .modal-content {
    transform: translateY(0);
}

.modal-image-container {
    flex: 2;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.modal-image {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
}

.modal-sidebar {
    flex: 1;
    padding: 1.5rem;
    overflow-y: auto;
    max-height: 80vh;
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 1.5rem;
    color: #495057;
    transition: all 0.2s ease;
}

.modal-close:hover {
    background: #f1f3f5;
}

/* Download Modal */
.download-modal {
    background: white;
    border-radius: 12px;
    width: 90%;
    max-width: 500px;
    padding: 2rem;
    position: relative;
}

.download-modal h3 {
    margin-top: 0;
    color: #2c3e50;
    font-size: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.25rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #495057;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.2s ease;
}

.form-control:focus {
    border-color: #4dabf7;
    outline: none;
    box-shadow: 0 0 0 3px rgba(77, 171, 247, 0.2);
}

.btn {
    display: inline-block;
    font-weight: 500;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.75rem 1.5rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 8px;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-primary {
    background: #4dabf7;
    color: white;
    border: none;
}

.btn-primary:hover {
    background: #339af0;
}

.btn-block {
    display: block;
    width: 100%;
}

/* Comments Section */
.comments-section {
    margin-top: 2rem;
    padding-top: 1.5rem;
    border-top: 1px solid #eee;
}

.comments-list {
    max-height: 300px;
    overflow-y: auto;
    margin-bottom: 1.5rem;
}

.comment {
    display: flex;
    margin-bottom: 1rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #f1f3f5;
}

.comment:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.comment-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f1f3f5;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
}

.comment-content {
    flex: 1;
}

.comment-author {
    font-weight: 600;
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.comment-text {
    margin: 0;
    font-size: 0.9rem;
    line-height: 1.5;
}

.comment-time {
    font-size: 0.75rem;
    color: #6c757d;
    margin-top: 0.25rem;
}
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-3">Galeri Foto</h1>
        <p class="lead text-muted">Koleksi momen berharga dari kegiatan sekolah kami</p>
    </div>
    
    <!-- Kategori Filter -->
    <div class="mb-4">
        <div class="d-flex flex-wrap gap-2 justify-content-center">
            <a href="{{ route('galeri') }}" class="btn btn-outline-primary {{ !request('kategori') ? 'active' : '' }}">
                Semua Kategori
            </a>
            @foreach($kategoris as $kategori)
                @php
                    $kategoriSlug = strtolower(str_replace([' ', '&'], ['', ''], $kategori->nama));
                @endphp
                <a href="{{ route('galeri', ['kategori' => $kategoriSlug]) }}" 
                   class="btn btn-outline-primary {{ request('kategori') === $kategoriSlug ? 'active' : '' }}">
                    {{ $kategori->nama }}
                </a>
            @endforeach
        </div>
    </div>
    
    <!-- Gallery Grid -->
    <div class="gallery-grid">
        @forelse($fotos as $foto)
            <div class="gallery-card">
                <div class="gallery-image-container" onclick="openModal({{ $foto->id }})">
                    <img src="{{ Storage::url($foto->lokasi_file) }}" alt="{{ $foto->judul }}" class="gallery-image">
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">{{ $foto->judul }}</h3>
                        <p class="gallery-date">{{ $foto->created_at->format('d M Y') }}</p>
                        <div class="gallery-stats">
                            <span><i class="far fa-heart"></i> {{ $foto->likes_count ?? 0 }}</span>
                            <span><i class="far fa-comment"></i> {{ $foto->comments_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <h2>Tidak ada foto tersedia</h2>
                    <p class="lead">Belum ada foto yang diunggah untuk kategori ini.</p>
                </div>
            </div>
        @endforelse
    </div>
    
    <!-- Image Modal -->
    <div id="imageModal" class="modal-overlay">
        <button class="modal-close" onclick="closeModal()">&times;</button>
        <div class="modal-content">
            <div class="modal-image-container">
                <img id="modalImage" src="" alt="" class="modal-image">
            </div>
            <div class="modal-sidebar">
                <h2 id="modalTitle"></h2>
                <p id="modalDate" class="text-muted"></p>
                
                <!-- Like and Comment Buttons -->
                <div class="d-flex gap-3 mb-3">
                    <button class="btn btn-outline-primary like-btn" onclick="toggleLike(currentFotoId, this)">
                        <i class="far fa-heart"></i> <span class="like-count">0</span>
                    </button>
                    <button class="btn btn-outline-primary comment-btn" data-foto-id="1">
                        <i class="far fa-comment"></i> <span class="comment-count">0</span>
                    </button>
                    <button class="btn btn-outline-success download-btn" onclick="showDownloadModal({{ $foto->id ?? '' }})">
                        <i class="fas fa-download"></i> Unduh
                    </button>
                </div>
                
                <!-- Comments Section -->
                <div class="comments-section">
                    <h5>Komentar</h5>
                    <div class="comments-list" id="commentsList">
                        <!-- Comments will be loaded here -->
                        <p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                    </div>
                    <form id="commentForm" class="mt-3">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Tulis komentar..." required>
                            <button class="btn btn-primary" type="submit">Kirim</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Download Modal -->
    <div id="downloadModal" class="modal-overlay">
        <div class="download-modal">
            <button class="modal-close" onclick="closeDownloadModal()">&times;</button>
            <h3>Unduh Foto</h3>
            <p>Silakan isi data diri Anda untuk mengunduh foto.</p>
            <form id="downloadForm">
                <input type="hidden" id="fotoId" name="foto_id">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Unduh Sekarang</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
<script>
let currentFotoId = null;

// Open modal with image
function openModal(fotoId, event) {
    if (event) event.stopPropagation();
    
    const fotoCard = document.querySelector(`[data-foto-id="${fotoId}"]`).closest('.gallery-card');
    const imgSrc = fotoCard.querySelector('img').src;
    const title = fotoCard.querySelector('.gallery-title').textContent;
    const date = fotoCard.querySelector('.gallery-date').textContent;
    const stats = fotoCard.querySelectorAll('.gallery-stats span');
    const likeCount = stats[0] ? stats[0].textContent.trim().split(' ')[1] : '0';
    const commentCount = stats[1] ? stats[1].textContent.trim().split(' ')[1] : '0';
    
    currentFotoId = fotoId;
    document.getElementById('modalImage').src = imgSrc;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDate').textContent = date;
    document.querySelector('.modal-sidebar .like-count').textContent = likeCount;
    document.querySelector('.modal-sidebar .comment-count').textContent = commentCount;
    document.getElementById('fotoId').value = fotoId;
    
    // Show modal
    document.getElementById('imageModal').classList.add('active');
    document.body.style.overflow = 'hidden';
    
    // Load comments
    loadComments(fotoId);
}

// Close modal
function closeModal() {
    document.getElementById('imageModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Show download modal
function showDownloadModal(fotoId, event) {
    if (event) event.stopPropagation();
    document.getElementById('fotoId').value = fotoId;
    document.getElementById('downloadModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Close download modal
function closeDownloadModal() {
    document.getElementById('downloadModal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

// Toggle like
function toggleLike(fotoId, button) {
    const likeIcon = button.querySelector('i');
    const likeCount = button.querySelector('.like-count');
    const isLiked = likeIcon.classList.contains('fas');
    
    // Toggle icon and update count
    if (isLiked) {
        likeIcon.className = 'far fa-heart';
        likeCount.textContent = parseInt(likeCount.textContent) - 1;
    } else {
        likeIcon.className = 'fas fa-heart text-danger';
        likeCount.textContent = parseInt(likeCount.textContent) + 1;
    }
    
    // Update the count in the gallery card
    const galleryCard = document.querySelector(`[data-foto-id="${fotoId}"]`).closest('.gallery-card');
    if (galleryCard) {
        const galleryLikeCount = galleryCard.querySelector('.gallery-stats span:first-child');
        if (galleryLikeCount) {
            galleryLikeCount.innerHTML = `<i class="far fa-heart"></i> ${likeCount.textContent}`;
        }
    }
    
    // In a real app, you would make an API call to like/unlike
    // fetch(`/api/fotos/${fotoId}/like`, { method: 'POST' })
    //     .then(response => response.json())
    //     .then(data => {
    //         likeCount.textContent = data.likes_count;
    //     });
}

// Load comments for a photo
function loadComments(fotoId) {
    const commentsList = document.getElementById('commentsList');
    
    // Show loading state
    commentsList.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Memuat...</span>
            </div>
        </div>
    `;
    
    // In a real app, you would fetch comments from your API
    // fetch(`/api/fotos/${fotoId}/comments`)
    //     .then(response => response.json())
    //     .then(comments => {
    //         if (comments.length === 0) {
    //             commentsList.innerHTML = '<p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>';
    //             return;
    //         }
    //         
    //         let html = '';
    //         comments.forEach(comment => {
    //             html += `
    //                 <div class="comment">
    //                     <div class="comment-avatar">
    //                         <i class="fas fa-user"></i>
    //                     </div>
    //                     <div class="comment-content">
    //                         <div class="comment-author">${comment.user.name}</div>
    //                         <p class="comment-text">${comment.content}</p>
    //                         <div class="comment-time">${new Date(comment.created_at).toLocaleDateString()}</div>
    //                     </div>
    //                 </div>
    //             `;
    //         });
    //         commentsList.innerHTML = html;
    //     });
    
    // For demo purposes, simulate loading
    setTimeout(() => {
        commentsList.innerHTML = '<p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>';
    }, 500);
}

// Submit comment
function submitComment(event) {
    event.preventDefault();
    
    const form = event.target;
    const input = form.querySelector('input[type="text"]');
    const comment = input.value.trim();
    
    if (!comment) return;
    
    // In a real app, you would submit the comment to your API
    // fetch(`/api/fotos/${currentFotoId}/comments`, {
    //     method: 'POST',
    //     headers: {
    //         'Content-Type': 'application/json',
    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    //     },
    //     body: JSON.stringify({ content: comment })
    // })
    // .then(response => response.json())
    // .then(newComment => {
    //     // Add the new comment to the list
    //     const commentsList = document.getElementById('commentsList');
    //     if (commentsList.querySelector('.text-muted')) {
    //         commentsList.innerHTML = '';
    //     }
    //     
    //     const commentElement = document.createElement('div');
    //     commentElement.className = 'comment';
    //     commentElement.innerHTML = `
    //         <div class="comment-avatar">
    //             <i class="fas fa-user"></i>
    //         </div>
    //         <div class="comment-content">
    //             <div class="comment-author">${newComment.user.name}</div>
    //             <p class="comment-text">${newComment.content}</p>
    //             <div class="comment-time">Baru saja</div>
    //         </div>
    //     `;
    //     
    //     commentsList.prepend(commentElement);
    //     input.value = '';
    //     
    //     // Update comment count
    //     const commentCount = document.querySelector('.comment-count');
    //     if (commentCount) {
    //         commentCount.textContent = parseInt(commentCount.textContent) + 1;
    //     }
    // });
    
    // For demo purposes, just show a success message
    alert('Komentar berhasil dikirim!');
    input.value = '';
}

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    // Close modals when clicking outside
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', function(e) {
            if (e.target === this) {
                if (this.id === 'imageModal') closeModal();
                else if (this.id === 'downloadModal') closeDownloadModal();
            }
        });
    });
    
    // Handle form submission
    document.getElementById('commentForm').addEventListener('submit', submitComment);
    
    // Handle download form submission
    document.getElementById('downloadForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...';
        
        // In a real app, you would submit the form to your API
        // fetch('/api/download', {
        //     method: 'POST',
        //     body: formData
        // })
        // .then(response => response.blob())
        // .then(blob => {
        //     // Create a download link and trigger it
        //     const url = window.URL.createObjectURL(blob);
        //     const a = document.createElement('a');
        //     a.href = url;
        //     a.download = `foto-${formData.get('foto_id')}.jpg`;
        //     document.body.appendChild(a);
        //     a.click();
        //     window.URL.revokeObjectURL(url);
        //     document.body.removeChild(a);
        //     
        //     // Close modal and reset form
        //     closeDownloadModal();
        //     form.reset();
        // })
        // .catch(error => {
        //     console.error('Error:', error);
        //     alert('Terjadi kesalahan saat mengunduh foto. Silakan coba lagi.');
        // })
        // .finally(() => {
        //     submitBtn.disabled = false;
        //     submitBtn.innerHTML = originalBtnText;
        // });
        
        // For demo purposes, just show a success message
        setTimeout(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            closeDownloadModal();
            form.reset();
            alert('Terima kasih! Anda akan segera menerima tautan unduhan di email Anda.');
        }, 1500);
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModal();
            closeDownloadModal();
        }
    });
});
</script>
@endsection
