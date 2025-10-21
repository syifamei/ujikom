@extends('layouts.app')

@section('styles')
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
.galeri-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-top: 2rem;
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

/* Tombol Aksi */
.galeri-aksi {
    padding: 0.75rem;
    display: flex;
    justify-content: flex-start;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.9);
    border-top: 1px solid #eee;
    backdrop-filter: blur(5px);
}

.tombol-aksi {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid #e2e8f0;
    color: #2c3e50;
    cursor: pointer;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-size: 0.9rem;
    position: relative;
    overflow: hidden;
    text-decoration: none;
    min-width: 40px;
    height: 36px;
}

.tombol-aksi .icon {
    font-size: 1.1rem;
    transition: transform 0.2s ease;
}

.tombol-aksi .count {
    font-size: 0.85rem;
    font-weight: 500;
    margin-left: -2px;
}

/* Hover Effects */
.tombol-aksi:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.tombol-aksi:active {
    transform: translateY(0);
}

/* Like Button */
.tombol-aksi.like-btn {
    color: #64748b;
}

.tombol-aksi.like-btn.liked {
    color: #ef4444;
    border-color: #fecaca;
    background: #fef2f2;
}

.tombol-aksi.like-btn svg path {
    transition: fill 0.2s ease;
}

.tombol-aksi.like-btn.liked svg path {
    fill: #ef4444;
}

/* Loading state */
.tombol-aksi.loading {
    pointer-events: none;
    opacity: 0.8;
}

.tombol-aksi .spinner {
    display: none;
    width: 14px;
    height: 14px;
    border: 2px solid rgba(0, 0, 0, 0.1);
    border-radius: 50%;
    border-top-color: currentColor;
    animation: spin 0.6s linear infinite;
    margin-right: 4px;
}

.tombol-aksi.loading .spinner {
    display: inline-block;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 1000;
    opacity: 0;
    transition: opacity 0.3s ease;
    overflow-y: auto;
}

.modal.show {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 2rem 1rem;
    opacity: 1;
}

.modal-content {
    background: white;
    border-radius: 12px;
    width: 100%;
    max-width: 500px;
    transform: translateY(20px);
    transition: transform 0.3s ease;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    max-height: 80vh;
    display: flex;
    flex-direction: column;
}

.modal.show .modal-content {
    transform: translateY(0);
}

.modal-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
    color: #1e293b;
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.75rem;
    cursor: pointer;
    color: #64748b;
    line-height: 1;
    padding: 0 0.5rem;
    transition: color 0.2s ease;
}

.close-modal:hover {
    color: #1e293b;
}

