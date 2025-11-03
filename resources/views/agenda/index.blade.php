@extends('layouts.app')

@section('title', 'Agenda Sekolah')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="page-header">
        <h1 class="page-title">Agenda Sekolah</h1>
        <p class="page-subtitle">Jadwal dan informasi kegiatan terbaru SMKN 4 Bogor</p>
    </div>

    @if($agendas->count() > 0)
        <div class="row g-4">
            @foreach($agendas as $agenda)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-3 me-3">
                                <i class="fas fa-calendar-alt fa-2x"></i>
                            </div>
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-primary mb-1">
                                    {{ $agenda->status ?? 'Aktif' }}
                                </span>
                                <h5 class="card-title mb-0">{{ $agenda->title ?? $agenda->judul ?? 'Agenda' }}</h5>
                            </div>
                        </div>
                        
                        <p class="card-text text-muted mb-3">
                            <i class="far fa-calendar-alt me-2"></i>
                            {{ \Carbon\Carbon::parse($agenda->scheduled_at ?? now())->translatedFormat('l, d F Y') }}
                            @if(!empty($agenda->waktu))
                                <br><i class="far fa-clock me-2"></i> {{ $agenda->waktu }}
                            @endif
                            @if(!empty($agenda->lokasi))
                                <br><i class="fas fa-map-marker-alt me-2"></i> {{ $agenda->lokasi }}
                            @endif
                        </p>
                        
                        <p class="card-text">
                            {{ Str::limit(strip_tags($agenda->description ?? $agenda->deskripsi ?? ''), 120) }}
                        </p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('agenda.show', $agenda) }}" class="btn btn-sm btn-outline-primary">
                                Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            {{ $agendas->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-5 my-5">
            <div class="mb-4">
                <i class="fas fa-calendar-alt fa-4x text-muted opacity-25"></i>
            </div>
            <h4 class="mb-2">Belum ada agenda</h4>
            <p class="text-muted mb-0">Silakan periksa kembali di lain waktu</p>
        </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    /* Page Header */
    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .page-title {
        font-size: 2rem !important;
        font-weight: 700 !important;
        color: #1f2937 !important;
        margin-bottom: 10px !important;
    }

    .page-subtitle {
        font-size: 1rem !important;
        color: #6b7280 !important;
    }

    /* Card Styles */
    .card {
        border-radius: 12px;
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #e9ecef;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .card-title {
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 0.5rem;
    }

    .card-text {
        color: #4a5568;
        line-height: 1.6;
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    /* Pagination styles */
    .pagination .page-link {
        color: #4e54c8;
        border: 1px solid #dee2e6;
        margin: 0 5px;
        border-radius: 8px !important;
    }

    .pagination .page-item.active .page-link {
        background-color: #4e54c8;
        border-color: #4e54c8;
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #f8f9fa;
    }

    /* Empty state */
    .agenda-empty { 
        width: 100%;
        text-align: center; 
        padding: 3rem 1rem; 
        background: #f8f9fa; 
        border: 1px dashed #dee2e6; 
        border-radius: 12px;
        margin: 2rem 0;
    }
    
    .agenda-empty i {
        font-size: 3rem;
        color: #adb5bd;
        margin-bottom: 1rem;
    }

    /* Status badges */
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
    }
</style>
@endsection
