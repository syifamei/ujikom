@extends('layouts.admin')

@section('title', 'Agenda - Admin Panel')
@section('page-title', 'Agenda')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0"><i class="fas fa-calendar-alt me-2 text-primary"></i>Manajemen Agenda</h3>
        <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Agenda
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="gallery-container">
        @forelse($agendas as $agenda)
        <div class="gallery-item">
            <div class="gallery-card">
                <div class="gallery-thumb-wrapper">
                    @if($agenda->photo_path)
                        <img src="{{ asset('storage/'.$agenda->photo_path) }}" alt="Agenda" class="gallery-thumb">
                    @else
                        <img src="{{ asset('images/logo/logo-smk.png') }}" alt="Agenda" class="gallery-thumb">
                    @endif
                </div>
                <div class="gallery-actions actions-below">
                    <button type="button" class="gallery-action action-view" title="Lihat" data-bs-toggle="modal" data-bs-target="#agendaPreviewModal" data-title="{{ strip_tags($agenda->title ?? 'Agenda') }}" data-img="{{ $agenda->photo_path ? asset('storage/'.$agenda->photo_path) : asset('images/logo/logo-smk.png') }}" data-desc="{{ e(Str::limit(strip_tags($agenda->description), 500)) }}">
                        <i class="fas fa-eye"></i>
                    </button>
                    <a href="{{ route('admin.agenda.edit', $agenda) }}" class="gallery-action action-edit" title="Edit">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.agenda.destroy', $agenda) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus agenda ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="gallery-action action-delete" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                <div class="gallery-card-body">
                    <div class="gallery-title">{{ Str::limit(strip_tags($agenda->title ?? 'Agenda'), 60) }}</div>
                    <div class="gallery-category">
                        <span class="badge {{ $agenda->status==='Aktif'?'bg-success':'bg-secondary' }}">{{ $agenda->status }}</span>
                    </div>
                    <div class="text-muted small">{{ Str::limit(strip_tags($agenda->description), 90) }}</div>
                </div>
            </div>
        </div>
        @empty
        <div class="gallery-empty">
            <div class="gallery-empty-icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <h3 class="gallery-empty-title">Belum ada agenda</h3>
            <p class="gallery-empty-subtitle">Mulai dengan menambahkan agenda pertama</p>
            <a href="{{ route('admin.agenda.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Tambah Agenda Pertama
            </a>
        </div>
        @endforelse
    </div>

    <div class="mt-3">{{ $agendas->links() }}</div>
</div>
@endsection

@section('styles')
<style>
    .gallery-container { display:grid; grid-template-columns: repeat(4, 1fr); gap:1.25rem; align-items: stretch; }
    .gallery-item { width:100%; }
    .gallery-card { background: rgba(255,255,255,.25); backdrop-filter: blur(8px); border:1px solid rgba(255,255,255,.18); border-radius:16px; box-shadow: 0 8px 24px rgba(31,38,135,.18); overflow:hidden; transition: .3s; display:flex; flex-direction:column; min-height: 300px; }
    .gallery-card:hover { transform: translateY(-5px); box-shadow: 0 20px 40px rgba(0,0,0,.15); }
    .gallery-card-header { display:none; }
    .gallery-actions { display:flex; gap:.4rem; justify-content:center; padding:.45rem 0 .1rem; }
    .actions-below { margin-top:.5rem; }
    .gallery-action { width:32px; height:32px; border-radius:8px; border:none; display:flex; align-items:center; justify-content:center; color:#fff; box-shadow:0 2px 8px rgba(0,0,0,.15); font-size:.9rem; }
    .action-view { background:#17a2b8; }
    .action-edit { background:#ffc107; color:#000; }
    .action-delete { background:#dc3545; }
    .gallery-thumb-wrapper { position:relative; width:100%; aspect-ratio:4/3; overflow:hidden; background:#f8f9fa; margin:0; border-radius:16px 16px 12px 12px; }
    .gallery-thumb { width:100%; height:100%; object-fit:cover; display:block; transition: transform .4s ease; }
    .gallery-card:hover .gallery-thumb { transform: scale(1.05); }
    .gallery-card-body { padding:.75rem 1rem 1rem; display:flex; flex-direction:column; gap:.55rem; }
    .gallery-title { font-size:1.1rem; font-weight:600; color:#2c3e50; margin:0; line-height:1.3; }
    .gallery-category { display:flex; align-items:center; gap:.5rem; font-size:.9rem; color:#6c757d; font-weight:500; }
    .gallery-empty { grid-column:1/-1; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:4rem 2rem; text-align:center; background:rgba(255,255,255,.25); border:1px solid rgba(255,255,255,.18); border-radius:20px; }
    .gallery-empty-icon { width:80px; height:80px; background:#0d6efd; border-radius:20px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:2.5rem; margin-bottom:1.5rem; }
    @media (max-width:1200px){ .gallery-container{ grid-template-columns: repeat(3,1fr);} }
    @media (max-width:991px){ .gallery-container{ grid-template-columns: repeat(2,1fr);} }
    @media (max-width:575px){ .gallery-container{ grid-template-columns: 1fr;} }
    /* Modal preview size */
    .agenda-modal .modal-dialog { max-width: 600px; }
    .agenda-modal .modal-body img { width:100%; height:auto; max-height:50vh; object-fit:cover; border-radius:10px; }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const modalEl = document.getElementById('agendaPreviewModal');
    if (!modalEl) return;
    modalEl.addEventListener('show.bs.modal', function (event) {
        const btn = event.relatedTarget;
        const title = btn.getAttribute('data-title') || 'Agenda';
        const img = btn.getAttribute('data-img');
        const desc = btn.getAttribute('data-desc') || '';
        modalEl.querySelector('.modal-title').textContent = title;
        modalEl.querySelector('img').setAttribute('src', img);
        modalEl.querySelector('.agenda-desc').textContent = desc;
    });
});
</script>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush

<!-- Preview Modal -->
<div class="modal fade agenda-modal" id="agendaPreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agenda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img src="" alt="Agenda Preview">
                <p class="mt-3 agenda-desc text-muted" style="max-height:160px; overflow:auto;"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