.modal-body {
    padding: 1.5rem;
    overflow-y: auto;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-control {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    resize: vertical;
    min-height: 100px;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.btn-submit {
    background: #3b82f6;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s ease, transform 0.1s ease;
    width: 100%;
    font-size: 1rem;
}

.btn-submit:hover {
    background: #2563eb;
}

.btn-submit:active {
    transform: translateY(1px);
}

.comments-list {
    margin-top: 1.5rem;
    border-top: 1px solid #f1f5f9;
    padding-top: 1.5rem;
}

.comment-item {
    padding: 1rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.comment-item:last-child {
    border-bottom: none;
}

.comment-author {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.comment-text {
    color: #475569;
    line-height: 1.5;
    margin-bottom: 0.5rem;
}

.comment-time {
    font-size: 0.75rem;
    color: #94a3b8;
}

.no-comments {
    text-align: center;
    color: #94a3b8;
    padding: 2rem 0;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.comment-item {
    animation: fadeIn 0.3s ease forwards;
}

/* Responsive */
@media (max-width: 992px) {
    .galeri-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .galeri-grid {
        grid-template-columns: 1fr;
    }
    
    .galeri-container {
        padding: 1rem;
    }
    
    .judul-halaman h1 {
        font-size: 1.8rem;
    }
}
</style>
<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* Reset and override any existing styles */
body, html {
    margin: 0 !important;
    padding: 0 !important;
}

/* Force gallery page styles */
.gallery-container {
    all: unset !important;
    display: block !important;
    padding-top: 0 !important;
    background: #f8f9ff !important;
    min-height: 100vh !important;
    margin: 0 !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    width: 100% !important;
}
/* GALLERY PAGE STYLES */
* {
    font-family: 'Poppins', 'Nunito', sans-serif !important;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Filter Title Icon */
.filters-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 600;
    margin-bottom: 12px;
}

.filter-title-icon {
    display: inline-block;
    width: 20px;
    height: 20px;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%234f46e5' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M4 21v-7'%3E%3C/path%3E%3Cpath d='M4 10V3'%3E%3C/path%3E%3Cpath d='M12 21v-9'%3E%3C/path%3E%3Cpath d='M12 8V3'%3E%3C/path%3E%3Cpath d='M20 21v-5'%3E%3C/path%3E%3Cpath d='M20 12V3'%3E%3C/path%3E%3Cpath d='M1 14h6'%3E%3C/path%3E%3Cpath d='M9 8h6'%3E%3C/path%3E%3Cpath d='M17 16h6'%3E%3C/path%3E%3C/svg%3E");
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
}

/* Filter Icons */
.filter-icon {
    display: inline-block;
    width: 20px;
    height: 20px;
    margin-right: 8px;
    vertical-align: middle;
    background-size: contain;
    background-repeat: no-repeat;
/* Hero Section */
.gallery-hero {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%) !important;
    color: white !important;
    text-align: center !important;
    padding: 4rem 1rem 6rem !important;
    position: relative !important;
    overflow: hidden !important;
    margin: 0 !important;
    width: 100% !important;
    z-index: 1;
}


.gallery-hero::before {
    content: '' !important;
    position: absolute !important;
    top: -30% !important;
    right: -10% !important;
    width: 300px !important;
    height: 300px !important;
    background: rgba(255, 255, 255, 0.08) !important;
    border-radius: 50% !important;
    animation: float 8s ease-in-out infinite !important;
}

.gallery-hero::after {
    content: '' !important;
    position: absolute !important;
    bottom: -20% !important;
    left: -10% !important;
    width: 200px !important;
    height: 200px !important;
    background: rgba(255, 255, 255, 0.05) !important;
    border-radius: 50% !important;
    animation: float 6s ease-in-out infinite reverse !important;
}

@keyframes float {
    0%, 100% { transform: translateY(0px) rotate(0deg) !important; }
    50% { transform: translateY(-30px) rotate(180deg) !important; }
}

/* Camera Icon */
.gallery-icon {
    width: 80px !important;
    height: 80px !important;
    background: white;
    border-radius: 50%;
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
}

.camera-icon {
    display: inline-block;
    width: 40px;
    height: 32px;
    background: #3b82f6;
    border-radius: 15px 15px 5px 5px;
    position: relative;
}

.camera-icon::before {
    content: '';
    position: absolute;
    width: 20px;
    height: 6px;
    background: white;
    border-radius: 3px;
    top: -8px;
    left: 10px;
}

.camera-icon::after {
    content: '';
    position: absolute;
    width: 10px;
    height: 10px;
    border: 2px solid white;
    border-radius: 50%;
    top: 8px;
    left: 15px;
}

/* Hero Content */
.hero-content {
    max-width: 800px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
}

.hero-title {
    font-size: 2.5rem !important;
    font-weight: 800 !important;
    margin-bottom: 1rem !important;
    line-height: 1.2 !important;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
}

.hero-description {
    font-size: 1.1rem !important;
    max-width: 600px;
    margin: 0 auto 2rem !important;
    opacity: 0.9;
    line-height: 1.6 !important;
}

/* Filter Bar */
.filters-container {
    background: white !important;
    border-radius: 12px !important;
    padding: 1.5rem !important;
    margin: -2.5rem auto 2rem !important;
    max-width: 1200px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
    position: relative !important;
    z-index: 10 !important;
}

.filters-title {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 0.5rem !important;
    margin-bottom: 1.5rem !important;
    color: #1e40af !important;
    font-weight: 600 !important;
    font-size: 1.1rem !important;
}

.filters-title .i {
    color: #3b82f6 !important;
}

.filters {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 0.75rem !important;
    justify-content: center !important;
}

.filter-btn {
    padding: 0.6rem 1.25rem !important;
    border-radius: 50px !important;
    background: #f1f5f9 !important;
    color: #475569 !important;
    border: none !important;
    font-size: 0.9rem !important;
    font-weight: 500 !important;
    cursor: pointer !important;
    transition: all 0.2s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 0.5rem !important;
}

.filter-btn .i {
    width: 16px !important;
    height: 16px !important;
}

.filter-btn:hover {
    background: #e2e8f0 !important;
    transform: translateY(-1px) !important;
}

.filter-btn.active {
    background: #3b82f6 !important;
    color: white !important;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3) !important;
}

.filter-btn.active .i {
    color: white !important;
}

/* GALLERY GRID */
.gallery-grid {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 1.2rem !important;
    padding: 0 1.5rem 2rem !important;
    max-width: 1200px !important;
    margin: 0 auto !important;
    width: 100%;
    box-sizing: border-box;
}

.gallery-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    background: white;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.gallery-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.gallery-img-container {
    position: relative;
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: #f8f9fa;
    flex-shrink: 0;
}

.gallery-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform;
    backface-visibility: hidden;
    transform: scale(1.01);
}

.gallery-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.6);
    padding: 15px;
    color: white;
    transform: none;
    opacity: 1;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    transition: all 0.3s ease;
}

.gallery-item:hover .gallery-overlay {
    opacity: 1;
    transform: translateY(0);
    backdrop-filter: blur(2px);
}

.gallery-title {
    font-weight: 500;
    margin: 0 0 3px 0;
    color: white;
    font-size: 1rem;
    line-height: 1.3;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
}

.gallery-category {
    display: inline-block;
    font-size: 0.75rem;
    color: rgba(255,255,255,0.9);
    opacity: 0.9;
}

.gallery-actions {
    display: flex;
    gap: 10px;
    padding: 12px 15px;
    background: #f9fafb;
    border-top: 1px solid #e5e7eb;
    margin-top: auto;
    justify-content: space-between;
}

.action-btn {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 8px 15px;
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    font-size: 14px;
    color: #4b5563;
    transition: all 0.2s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.action-btn:hover {
    background: #f0f9ff;
    color: #0ea5e9;
    border-color: #bae6fd;
    transform: translateY(-2px);
}

.like-btn {
    background: #fee2e2;
    color: #dc2626;
    border-color: #fca5a5;
}

.like-btn:hover {
    background: #ffd7d7;
    color: #b91c1c;
    border-color: #f87171;
}

.comment-btn {
    background: #eff6ff;
    border-color: #93c5fd;
}

.comment-btn:hover {
    background: #d6f2ff;
    color: #3498db;
    border-color: #66d9ef;
}

.download-btn {
    background: #ecfdf5;
    border-color: #a7f3d0;
}

.download-btn:hover {
    background: #d1fae5;
    color: #059669;
    border-color: #34d399;
}

.like-btn .icon-heart {
    color: #94a3b8;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.like-btn:hover .icon-heart {
    transform: scale(1.1);
}

.like-btn.liked .icon-heart {
    color: #ef4444;
    animation: heartBeat 0.6s ease;
}

@keyframes heartBeat {
    0% { transform: scale(1); }
    14% { transform: scale(1.3); }
    28% { transform: scale(1); }
    42% { transform: scale(1.3); }
    70% { transform: scale(1); }
}

.comment-btn:hover .i {
    transform: translateY(-2px);
}

.download-btn .i {
    transition: transform 0.3s ease;
}

.download-btn:active .i {
    transform: translateY(2px);
}

/* Ripple effect */
.action-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.7s;
    pointer-events: none;
}

.action-btn:active::before {
    left: 100%;
    transition: left 0s;
}

/* Count badges */
.like-count,
.comment-count {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6b7280;
    transition: all 0.3s ease;
}

.like-btn:hover .like-count,
.comment-btn:hover .comment-count {
    color: inherit;
}

/* Loading state */
.action-btn.loading {
    pointer-events: none;
    opacity: 0.7;
}

.action-btn.loading .i {
    animation: spin 1s linear infinite;
}

/* Modal */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    padding: 2rem;
    border-radius: 15px;
    max-width: 500px;
    width: 90%;
    max-height: 80vh;
    overflow-y: auto;
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.modal-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #333;
}

