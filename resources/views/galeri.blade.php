@extends('layouts.app')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/css/lightbox.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
    padding-top: 120px; /* Tambahan padding atas untuk header */
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
    padding: 0 1.5rem 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

/* Item Galeri */
.galeri-item {
    background: white;
    border-radius: 4px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.galeri-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Gambar */
.galeri-gambar {
    width: 100%;
    height: 200px;
    overflow: hidden;
    position: relative;
}

.galeri-gambar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.galeri-item:hover .galeri-gambar img {
    transform: scale(1.05);
}

/* Overlay Gambar */
.galeri-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    padding: 1rem;
    color: white;
}

.galeri-overlay h3 {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

.galeri-overlay p {
    font-size: 0.8rem;
    opacity: 0.9;
}

/* Card Styles */
.gallery-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    height: 400px;
    display: flex;
    flex-direction: column;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
}

.gallery-image-container {
    width: 100%;
    height: 250px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    flex-shrink: 0;
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

/* Gallery Info */
.gallery-info {
    padding: 1rem;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.gallery-info .gallery-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin: 0 0 0.5rem 0;
    color: #2d3748;
}

.gallery-category {
    font-size: 0.9rem;
    color: #718096;
    margin: 0 0 0.5rem 0;
}

.gallery-info-date {
    font-size: 0.8rem;
    color: #a0aec0;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

/* Action Buttons */
.gallery-actions {
    display: flex;
    justify-content: space-around;
    padding: 1rem;
    background: #f8f9fa;
    border-top: 1px solid #eee;
    flex-shrink: 0;
}

.action-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: none;
    border: none;
    color: #6c757d;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.2s ease;
    min-width: 60px;
    white-space: nowrap;
}

.action-btn:hover {
    background: #f1f3f5;
    color: #495057;
}

.action-btn i {
    font-size: 1.2rem;
    margin-bottom: 0.25rem;
    display: block;
}

.action-btn span {
    font-size: 0.7rem;
    font-weight: 500;
    text-align: center;
}

.action-btn.liked {
    color: #ff4757;
}

/* Interactive Icons Below Card */
.gallery-interactive-icons {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 10px 0;
    border-top: 1px solid #eee;
    background: #f9fafb;
    margin-top: 10px;
}

.icon-btn {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    background: none;
    border: none;
    cursor: pointer;
    padding: 8px 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
    color: #6b7280;
    font-size: 18px;
}

.icon-btn:hover {
    color: #2563eb;
    background: rgba(37, 99, 235, 0.1);
    transform: translateY(-2px);
}

.icon-btn.liked {
    color: #ef4444;
}

.icon-btn.liked:hover {
    color: #dc2626;
    background: rgba(239, 68, 68, 0.1);
}

.icon-text {
    font-size: 12px;
    font-weight: 500;
    color: #6b7280;
    text-align: center;
    line-height: 1.2;
}

.icon-btn:hover .icon-text {
    color: #2563eb;
}

.icon-btn.liked .icon-text {
    color: #ef4444;
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
    transform: translateY(20px);
    transition: transform 0.3s ease;
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
    background: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    flex-shrink: 0;
    color: #6c757d;
    font-weight: bold;
}

.comment-content {
    flex: 1;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.25rem;
}

.comment-author {
    font-weight: 600;
    color: #2c3e50;
    font-size: 0.9rem;
}

.comment-date {
    font-size: 0.75rem;
    color: #adb5bd;
}

.comment-text {
    font-size: 0.9rem;
    color: #495057;
    line-height: 1.5;
}

.comment-form {
    display: flex;
    margin-top: 1rem;
}

.comment-input {
    flex: 1;
    padding: 0.75rem 1rem;
    border: 1px solid #dee2e6;
    border-radius: 8px 0 0 8px;
    font-size: 0.9rem;
    transition: border-color 0.2s ease;
}

.comment-input:focus {
    outline: none;
    border-color: #4dabf7;
}

.comment-submit {
    background: #4dabf7;
    color: white;
    border: none;
    border-radius: 0 8px 8px 0;
    padding: 0 1.25rem;
    cursor: pointer;
    transition: background 0.2s ease;
}

.comment-submit:hover {
    background: #339af0;
}

/* Responsive */
@media (max-width: 992px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    .gallery-card {
        height: 380px;
    }
    
    .gallery-image-container {
        height: 220px;
    }
    
    .action-btn {
        padding: 6px 10px;
        min-width: 50px;
    }
    
    .action-btn i {
        font-size: 1.1rem;
    }
    
    .action-btn span {
        font-size: 0.65rem;
    }
    
    .gallery-interactive-icons {
        padding: 8px 0;
    }
    
    .icon-btn {
        padding: 6px 8px;
        font-size: 16px;
    }
    
    .icon-text {
        font-size: 11px;
    }
}
    
    .modal-content {
        flex-direction: column;
        max-height: 90vh;
    }
    
    .modal-image-container {
        padding: 1rem;
        max-height: 50vh;
    }
    
    .modal-sidebar {
        max-height: 40vh;
    }
}

