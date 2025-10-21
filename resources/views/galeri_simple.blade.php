@extends('layouts.app')

@section('title', 'Galeri - SMKN 4 BOGOR')

@section('styles')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');
    :root { --primary: #2563eb; }
    .gallery-section { padding: 3rem 0; font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
    .gallery-header { text-align: center; margin-bottom: 2rem; }
    .gallery-header h1 { font-weight: 700; letter-spacing: .2px; }
    .gallery-header p { color: #6b7280; }
    .filter-section { margin-bottom: 1.25rem; }
    .filter-row { display: grid; grid-template-columns: 1fr auto; gap: 1rem; align-items: start; }
    @media (max-width: 768px) { .filter-row { grid-template-columns: 1fr; } }
    .filter-buttons { display: flex; flex-wrap: wrap; gap: .6rem; }
    .filter-btn { padding: .5rem 1rem; border: 1px solid #e5e7eb; background: #fff; border-radius: 999px; box-shadow: 0 1px 2px rgba(0,0,0,.04); color: #374151; display: inline-flex; align-items: center; gap: .5rem; transition: all .2s ease; }
    .filter-btn i { font-size: .9rem; color: #6b7280; transition: color .2s ease; }
    .filter-btn:hover { background: #f8fafc; transform: translateY(-1px); }
    .filter-btn.active { background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 6px 16px rgba(37, 99, 235, .25); }
    .filter-btn.active i { color: #fff; }
    .search-box { position: relative; }
    .search-box i { position: absolute; left: .75rem; top: 50%; transform: translateY(-50%); color: #9ca3af; }
    .search-box input { padding-left: 2.25rem; border-radius: 999px; }
    .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .gallery-item { border: 1px solid #e5e7eb; border-radius: 1rem; overflow: hidden; background: #fff; box-shadow: 0 6px 20px rgba(2, 8, 23, .04); transition: transform .2s ease, box-shadow .2s ease; }
    .gallery-item:hover { transform: translateY(-4px) scale(1.01); box-shadow: 0 12px 28px rgba(2, 8, 23, .10); }
    .gallery-thumb { width: 100%; aspect-ratio: 16 / 9; object-fit: cover; display: block; background: #f3f4f6; }
    .gallery-info { padding: 1rem 1rem 1.1rem; }
    .gallery-title { font-weight: 600; margin-bottom: .3rem; color: #111827; }
    .gallery-category { color: #64748b; font-size: .9rem; display: inline-flex; align-items: center; gap: .4rem; }
    .gallery-category i { color: var(--primary); }
    /* Action bar */
    .action-bar { display: flex; justify-content: space-between; align-items: center; gap: .75rem; border-top: 1px solid #e5e7eb; padding-top: .75rem; margin-top: .75rem; }
    .action-btn { display: inline-flex; align-items: center; gap: .35rem; background: none; border: none; color: #6b7280; font-size: .95rem; cursor: pointer; transition: color .2s ease, transform .2s ease; text-decoration: none; }
    .action-btn i { font-size: 1rem; }
    .action-btn:hover { color: var(--primary); text-decoration: none; transform: translateY(-1px); }
    @media (max-width: 992px) { .gallery-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .gallery-grid { grid-template-columns: 1fr; } }
    .empty-state { text-align: center; padding: 2rem 1rem; color: #6b7280; }
</style>
@endsection

@section('content')
<section class="gallery-section">
    <div class="container">
        <div class="gallery-header">
            <h1>Galeri Foto Sekolah</h1>
            <p>Jelajahi berbagai momen berharga dan kegiatan sekolah kami</p>
        </div>

        <div class="filter-section">
            @if(session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
            @endif
            @if($errors->any())
            <div class="alert alert-danger mb-3">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="filter-row">
                <div class="filter-buttons">
                    <button class="filter-btn active" data-category="all"><i class="fas fa-layer-group"></i>Semua</button>
                    @foreach($kategoris as $kategori)
                    <button class="filter-btn" data-category="{{ strtolower(str_replace([' ', '&'], ['', ''], $kategori->nama)) }}">
                        <i class="fas fa-tag"></i>{{ $kategori->nama }}
                    </button>
                    @endforeach
                </div>
                <div>
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" placeholder="Cari foto..." id="searchInput">
                    </div>
                </div>
            </div>
        </div>

        <div class="gallery-grid" id="galleryGrid">
            @forelse($fotos as $foto)
            <div class="gallery-item" data-category="{{ strtolower(str_replace([' ', '&'], ['', ''], $foto->kategori->nama ?? '')) }}" data-title="{{ strtolower($foto->judul) }}">
                <img class="gallery-thumb" src="{{ asset('storage/'.$foto->path) }}" alt="{{ $foto->judul }}" loading="lazy">
                <div class="gallery-info">
                    <div class="gallery-title">{{ $foto->judul }}</div>
                    <div class="gallery-category"><i class="fas fa-tag"></i>{{ $foto->kategori->nama ?? 'Lainnya' }}</div>
                    <div class="action-bar">
                        <button type="button" class="action-btn" title="Like">
                            <i class="fas fa-thumbs-up"></i>
                            <span>{{ $foto->likes_count ?? 0 }}</span>
                        </button>
                        <button type="button" class="action-btn" title="Dislike">
                            <i class="fas fa-thumbs-down"></i>
                            <span>{{ $foto->dislikes_count ?? 0 }}</span>
                        </button>
                        <button type="button" class="action-btn" title="Comment">
                            <i class="fas fa-comment"></i>
                            <span>{{ $foto->comments()->where('status','approved')->count() }}</span>
                        </button>
                        <button type="button" class="action-btn" title="Download" data-bs-toggle="modal" data-bs-target="#downloadModal" data-foto-id="{{ $foto->id }}">
                            <i class="fas fa-download"></i>
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <i class="fas fa-images fa-2x mb-2"></i>
                <div>Belum ada foto</div>
            </div>
            @endforelse
        </div>
    </div>
    
    <!-- Download Consent Modal -->
    <div class="modal fade" id="downloadModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-lock me-2"></i>Formulir Sebelum Unduh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ request()->is('gallery*') ? route('gallery.download.auth') : route('galeri.download.auth') }}">
                    @csrf
                    <input type="hidden" name="foto_id" id="downloadFotoId">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Aktif</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status / Peran</label>
                            <input type="text" name="status" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tujuan Unduhan</label>
                            <input type="text" name="tujuan" class="form-control" required>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" id="agreeCheck" name="agree" required>
                            <label class="form-check-label" for="agreeCheck">
                                Saya menyetujui bahwa foto hanya digunakan untuk keperluan baik dan tidak disalahgunakan.
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Unduh</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const galleryItems = document.querySelectorAll('.gallery-item');
    const searchInput = document.getElementById('searchInput');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const cat = this.getAttribute('data-category');
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            galleryItems.forEach(item => {
                item.style.display = (cat === 'all' || item.getAttribute('data-category') === cat) ? 'block' : 'none';
            });
        });
    });

    searchInput.addEventListener('input', function() {
        const term = this.value.toLowerCase();
        galleryItems.forEach(item => {
            item.style.display = item.getAttribute('data-title').includes(term) ? 'block' : 'none';
        });
    });
    // Set foto id into modal hidden field
    const downloadModal = document.getElementById('downloadModal');
    if (downloadModal) {
        downloadModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const fotoId = button.getAttribute('data-foto-id');
            document.getElementById('downloadFotoId').value = fotoId;
        });
        // Auto-close modal on submit
        const form = downloadModal.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Mengunduh...';
                }
                const modal = bootstrap.Modal.getInstance(downloadModal) || new bootstrap.Modal(downloadModal);
                modal.hide();
            });
        }
    }
});
</script>
@endsection