.close-btn {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #999;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.close-btn:hover {
    background: #f0f0f0;
    color: #333;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #333;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.form-textarea {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 1rem;
    resize: vertical;
    min-height: 100px;
    transition: border-color 0.3s ease;
}

.form-textarea:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.btn-primary {
    background: #2563eb;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #1e4ed8;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-left: 0.5rem;
}

.btn-secondary:hover {
    background: #5a6268;
}

/* Responsive Design */
@media (max-width: 576px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.75rem !important;
        padding: 0 0.75rem 1rem !important;
    }
    
    .gallery-img-container {
        height: 160px;
    }
}

@media (max-width: 480px) {
    .gallery-grid {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
        padding: 0 1rem 1rem !important;
    }
}

@media (max-width: 992px) {
    .gallery-grid {
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 1.25rem !important;
        padding: 1.25rem !important;
    }
}

        grid-template-columns: repeat(3, 1fr) !important;
        padding: 0 1rem 1.5rem !important;
    }
}

@media (max-width: 768px) {
    .gallery-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 1rem !important;
        padding: 0 1rem 1.5rem !important;
    }
    
    .gallery-hero h1 {
        font-size: 1.8rem !important;
    }
    
    .gallery-hero p {
        font-size: 1rem !important;
    }
    
    .gallery-icon {
        width: 100px !important;
        height: 100px !important;
        font-size: 3.5rem !important;
    }
    
    .filters-container {
        flex-direction: row !important;
        align-items: center !important;
        gap: 0.8rem !important;
        overflow-x: auto !important;
        padding: 0.5rem 0 !important;
    }
    
    .filter-btn {
        min-width: 90px !important;
        justify-content: center !important;
        padding: 0.5rem 1rem !important;
        font-size: 0.85rem !important;
    }
    
    .category-filters {
        margin: -3rem auto 4rem !important;
        padding: 2.5rem 2rem !important;
    }
    
    .filters-title {
        font-size: 1.6rem !important;
    }
    
    .gallery-card {
        margin: 0 !important;
    }
    
    .gallery-content {
        padding: 2rem !important;
    }
    
    .gallery-actions {
        gap: 1.5rem !important;
        flex-wrap: wrap !important;
        justify-content: center !important;
    }
    
    .action-btn {
        padding: 0.8rem 1.2rem !important;
        font-size: 1rem !important;
    }
}

@media (max-width: 480px) {
    .gallery-hero {
        padding: 3rem 1rem 2rem !important;
    }
    
    .gallery-hero h1 {
        font-size: 2.2rem !important;
    }
    
    .gallery-hero p {
        font-size: 1.1rem !important;
    }
    
    .gallery-icon {
        width: 90px !important;
        height: 90px !important;
        font-size: 3rem !important;
    }
    
    .category-filters {
        margin: -2rem auto 3rem !important;
        padding: 2rem 1.5rem !important;
    }
    
    .filters-title {
        font-size: 1.4rem !important;
    }
    
    .filter-btn {
        padding: 1rem 1.5rem !important;
        font-size: 1rem !important;
        min-width: 140px !important;
    }
    
    .gallery-grid {
        padding: 1rem !important;
    }
    
    .gallery-card {
        margin: 0 !important;
    }
    
    .gallery-content {
        padding: 1.5rem !important;
    }
    
    .gallery-title {
        font-size: 1.3rem !important;
    }
    
    .gallery-actions {
        gap: 1rem !important;
    }
    
    .action-btn {
        padding: 0.7rem 1rem !important;
        font-size: 0.9rem !important;
    }
}
</style>
@endsection