@media (max-width: 576px) {
    .gallery-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .gallery-card {
        height: 360px;
    }
    
    .gallery-image-container {
        height: 200px;
    }
    
    .action-btn {
        padding: 5px 8px;
        min-width: 45px;
    }
    
    .action-btn i {
        font-size: 1rem;
    }
    
    .action-btn span {
        font-size: 0.6rem;
    }
    
    .gallery-interactive-icons {
        padding: 6px 0;
    }
    
    .icon-btn {
        padding: 4px 6px;
        font-size: 14px;
    }
    
    .icon-text {
        font-size: 10px;
    }
}
</style>
@endsection

@section('content')
<div class="container py-5" style="margin-top: 100px;">
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
                <div class="gallery-image-container">
                    <img src="{{ Storage::url($foto->path) }}" alt="{{ $foto->judul }}" class="gallery-image">
                    <div class="gallery-overlay">
                        <h3 class="gallery-title">{{ $foto->judul }}</h3>
                        <p class="gallery-date">{{ \Carbon\Carbon::parse($foto->created_at)->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
                <div class="gallery-info">
                    <h3 class="gallery-title">{{ $foto->judul }}</h3>
                    <p class="gallery-category">{{ $foto->kategori->nama ?? 'Umum' }}</p>
                    <p class="gallery-info-date">
                        <i class="fas fa-calendar"></i>
                        {{ \Carbon\Carbon::parse($foto->created_at)->translatedFormat('d M Y') }}
                    </p>
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

    <!-- Modal for Image View -->
    <div id="imageModal" class="modal-overlay">
        <button class="modal-close" onclick="closeModal()">&times;</button>
    <div class="modal-content">
            <div class="modal-image-container">
                <img id="modalImage" src="" alt="" class="modal-image">
            </div>
            <div class="modal-details">
                <h2 id="modalTitle"></h2>
                <p id="modalDate" class="text-muted"></p>
                
                <!-- Like and Comment Buttons -->
                <div class="d-flex gap-3 mb-3">
                    <button class="btn btn-outline-primary like-btn" onclick="toggleLike(currentFotoId, this)">
                        <i class="far fa-heart"></i> <span class="like-count">0</span>
                    </button>
                    <button class="btn btn-outline-primary comment-btn" data-foto-id="currentFotoId">
                        <i class="far fa-comment"></i> <span class="comment-count">0</span>
                    </button>
                    <button class="btn btn-outline-success download-btn" onclick="openDownloadModal(currentFotoId)">
                        <i class="fas fa-download"></i> Unduh
                    </button>
                </div>
                
                <!-- Comments Section -->
                <div class="comments-section">
                    <h5>Komentar</h5>
                    <div class="comments-list">
                        <div id="approvedComments">
                            <p class="text-muted">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    </div>
                    <form id="commentForm" class="mt-3">
                        <div class="mb-3">
                            <input type="text" id="nama" class="form-control" placeholder="Nama Anda..." required>
                        </div>
                        <div class="mb-3">
                            <textarea id="komentar" class="form-control" rows="3" placeholder="Tulis komentar Anda..." required></textarea>
                        </div>
                        <button class="btn btn-primary" type="submit">Kirim Komentar</button>
                    </form>
                </div>
            </div>
        </div>
            </div>
            
    <!-- Download Modal -->
    <div id="downloadModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3>Unduh Foto</h3>
            <p>Silakan isi data diri Anda untuk mengunduh foto.</p>
            <form id="downloadForm">
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email Aktif</label>
                    <input type="email" id="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password Email Kamu</label>
                    <input type="password" id="password" name="password" class="form-control" required minlength="6">
                    <small class="form-text text-muted">Minimal 6 karakter</small>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block mt-4">
                    <i class="fas fa-download me-2"></i> Unduh Foto
                </button>
                
                <div class="text-center mt-3">
                    <p class="small text-muted">Dengan mendaftar, Anda menyetujui ketentuan layanan kami.</p>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.3/dist/js/lightbox.min.js"></script>
<script>
let currentFotoId = null;

// Open modal with image
function openModal(fotoId) {
    currentFotoId = fotoId;
    const foto = document.querySelector(`[data-foto-id="${fotoId}"]`).closest('.gallery-card');
    const imgSrc = foto.querySelector('img').src;
    const title = foto.querySelector('.gallery-title').textContent;
    const date = foto.querySelector('.gallery-date').textContent;
    
    // Get like and comment counts from the card
    const likeCount = foto.querySelector('.like-count') ? foto.querySelector('.like-count').textContent : '0';
    const commentCount = foto.querySelector('.comment-count') ? foto.querySelector('.comment-count').textContent : '0';
    
    document.getElementById('modalImage').src = imgSrc;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDate').textContent = date;
    document.getElementById('imageModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    
    // Update like and comment counts in modal
    const modalLikeCount = document.querySelector('.modal .like-count');
    const modalCommentCount = document.querySelector('.modal .comment-count');
    if (modalLikeCount) modalLikeCount.textContent = likeCount;
    if (modalCommentCount) modalCommentCount.textContent = commentCount;
    
    // Load approved comments
    loadApprovedComments(fotoId);
}

// Close modal
function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Open comment modal (comment section is in image modal)
function openCommentModal(fotoId) {
    currentFotoId = fotoId;
    // Open the main image modal which contains comment section
    openModal(fotoId);
}

// Open download modal
function openDownloadModal(fotoId) {
    currentFotoId = fotoId;
    document.getElementById('downloadModal').style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

// Close modal when clicking outside the image
window.onclick = function(event) {
    const modal = document.getElementById('imageModal');
    if (event.target === modal) {
        closeModal();
    }
}

// Handle like button click with AJAX
function toggleLike(fotoId, button) {
    fetch(`/api/foto/${fotoId}/like`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            foto_id: fotoId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update like count in modal
            const likeCount = button.querySelector('.like-count');
            if (likeCount) {
                likeCount.textContent = data.total_likes;
            }
            
            // Update like count in gallery card
            const cardLikeCount = document.querySelector(`[data-foto-id="${fotoId}"] .like-count`);
            if (cardLikeCount) {
                cardLikeCount.textContent = data.total_likes;
            }
            
            // Update like button visual state
            if (data.action === 'liked') {
                button.classList.add('liked');
                const icon = button.querySelector('i');
                if (icon) {
                    icon.className = 'fa-solid fa-heart';
                }
                
                // Update card like button state
                const cardLikeBtn = document.querySelector(`[data-foto-id="${fotoId}"] .icon-btn.like-btn`);
                if (cardLikeBtn) {
                    cardLikeBtn.classList.add('liked');
                    const cardIcon = cardLikeBtn.querySelector('i');
                    if (cardIcon) {
                        cardIcon.className = 'fa-solid fa-heart';
                    }
                }
            } else {
                button.classList.remove('liked');
                const icon = button.querySelector('i');
                if (icon) {
                    icon.className = 'fa-regular fa-heart';
                }
                
                // Update card like button state
                const cardLikeBtn = document.querySelector(`[data-foto-id="${fotoId}"] .icon-btn.like-btn`);
                if (cardLikeBtn) {
                    cardLikeBtn.classList.remove('liked');
                    const cardIcon = cardLikeBtn.querySelector('i');
                    if (cardIcon) {
                        cardIcon.className = 'fa-regular fa-heart';
                    }
                }
            }
            
            // Show notification
            showNotification(data.message, 'success');
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat memproses like', 'error');
    });
}

// Handle comment form submission with AJAX
document.getElementById('commentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const nama = document.getElementById('nama').value;
    const komentar = document.getElementById('komentar').value;
    
    if (!nama.trim() || !komentar.trim()) {
        showNotification('Harap isi nama dan komentar', 'error');
        return;
    }
    
    handleComment(currentFotoId, nama, komentar);
});

// Handle download button click with AJAX
document.getElementById('downloadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const nama = document.getElementById('nama').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    if (!nama.trim() || !email.trim() || !password.trim()) {
        showNotification('Harap isi semua data dengan benar sebelum mengunduh foto', 'error');
        return;
    }
    
    handleDownload(currentFotoId, nama, email, password);
});

