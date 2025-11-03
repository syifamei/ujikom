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
                <div class="fs-4 fw-bold">{{ $summary['total_users'] }}</div>
                <div class="small">Total User Terdaftar</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center bg-info text-white">
                <div class="fs-4 fw-bold">{{ $summary['total_photos'] }}</div>
                <div class="small">Total Foto</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center bg-success text-white">
                <div class="fs-4 fw-bold">{{ $summary['total_likes'] }}</div>
                <div class="small">Total Like</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 text-center bg-warning text-white">
                <div class="fs-4 fw-bold">{{ $summary['total_downloads'] }}</div>
                <div class="small">Total Download</div>
            </div>
        </div>
    </div>
</div>

<!-- Daftar User Terdaftar -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">👥 Daftar User yang Sudah Register/Login</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $user->username ?? $user->name }}</strong></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_active ?? true)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada user pada periode ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Like & Download per Kategori -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">📊 Statistik per Kategori</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Total Foto</th>
                        <th>Total Like</th>
                        <th>Total Download</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoriStats as $index => $stat)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $stat['nama'] }}</strong></td>
                        <td><span class="badge bg-info">{{ $stat['total_fotos'] }}</span></td>
                        <td><span class="badge bg-success">{{ $stat['total_likes'] }}</span></td>
                        <td><span class="badge bg-warning">{{ $stat['total_downloads'] }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Tidak ada data kategori</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Daftar Foto dengan Like & Download -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">📸 Detail Foto - Like & Download per Foto</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Like</th>
                        <th>Download</th>
                        <th>Tanggal Upload</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fotos as $index => $foto)
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
                            <span class="badge bg-success">
                                <i class="fas fa-heart"></i> {{ $foto->likes_count_period ?? 0 }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-warning">
                                <i class="fas fa-download"></i> {{ $foto->downloads_count_period ?? 0 }}
                            </span>
                        </td>
                        <td>{{ $foto->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Tidak ada foto pada periode ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Responsive untuk Summary Cards */
    @media (max-width: 768px) {
        .row.g-3 {
            gap: 0.75rem;
        }

        .col-md-3 {
            margin-bottom: 0.75rem;
        }

        .card p-3 {
            padding: 1rem !important;
        }

        .fs-4 {
            font-size: 1.5rem !important;
        }
    }

    @media (max-width: 576px) {
        .row.g-3 {
            gap: 0.5rem;
        }

        .col-md-4 {
            margin-bottom: 0.75rem;
        }

        .col-md-3 .card {
            padding: 0.75rem !important;
        }

        .fs-4 {
            font-size: 1.25rem !important;
        }

        .small {
            font-size: 0.75rem;
        }

        /* Form responsiveness */
        .row.align-items-end {
            flex-direction: column;
            align-items: stretch !important;
        }

        .col-md-4 {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .btn {
            width: 100%;
            margin-top: 0.5rem;
        }

        /* Table responsiveness */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table {
            font-size: 0.8rem;
        }

        .table th,
        .table td {
            padding: 0.5rem 0.3rem;
            white-space: nowrap;
        }

        .table td img {
            width: 40px !important;
            height: 32px !important;
        }

        .badge {
            font-size: 0.65rem;
            padding: 0.25rem 0.4rem;
        }

        /* Card adjustments */
        .card-header h5 {
            font-size: 0.95rem;
        }

        .card-body {
            padding: 0.75rem;
        }
    }

    @media (max-width: 400px) {
        .card p-3 {
            padding: 0.5rem !important;
        }

        .fs-4 {
            font-size: 1.1rem !important;
        }

        .table {
            font-size: 0.7rem;
        }

        .table th,
        .table td {
            padding: 0.4rem 0.2rem;
        }

        .table td img {
            width: 35px !important;
            height: 28px !important;
        }
    }

    /* Ensure cards look good on all devices */
    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    /* Better mobile card spacing */
    @media (max-width: 576px) {
        .mb-4 {
            margin-bottom: 1rem !important;
        }

        .card {
            margin-bottom: 0.75rem;
        }
    }
</style>
@endsection