@section('content')
<!-- Comment Modal -->
<div id="commentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="commentModalTitle">Komentar</h3>
            <button class="close-modal" aria-label="Tutup">&times;</button>
        </div>
        <div class="modal-body">
            <form id="commentForm">
                <input type="hidden" name="foto_id" id="commentFotoId">
                @guest
                <div class="form-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Nama Anda" required>
                </div>
                <div class="form-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email (opsional)">
                </div>
                @endguest
                <div class="form-group mb-3">
                    <textarea name="isi_komentar" id="commentText" class="form-control" rows="4" placeholder="Tulis komentar Anda..." required></textarea>
                </div>
                <button type="submit" class="btn-submit">Kirim Komentar</button>
            </form>
            <div id="commentsList" class="comments-list">
                <!-- Comments will be loaded here -->
                <div class="no-comments">Belum ada komentar</div>
            </div>
        </div>
    </div>
</div>

<div class="galeri-container">
    <div class="judul-halaman">
        <h1>Galeri Foto</h1>
        <p>Koleksi foto-foto terbaru dari sekolah kami</p>
    </div>
    <!-- HERO SECTION -->
    <div class="gallery-hero">
        <div class="hero-content">
            <div class="gallery-icon">
                <span class="camera-icon" aria-hidden="true"></span>
            </div>
            <h1 class="hero-title">Galeri Foto Sekolah</h1>
            <p class="hero-description">Jelajahi momen-momen berharga dan kegiatan sekolah kami dalam koleksi foto terbaik</p>
        </div>
    </div>

    <!-- FILTER BAR -->
    <div class="filters-container">
        <div class="filters-title">
            <span class="filter-title-icon"></span>
            Filter Berdasarkan Kategori
        </div>
        <div class="filters">
            <button class="filter-btn active" data-filter="all">
                <span class="filter-icon all-icon"></span>
                Semua
            </button>
            
            @foreach($kategoris as $kategori)
                @php
                    $slug = strtolower(str_replace([' ', '&'], ['', ''], $kategori->nama));
                    $iconClass = 'image-icon';
                    $lowerName = strtolower($kategori->nama);
                    
                    if (str_contains($lowerName, 'kelas') || str_contains($lowerName, 'class')) {
                        $iconClass = 'users-icon';
                    } elseif (str_contains($lowerName, 'lomba') || str_contains($lowerName, 'kompetisi')) {
                        $iconClass = 'award-icon';
                    } elseif (str_contains($lowerName, 'belajar') || str_contains($lowerName, 'pembelajaran')) {
                        $iconClass = 'book-icon';
                    } elseif (str_contains($lowerName, 'ekstra') || str_contains($lowerName, 'ekskul')) {
                        $iconClass = 'activity-icon';
                    } elseif (str_contains($lowerName, 'upacara') || str_contains($lowerName, 'bendera')) {
                        $iconClass = 'flag-icon';
                    } elseif (str_contains($lowerName, 'olahraga') || str_contains($lowerName, 'sport')) {
                        $iconClass = 'zap-icon';
                    }
                @endphp
                <button class="filter-btn" data-filter="{{ $slug }}">
                    <span class="filter-icon {{ $iconClass }}"></span>
                    {{ $kategori->nama }}
                </button>
            @endforeach
        </div>
    </div>

    <!-- GALLERY GRID -->
    <div class="galeri-grid">
        @foreach($fotos as $item)
            @php
                $imagePath = $item->gambar ?? $item->file ?? 'images/placeholder.jpg';
                $imageUrl = str_starts_with($imagePath, 'http') ? $imagePath : asset('storage/' . $imagePath);
            @endphp
            <div class="galeri-item">
                <div class="galeri-gambar">
                    <img src="{{ $imageUrl }}" alt="{{ $item->judul }}" loading="lazy">
                    <div class="galeri-overlay">
                        <h3>{{ $item->judul }}</h3>
                        @if($item->kategori)
                            <p>{{ $item->kategori->nama }}</p>
                        @endif
                    </div>
                </div>
                <div class="galeri-aksi">
                    <!-- Like Button -->
                    <button class="tombol-aksi like-btn {{ $item->is_liked ? 'liked' : '' }}" data-foto-id="{{ $item->id }}" aria-label="Sukai foto ini">
                        <span class="spinner"></span>
                        <span class="icon">❤️</span>
                        <span class="count like-count">{{ $item->likes_count ?? 0 }}</span>
                    </button>
                    
                    <!-- Comment Button -->
                    <button class="tombol-aksi comment-btn" data-foto-id="{{ $item->id }}" data-foto-judul="{{ $item->judul }}" aria-label="Tinggalkan komentar">
                        <span class="icon">💬</span>
                        <span class="count comment-count">{{ $item->comments_count ?? 0 }}</span>
                    </button>
                    
                    <!-- Download Button -->
                    <a href="{{ $imageUrl }}" class="tombol-aksi download-btn" download aria-label="Unduh gambar" data-foto-id="{{ $item->id }}">
                        <span class="icon">⬇️</span>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
// Global variables
let currentFotoId = null;

