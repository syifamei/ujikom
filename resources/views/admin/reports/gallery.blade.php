<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Galeri - {{ $generatedAt }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #2c3e50;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }
        
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 5px;
        }
        
        .stat-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 15px;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 5px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        
        .table th {
            background-color: #f8f9fa;
            font-weight: bold;
            font-size: 11px;
        }
        
        .table td {
            font-size: 10px;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .badge {
            display: inline-block;
            padding: 2px 6px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 3px;
            color: white;
        }
        
        .badge-success {
            background-color: #28a745;
        }
        
        .badge-warning {
            background-color: #ffc107;
            color: #000;
        }
        
        .badge-info {
            background-color: #17a2b8;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>
            @if(!empty($kategori))
                Laporan Galeri – Kategori {{ $kategori }}
            @else
                Laporan Galeri Sekolah
            @endif
        </h1>
        <p>SMKN 4 BOGOR</p>
        <p>Dibuat pada: {{ $generatedAt }}</p>
        <p>Periode: {{ $period }}</p>
    </div>

    <!-- Statistics Overview -->
    <div class="section">
        <div class="section-title">Ringkasan Statistik</div>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number">{{ $totalUsers }}</div>
                <div class="stat-label">Total User</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $totalPhotos }}</div>
                <div class="stat-label">Total Foto</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $totalLikes }}</div>
                <div class="stat-label">Total Like</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $totalDownloads }}</div>
                <div class="stat-label">Total Download</div>
            </div>
        </div>
    </div>

    <!-- Daftar User Terdaftar -->
    <div class="section">
        <div class="section-title">Daftar User yang Sudah Register/Login ({{ $period }})</div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Tanggal Daftar</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $user->username ?? $user->name }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada user pada periode ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Statistik per Kategori -->
    <div class="section">
        <div class="section-title">Statistik Like & Download per Kategori</div>
        <table class="table">
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
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $stat['nama'] }}</td>
                    <td class="text-center">{{ $stat['total_fotos'] }}</td>
                    <td class="text-center">{{ $stat['total_likes'] }}</td>
                    <td class="text-center">{{ $stat['total_downloads'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data kategori</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Detail Foto dengan Like & Download -->
    <div class="section page-break">
        <div class="section-title">Detail Like & Download per Foto ({{ $period }})</div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Foto</th>
                    <th>Kategori</th>
                    <th>Like</th>
                    <th>Download</th>
                    <th>Tanggal Upload</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fotos as $index => $foto)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $foto->judul }}</td>
                    <td>{{ $foto->kategori ? $foto->kategori->nama : '-' }}</td>
                    <td class="text-center">{{ $foto->likes_count_period ?? 0 }}</td>
                    <td class="text-center">{{ $foto->downloads_count_period ?? 0 }}</td>
                    <td>{{ $foto->created_at->format('d/m/Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada foto pada periode ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem manajemen galeri SMKN 4 BOGOR</p>
        <p>Halaman 1 dari 1 | {{ $generatedAt }}</p>
    </div>
</body>
</html>

