@extends('layouts.admin')

@section('title','Laporan Galeri - Admin Panel')
@section('page-title','Laporan Galeri')

@section('content')
<div class="mb-4">
    <!-- Filter dan Generate PDF -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">📊 Filter & Generate Laporan</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Filter Periode</label>
                    <select name="period" class="form-select" onchange="this.form.submit()">
                        <option value="all" {{ $period === 'all' ? 'selected' : '' }}>Semua Waktu</option>
                        <option value="weekly" {{ $period === 'weekly' ? 'selected' : '' }}>1 Minggu Terakhir</option>
                        <option value="monthly" {{ $period === 'monthly' ? 'selected' : '' }}>1 Bulan Terakhir</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-primary" href="{{ route('admin.gallery.report', request()->only('period')) }}" target="_blank">
                        <i class="fas fa-file-pdf me-1"></i>Generate PDF
                    </a>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Summary Cards - Simple -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 text-center bg-primary text-white">
                <div class="fs-4 fw-bold">{{ $summary['total_photos'] }}</div>
                <div class="small">Total Foto</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center bg-success text-white">
                <div class="fs-4 fw-bold">{{ $summary['likes'] }}</div>
                <div class="small">Total Like</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center bg-info text-white">
                <div class="fs-4 fw-bold">{{ $summary['comments'] }}</div>
                <div class="small">Komentar Disetujui</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center bg-warning text-white">
                <div class="fs-4 fw-bold">{{ $summary['downloads'] }}</div>
                <div class="small">Total Download</div>
            </div>
        </div>
    </div>
</div>

<!-- Simple Photo List -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">📸 Daftar Foto Galeri</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Like</th>
                        <th>Komentar</th>
                        <th>Download</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fotos as $index => $foto)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <img src="{{ asset('storage/'.$foto->path) }}" alt="{{ $foto->judul }}" 
                                 style="width:50px;height:40px;object-fit:cover;border-radius:4px;">
                        </td>
                        <td>{{ $foto->judul }}</td>
                        <td>
                            <span class="badge bg-secondary">{{ $foto->kategori->nama ?? '-' }}</span>
                        </td>
                        <td>
                            <span class="badge bg-success">{{ $foto->likes_count ?? 0 }}</span>
                        </td>
                        <td>
                            <span class="badge bg-info">{{ $foto->comments->count() }}</span>
                        </td>
                        <td>
                            <span class="badge bg-warning">{{ $foto->downloadLogs->count() }}</span>
                        </td>
                        <td>{{ $foto->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