// Initialize modal
const modal = document.getElementById('commentModal');
const closeModal = modal.querySelector('.close-modal');
const commentForm = document.getElementById('commentForm');
const commentText = document.getElementById('commentText');
const commentsList = document.getElementById('commentsList');

// Show modal function
function showModal(fotoId, title) {
    currentFotoId = fotoId;
    document.getElementById('commentModalTitle').textContent = `Komentar: ${title}`;
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    commentText.focus();
    loadComments(fotoId);
}

// Close modal function
function closeModalFunc() {
    modal.classList.remove('show');
    document.body.style.overflow = '';
    commentForm.reset();
    currentFotoId = null;
}

// Load comments for a photo
async function loadComments(fotoId) {
    try {
        const response = await fetch(`/galeri/${fotoId}/comments`);
        const data = await response.json();
        
        commentsList.innerHTML = '';
        
        if (data.length === 0) {
            commentsList.innerHTML = '<div class="no-comments">Belum ada komentar</div>';
            return;
        }
        
        data.forEach(comment => {
            const commentEl = document.createElement('div');
            commentEl.className = 'comment-item';
            commentEl.innerHTML = `
                <div class="comment-author">${comment.user_name || 'Anonim'}</div>
                <div class="comment-text">${comment.isi_komentar}</div>
                <div class="comment-time">${new Date(comment.tanggal_komentar).toLocaleString()}</div>
            `;
            commentsList.appendChild(commentEl);
        });
    } catch (error) {
        console.error('Error loading comments:', error);
        commentsList.innerHTML = '<div class="no-comments">Gagal memuat komentar</div>';
    }
}

// Handle comment submission
commentForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    if (!currentFotoId) {
        showToast('error', 'Tidak dapat mengirim komentar: ID foto tidak valid');
        return;
    }
    
    const formData = new FormData();
    formData.append('isi_komentar', commentText.value.trim());
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    
    const submitBtn = commentForm.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
    
    try {
        try {
            const response = await fetch(`/galeri/comment/${currentFotoId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            
            const data = await response.json();
            
            if (!response.ok) {
                throw new Error(data.message || 'Gagal mengirim komentar');
            }
            
            // Show success message
            showToast('success', data.message || 'Komentar berhasil dikirim dan menunggu persetujuan admin');
            
            // Reset form and close modal
            commentText.value = '';
            closeModalFunc();
            
            // Reload comments
            if (typeof loadComments === 'function') {
                loadComments(currentFotoId);
            }
            
        } catch (error) {
            console.error('Error:', error);
            showToast('error', error.message || 'Terjadi kesalahan saat mengirim komentar');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    } catch (error) {
        console.error('Error submitting comment:', error);
        showToast('error', error.message || 'Terjadi kesalahan');
    }
});

// Update comment count in the UI
function updateCommentCount(fotoId, increment = false) {
    const commentBtn = document.querySelector(`.comment-btn[data-foto-id="${fotoId}"]`);
    if (!commentBtn) return;
    
    const countEl = commentBtn.querySelector('.comment-count');
    if (countEl) {
        let count = parseInt(countEl.textContent) || 0;
        count = increment ? count + 1 : count;
        countEl.textContent = count;
    }
}

// Close modal when clicking outside
modal.addEventListener('click', (e) => {
    if (e.target === modal) {
        closeModalFunc();
    }
});

// Close modal when pressing Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('show')) {
        closeModalFunc();
    }
});

// Close button event
closeModal.addEventListener('click', closeModalFunc);

// Initialize comment buttons
document.addEventListener('DOMContentLoaded', () => {
    // Comment button click handler
    document.querySelectorAll('.comment-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const fotoId = this.dataset.fotoId;
            const fotoTitle = this.dataset.fotoJudul || 'Foto';
            showModal(fotoId, fotoTitle);
        });
    });

    // Download button click handler
    document.querySelectorAll('.download-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const fotoId = this.dataset.fotoId;
            // Track download in the background
            fetch(`/galeri/download/${fotoId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).catch(console.error);
            
            // Show success message
            showToast('Mengunduh gambar...', 'success');
        });
    });
});

// Show toast notification
function showToast(message, type = 'info') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    // Trigger reflow
    toast.offsetHeight;
    
    // Add show class
    toast.classList.add('show');
    
    // Remove toast after delay
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

// Toast styles
const style = document.createElement('style');
style.textContent = `
.toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #1e293b;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transform: translateY(100px);
    opacity: 0;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 9999;
    max-width: 300px;
}

.toast.show {
    transform: translateY(0);
    opacity: 1;
}

.toast-success {
    background: #10b981;
}

.toast-error {
    background: #ef4444;
}
`;
document.head.appendChild(style);

// Function to check if element is in viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top >= 0 &&
        rect.left >= 0 &&
        rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
    );
}

// Fungsi untuk memuat gambar yang terlihat di viewport
function lazyLoadImages() {
    const images = document.querySelectorAll('.gallery-img');
    images.forEach(img => {
        if (isInViewport(img) && !img.getAttribute('data-loaded')) {
            const src = img.getAttribute('data-src') || img.src;
            img.setAttribute('src', src);
            img.setAttribute('data-loaded', 'true');
        }
    });
}

// Filter functionality
const filterButtons = document.querySelectorAll('.filter-btn');
const galleryItems = document.querySelectorAll('.gallery-card');

