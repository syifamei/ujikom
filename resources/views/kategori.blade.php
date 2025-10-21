@extends('layouts.app')

@section('title', $kategori->judul . ' - Galeri Sekolah')

@section('content')
<!-- Page Header -->
<section class="py-5 bg-warning text-dark">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold">
                    <i class="fas fa-th-large me-3"></i>
                    {{ $kategori->judul }}
                </h1>
                <p class="lead">Kumpulan konten dalam kategori {{ $kategori->judul }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Posts Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            @forelse($posts as $post)
                <div class="col-lg-6 mb-4">
                    <div class="card h-100">
                        @if($post->galeries->count() > 0)
                            @foreach($post->galeries as $galery)
                                @if($galery->fotos->count() > 0)
                                    <img src="{{ asset('storage/' . $galery->fotos->first()->file) }}" 
                                         class="card-img-top" 
                                         alt="{{ $post->judul }}" 
                                         style="height: 200px; object-fit: cover;">
                                    @break
                                @endif
                            @endforeach
                        @endif
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <h5 class="card-title">{{ $post->judul }}</h5>
                            </div>
                            <p class="card-text">{{ Str::limit($post->isi, 200) }}</p>
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>{{ \Carbon\Carbon::parse($post->created_at)->format('d M Y') }}
                                </small>
                            </div>
                            
                            @if($post->galeries->count() > 0)
                                <div class="mt-3">
                                    <small class="text-muted">
                                        <i class="fas fa-images me-1"></i>
                                        {{ $post->galeries->sum(function($galery) { return $galery->fotos->count(); }) }} foto
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="py-5">
                        <i class="fas fa-folder fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada konten dalam kategori ini</h4>
                        <p class="text-muted">Konten akan ditampilkan di sini</p>
                    </div>
                </div>
            @endforelse
        </div>

        @php
            $fotosKategori = \App\Models\Foto::with('kategori')
                ->whereHas('kategori', function($q) use ($kategori) {
                    $q->where('nama', 'LIKE', '%' . $kategori->judul . '%');
                })
                ->where('status', 'aktif')
                ->latest()
                ->take(12)
                ->get();
        @endphp

        @if($fotosKategori->count())
        <hr class="my-5">
        <div class="row mb-3">
            <div class="col-12">
                <h3 class="h5 text-primary mb-3">
                    <i class="fas fa-images me-2"></i>Galeri Foto {{ $kategori->judul }}
                </h3>
            </div>
        </div>
        <div class="row">
            @foreach($fotosKategori as $foto)
                <div class="col-6 col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ asset('storage/' . $foto->path) }}" class="card-img-top" alt="{{ $foto->judul }}" style="height: 150px; object-fit: cover;">
                        <div class="card-body p-2">
                            <div class="small fw-semibold text-truncate">{{ $foto->judul }}</div>
                            <div class="text-muted small">{{ $foto->kategori->nama ?? 'Tanpa Kategori' }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif

        <!-- Pagination -->
        @if($posts->hasPages())
            <div class="row">
                <div class="col-12">
                    <nav aria-label="Posts pagination">
                        {{ $posts->links() }}
                    </nav>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
