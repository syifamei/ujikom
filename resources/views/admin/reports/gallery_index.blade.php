@extends('layouts.admin')

@section('title','Laporan Galeri - Admin Panel')
@section('page-title','Laporan Galeri')

@section('content')
<div class="mb-4">
    <form method="GET" class="mb-3">
        <div class="row g-2 align-items-end">
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
        </div>
    </form>
    
    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <div class="text-muted">Total Foto</div>
                <div class="fs-3 fw-bold">{{ $summary['total_photos'] }}</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <div class="text-muted">Total Like</div>
                <div class="fs-3 fw-bold">{{ $summary['likes'] }}</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <div class="text-muted">Total Dislike</div>
                <div class="fs-3 fw-bold">{{ $summary['dislikes'] }}</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <div class="text-muted">Komentar Disetujui</div>
                <div class="fs-3 fw-bold text-success">{{ $summary['comments'] }}</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <div class="text-muted">Komentar Pending</div>
                <div class="fs-3 fw-bold text-warning">{{ $summary['pending_comments'] }}</div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card p-3 text-center">
                <div class="text-muted">Komentar Ditolak</div>
                <div class="fs-3 fw-bold text-danger">{{ $summary['rejected_comments'] }}</div>
            </div>
        </div>
    </div>

    <!-- Download Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-12">
            <div class="card p-3 text-center">
                <div class="text-muted">Total Download</div>
                <div class="fs-3 fw-bold">{{ $summary['downloads'] }}</div>
            </div>
        </div>
    </div>

    <!-- Comparison Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">📊 Statistik Mingguan</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Foto</div>
                                <div class="fw-bold">{{ $weeklyStats['total_photos'] }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Like</div>
                                <div class="fw-bold">{{ $weeklyStats['likes'] }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Komentar</div>
                                <div class="fw-bold text-success">{{ $weeklyStats['comments'] }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Pending</div>
                                <div class="fw-bold text-warning">{{ $weeklyStats['pending_comments'] }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Download</div>
                                <div class="fw-bold">{{ $weeklyStats['downloads'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">📈 Statistik Bulanan</h5>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Foto</div>
                                <div class="fw-bold">{{ $monthlyStats['total_photos'] }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Like</div>
                                <div class="fw-bold">{{ $monthlyStats['likes'] }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Komentar</div>
                                <div class="fw-bold text-success">{{ $monthlyStats['comments'] }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Pending</div>
                                <div class="fw-bold text-warning">{{ $monthlyStats['pending_comments'] }}</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="text-center p-2 bg-light rounded">
                                <div class="text-muted small">Download</div>
                                <div class="fw-bold">{{ $monthlyStats['downloads'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <canvas id="galleryChart" height="90"></canvas>
    </div>
    <div class="card-footer">
        <small class="text-muted">Distribusi interaksi per foto ({{ ucfirst($period) === 'All' ? 'Semua Waktu' : ($period === 'weekly' ? '1 Minggu Terakhir' : '1 Bulan Terakhir') }})</small>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Foto</th>
                        <th>Like</th>
                        <th>Dislike</th>
                        <th>Komentar Disetujui</th>
                        <th>Komentar Pending</th>
                        <th>Komentar Ditolak</th>
                        <th>Download</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fotos as $foto)
                    <tr>
                        <td>{{ $foto->judul }}</td>
                        <td>{{ $foto->kategori->nama ?? '-' }}</td>
                        <td><img src="{{ asset('storage/'.$foto->path) }}" alt="{{ $foto->judul }}" style="width:60px;height:45px;object-fit:cover;border-radius:6px;"></td>
                        <td>{{ $foto->likes_count ?? 0 }}</td>
                        <td>{{ $foto->dislikes_count ?? 0 }}</td>
                        <td><span class="badge bg-success">{{ $foto->comments->count() }}</span></td>
                        <td><span class="badge bg-warning">{{ $foto->pendingComments->count() }}</span></td>
                        <td><span class="badge bg-danger">{{ $foto->rejectedComments->count() }}</span></td>
                        <td>{{ $foto->downloadLogs->count() }}</td>
                        <td>{{ $foto->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.gallery.report', request()->only('period')) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="fas fa-file-pdf me-1"></i>Generate PDF
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartCtx = document.getElementById('galleryChart');
    const labels = @json($fotos->pluck('judul'));
    const likes = @json($fotos->pluck('likes_count'));
    const downloads = @json($fotos->map(fn($f)=>$f->downloadLogs->count()));

    new Chart(chartCtx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                { label: 'Like', data: likes, backgroundColor: 'rgba(37,99,235,.5)' },
                { label: 'Download', data: downloads, backgroundColor: 'rgba(16,185,129,.5)' }
            ]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });
</script>
@endsection