// Fungsi untuk menerapkan filter
function applyFilter(filterValue) {
    // Update active button
    filterButtons.forEach(btn => {
        const btnFilter = btn.getAttribute('data-filter');
        if (btnFilter === filterValue) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });
    
    // Filter items
    galleryItems.forEach(item => {
        const itemCategory = item.getAttribute('data-category');
        const itemKategoriId = item.getAttribute('data-kategori-id');
        
        // Tampilkan semua jika filter 'all' atau cocok dengan kategori/ID
        const showItem = filterValue === 'all' || 
                        itemCategory === filterValue || 
                        itemKategoriId === filterValue;
        
        item.style.display = showItem ? 'block' : 'none';
    });
    
    // Update URL tanpa reload halaman
    const url = new URL(window.location);
    if (filterValue === 'all') {
        url.searchParams.delete('kategori');
    } else {
        url.searchParams.set('kategori', filterValue);
    }
    window.history.pushState({}, '', url);
    
    // Trigger lazy load untuk gambar yang baru ditampilkan
    setTimeout(lazyLoadImages, 100);
}

// Event listeners untuk filter buttons
filterButtons.forEach(button => {
    button.addEventListener('click', (e) => {
        e.preventDefault();
        const filterValue = button.getAttribute('data-filter');
        applyFilter(filterValue);
    });
});

// Inisialisasi filter dari URL saat halaman dimuat
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const kategoriParam = urlParams.get('kategori');
    
    if (kategoriParam) {
        // Cari tombol dengan data-filter yang sesuai
        let found = false;
        filterButtons.forEach(btn => {
            if (btn.getAttribute('data-filter') === kategoriParam) {
                btn.click();
                found = true;
            }
        });
        
        // Jika tidak ditemukan, reset ke 'all'
        if (!found) {
            document.querySelector('.filter-btn[data-filter="all"]').click();
        }
    } else {
        // Default ke 'all' jika tidak ada parameter
        document.querySelector('.filter-btn[data-filter="all"]').click();
    }
    
    // Inisialisasi lazy load
    lazyLoadImages();
    window.addEventListener('scroll', lazyLoadImages);
    window.addEventListener('resize', lazyLoadImages);
});

// Handle tombol back/forward browser
window.addEventListener('popstate', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const kategoriParam = urlParams.get('kategori') || 'all';
    applyFilter(kategoriParam);
});

// Like functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize like buttons
    document.querySelectorAll('.like-btn').forEach(button => {
        // Set initial liked state
        const likeCount = button.querySelector('.like-count');
        const currentLikes = parseInt(likeCount.textContent) || 0;
        
        // Add click handler
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            
            if (this.classList.contains('loading')) return;
            
            const fotoId = this.dataset.fotoId;
            const likeCount = this.querySelector('.like-count');
            const heartPath = this.querySelector('svg path');
            const isLiked = !this.classList.contains('liked');
            
            // Update UI immediately for better UX
            this.classList.add('loading');
            const currentLikes = parseInt(likeCount.textContent) || 0;
            likeCount.textContent = isLiked ? currentLikes + 1 : Math.max(0, currentLikes - 1);
            
            if (isLiked) {
                this.classList.add('liked');
            } else {
                this.classList.remove('liked');
            }
            
            try {
                const response = await fetch(`/galeri/${fotoId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        _method: 'POST',
                        is_liked: isLiked ? 1 : 0
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Update like count from server
                    if (data.likes_count !== undefined) {
                        likeCount.textContent = data.likes_count;
                    }
                    
                    // Update like state based on server response
                    if (data.is_liked) {
                        this.classList.add('liked');
                    } else {
                        this.classList.remove('liked');
                    }
                    
                    // Show toast notification
                    showToast(isLiked ? 'Anda menyukai foto ini' : 'Suka dibatalkan', 'success');
                } else {
                    // Revert UI if the request was not successful
                    if (isLiked) {
                        this.classList.remove('liked');
                        likeCount.textContent = currentLikes;
                    } else {
                        this.classList.add('liked');
                        likeCount.textContent = currentLikes;
                    }
                    
                    if (data.requires_login) {
                        showToast('Silakan login untuk menyukai foto', 'error');
                        // Redirect to login page if not logged in
                        setTimeout(() => {
                            window.location.href = '{{ route("login") }}';
                        }, 1500);
                    } else {
                        showToast(data.message || 'Gagal memperbarui suka', 'error');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                // Revert UI on error
                if (isLiked) {
                    this.classList.remove('liked');
                    likeCount.textContent = currentLikes;
                } else {
                    this.classList.add('liked');
                    likeCount.textContent = currentLikes;
                }
                
                showToast('Terjadi kesalahan saat memproses permintaan', 'error');
            } finally {
                // Always remove loading state
                this.classList.remove('loading');
            }
        });
    });
});

// Comment functionality
document.querySelectorAll('.comment-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const fotoId = this.dataset.fotoId;
        const fotoTitle = this.dataset.fotoTitle;
        const modal = document.getElementById('commentModal');
        
        // Reset form and show modal
        const form = document.getElementById('commentForm');
        form.reset();
        form.classList.remove('was-validated');
        document.getElementById('commentAlert').style.display = 'none';
        
        // Set the foto_id in the form
        document.getElementById('commentFotoId').value = fotoId;
        
        // Set modal title with photo title
        document.getElementById('commentModalTitle').textContent = fotoTitle ? `Komentar untuk: ${fotoTitle}` : 'Tambah Komentar';
        
        // Show modal
        modal.style.display = 'flex';
        
        // Focus on name field
        setTimeout(() => {
            document.getElementById('commentName').focus();
        }, 100);
    });
});

// Handle comment form submission
document.getElementById('commentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    const spinner = submitBtn.querySelector('.spinner-border');
    const btnText = submitBtn.querySelector('.btn-text');
    const formData = new FormData(form);
    
    // Validate form
    if (!form.checkValidity()) {
        e.stopPropagation();
        form.classList.add('was-validated');
        return;
    }
    
    // Show loading state
    submitBtn.disabled = true;
    spinner.classList.remove('d-none');
    btnText.textContent = 'Mengirim...';
    
    // Get the foto ID from the form data
    const fotoId = formData.get('foto_id');
    if (!fotoId) {
        showToast('Tidak dapat mengirim komentar: ID foto tidak valid', 'error');
        return;
    }
    
    // Send AJAX request with the correct route
    fetch(`/galeri/comment/${fotoId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => { throw err; });
        }
        return response.json();
    })
    .then(data => {
        // Show success message
        document.getElementById('commentAlert').style.display = 'block';
        form.reset();
        form.classList.remove('was-validated');
        
        // Update comment count if available
        const commentCount = document.querySelector(`.comment-btn[data-foto-id="${formData.get('foto_id')}"] .comment-count`);
        if (commentCount) {
            const currentCount = parseInt(commentCount.textContent) || 0;
            commentCount.textContent = currentCount + 1;
        }
        
        // Auto-close after 2 seconds
        setTimeout(() => {
            closeCommentModal();
        }, 2000);
    })
    .catch(error => {
        console.error('Error:', error);
        let errorMessage = 'Terjadi kesalahan saat mengirim komentar. Silakan coba lagi.';
        
        if (error.errors) {
            // Handle validation errors
            errorMessage = Object.values(error.errors).flat().join('\n');
        } else if (error.message) {
            errorMessage = error.message;
        }
        
        showToast(errorMessage, 'error');
        
        // Re-enable the submit button on error
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
        btnText.textContent = 'Kirim Komentar';
        
        // Re-enable the submit button on error
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
        btnText.textContent = 'Kirim Komentar';
        
        // Re-enable the submit button on error
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
        btnText.textContent = 'Kirim Komentar';
        
        // Re-enable the submit button on error
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
        btnText.textContent = 'Kirim Komentar';
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        spinner.classList.add('d-none');
        btnText.textContent = 'Kirim Komentar';
    });
});