// Close modals when clicking the X button
document.querySelectorAll('.close').forEach(button => {
    button.addEventListener('click', function() {
        this.closest('.modal').style.display = 'none';
        document.body.style.overflow = 'auto';
    });
});

// Close modals when pressing Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('.modal-overlay, .download-modal').forEach(modal => {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
        });
    }
});

// AJAX Helper Functions
function handleComment(fotoId, nama, komentar) {
    fetch(`/api/foto/${fotoId}/comment`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            foto_id: fotoId,
            nama: nama,
            komentar: komentar
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Clear the form
            document.getElementById('commentForm').reset();
            
            // Show notification
            showNotification(data.message, 'success');
            
            // Reload approved comments
            loadApprovedComments(fotoId);
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat mengirim komentar', 'error');
    });
}

function handleDownload(fotoId, nama, email, password) {
    fetch(`/api/foto/${fotoId}/download`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            foto_id: fotoId,
            nama: nama,
            email: email,
            password: password
        })
    })
    .then(response => {
        if (response.ok) {
            // Close the modal
            document.getElementById('downloadModal').style.display = 'none';
            document.body.style.overflow = 'auto';
            
            // Show success notification
            showNotification('Foto berhasil diunduh! Terima kasih telah menggunakan galeri kami', 'success');
            
            // Trigger download
            return response.blob();
        } else {
            return response.json().then(data => {
                throw new Error(data.message || 'Download gagal');
            });
        }
    })
    .then(blob => {
        // Create download link
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `foto-${fotoId}.jpg`;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification(error.message || 'Terjadi kesalahan saat mengunduh foto', 'error');
    });
}

function loadApprovedComments(fotoId) {
    fetch(`/api/foto/${fotoId}/comments/approved`)
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const commentsContainer = document.getElementById('approvedComments');
            if (commentsContainer) {
                if (data.comments.length > 0) {
                    commentsContainer.innerHTML = data.comments.map(comment => 
                        `<div class="comment-item">
                            <strong>${comment.nama}:</strong> ${comment.komentar}
                            <small class="text-muted d-block">${comment.created_at}</small>
                        </div>`
                    ).join('');
                } else {
                    commentsContainer.innerHTML = '<p class="text-muted">Belum ada komentar yang disetujui.</p>';
                }
            }
        }
    })
    .catch(error => {
        console.error('Error loading comments:', error);
    });
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    // Add to body
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>
@endpush