// Close comment modal
function closeCommentModal() {
    const modal = document.getElementById('commentModal');
    const form = document.getElementById('commentForm');
    
    // Add fade out animation
    modal.style.opacity = '0';
    modal.style.transition = 'opacity 0.2s ease';
    
    // Hide after animation
    setTimeout(() => {
        modal.style.display = 'none';
        modal.style.opacity = '1';
        form.reset();
        form.classList.remove('was-validated');
        document.getElementById('commentAlert').style.display = 'none';
    }, 200);
}

// Handle comment form submission - single event listener with proper error handling
if (!window.commentFormInitialized) {
    window.commentFormInitialized = true;
    
    document.getElementById('commentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        
        // Get the foto ID from the form data
        const fotoId = formData.get('foto_id');
        if (!fotoId) {
            showToast('error', 'Tidak dapat mengirim komentar: ID foto tidak valid');
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim...';
        
        // Send AJAX request with the correct route using Laravel's route helper
        fetch(`/galeri/comment/${fotoId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Terjadi kesalahan saat mengirim komentar');
                });
            }
            return response.json();
        })
        .then(data => {
            // Show success message
            showToast('success', data.message || 'Komentar berhasil dikirim dan menunggu persetujuan admin');
            
            // Reset form and close modal
            form.reset();
            closeCommentModal();
            
            // Update comment count
            const commentCount = document.querySelector(`.comment-btn[data-foto-id="${fotoId}"] .comment-count`);
            if (commentCount) {
                const currentCount = parseInt(commentCount.textContent) || 0;
                commentCount.textContent = currentCount + 1;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('error', error.message || 'Terjadi kesalahan. Silakan coba lagi.');
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });
}
});

// Download functionality
document.querySelectorAll('.download-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const fotoId = this.dataset.fotoId;
        const fotoTitle = this.dataset.fotoTitle;
        
        document.getElementById('downloadFotoId').value = fotoId;
        document.getElementById('downloadModal').style.display = 'flex';
    });
});

function closeDownloadModal() {
    document.getElementById('downloadModal').style.display = 'none';
    document.getElementById('downloadForm').reset();
}

document.getElementById('downloadForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/galeri/download/auth', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (response.ok) {
            // Redirect to download
            window.location.href = `/galeri/download/${document.getElementById('downloadFotoId').value}`;
        } else {
            return response.json().then(data => {
                throw new Error(data.message || 'Terjadi kesalahan');
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Terjadi kesalahan. Silakan coba lagi.');
    });
});

// Close modals when clicking outside
document.getElementById('commentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeCommentModal();
    }
});

document.getElementById('downloadModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDownloadModal();
    }
});

// Emoji like toggle and handlers
document.addEventListener('DOMContentLoaded', function() {
    // Handle like button clicks
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const fotoId = this.dataset.fotoId;
            const likeCount = this.querySelector('.like-count');
            const icon = this.querySelector('.icon-heart');
            
            // Anyone can comment, but comments require admin approval

            // Add loading state
            this.classList.add('loading');
            
            // Simulate API call (replace with actual fetch/AJAX)
            setTimeout(() => {
                const isLiked = this.classList.contains('liked');
                const currentLikes = parseInt(likeCount.textContent) || 0;
                
                if (isLiked) {
                    // Unlike
                    this.classList.remove('liked');
                    likeCount.textContent = currentLikes - 1;
                } else {
                    // Like
                    this.classList.add('liked');
                    likeCount.textContent = currentLikes + 1;
                    
                    // Add heart animation
                    icon.style.animation = 'none';
                    void icon.offsetWidth; // Trigger reflow
                    icon.style.animation = 'heartBeat 0.6s ease';
                }
                
                this.classList.remove('loading');
                
                // Here you would typically make an AJAX call to your backend
                // fetch(`/api/fotos/${fotoId}/like`, {
                //     method: 'POST',
                //     headers: {
                //         'X-CSRF-TOKEN': '{{ csrf_token() }}',
                //         'Content-Type': 'application/json',
                //     },
                //     body: JSON.stringify({
                //         _method: isLiked ? 'DELETE' : 'POST'
                //     })
                // })
                // .then(response => response.json())
                // .then(data => {
                //     likeCount.textContent = data.likes_count;
                //     this.classList.toggle('liked', !isLiked);
                //     this.classList.remove('loading');
                // })
                // .catch(error => {
                //     console.error('Error:', error);
                //     this.classList.remove('loading');
                // });
            }, 500);
        });
    });

    // Handle comment button clicks
    document.querySelectorAll('.comment-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const fotoId = this.dataset.fotoId;
            const fotoTitle = this.dataset.fotoTitle;
            
            // Anyone can comment, but comments require admin approval
            
            // Set photo ID in the form
            document.getElementById('commentFotoId').value = fotoId;
            
            // Set modal title
            document.querySelector('#commentModal .modal-title').textContent = `Komentar: ${fotoTitle}`;
            
            // Show modal
            document.getElementById('commentModal').style.display = 'flex';
            
            // Focus on comment textarea
            setTimeout(() => {
                document.getElementById('commentContent').focus();
            }, 100);
        });
    });

    // Handle download button clicks
    document.querySelectorAll('.download-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            // For downloads, user must be logged in and fill out a form
            @guest
                e.preventDefault();
                // Redirect to login with redirect back to gallery after login
                window.location.href = '{{ route('login') }}?redirect={{ urlencode(route('galeri')) }}';
                return false;
            @endguest
            
            e.preventDefault();
            showDownloadForm(this.href, this.dataset.fotoId, this.dataset.fotoTitle);
        });
    });
    
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
        
        // Get the original download URL from the button's data attribute
        const downloadUrl = document.querySelector('.download-btn[data-foto-id="' + formData.get('foto_id') + '"]').href;
        
        const fotoId = formData.get('foto_id');
        if (!fotoId) {
            showToast('Tidak dapat mengirim komentar: ID foto tidak valid', 'error');
            return;
        }
        
        // Submit the form data with the correct route
        fetch(`/galeri/comment/${fotoId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            // If form submission is successful, trigger the download
            window.location.href = downloadUrl + '?download=1';
            
            // Show success message
            showToast('Unduhan akan segera dimulai', 'success');
            
            // Close the modal after a short delay
            setTimeout(() => {
                closeDownloadModal();
            }, 1000);
        })
        .catch(error => {
            console.error('Error:', error);
            let errorMessage = 'Terjadi kesalahan saat memproses unduhan.';
            
            if (error.errors) {
                // Handle validation errors
                errorMessage = Object.values(error.errors).flat().join('\n');
            } else if (error.message) {
                errorMessage = error.message;
            }
            
            showToast(errorMessage, 'error');
        })
        .finally(() => {
            // Reset button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
        });
    });
            
            const fotoId = this.dataset.fotoId;
            const fotoTitle = this.dataset.fotoTitle;
            
            // Here you would typically track the download
            console.log('Downloading photo:', fotoId, fotoTitle);
            
            // Example of tracking download:
            // fetch(`/api/fotos/${fotoId}/download`, {
            //     method: 'POST',
            //     headers: {
            //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //     }
            // });
        });
    });

    // Add ripple effect to all action buttons
    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            const rect = this.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            ripple.style.left = `${x}px`;
            ripple.style.top = `${y}px`;
            
            this.appendChild(ripple);
            
            // Remove ripple after animation completes
            setTimeout(() => {
                ripple.remove();
            }, 1000);
        });
    });
});

// Already have listeners below for like/comment/download
document.addEventListener('DOMContentLoaded', function() {
    // Already have listeners below for like/comment/download
});

// Ripple effect
.ripple {
    position: absolute;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 50%;
    transform: scale(0);
    animation: ripple 0.6s linear;
    pointer-events: none;
}

@keyframes ripple {
    to {
        transform: scale(4);
        opacity: 0;
    }
}
@endsection