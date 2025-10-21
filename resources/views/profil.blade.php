@extends('layouts.app')

@section('title', 'Profil - SMKN 4 BOGOR')

@section('content')
<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">
                    <i class="fas fa-school me-3"></i>
                    Profil SMKN 4 Bogor
                </h1>
                <p class="lead mb-4">
                    Sekolah Menengah Kejuruan Negeri yang berkomitmen menghasilkan lulusan berkualitas, 
                    berakhlak mulia, dan siap kerja sesuai kebutuhan dunia usaha dan industri.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <span class="badge bg-light text-primary fs-6 px-3 py-2">
                        <i class="fas fa-calendar-alt me-2"></i>Berdiri 2009
                    </span>
                    <span class="badge bg-light text-primary fs-6 px-3 py-2">
                        <i class="fas fa-map-marker-alt me-2"></i>Kota Bogor
                    </span>
                    <span class="badge bg-light text-primary fs-6 px-3 py-2">
                        <i class="fas fa-graduation-cap me-2"></i>SMK Negeri
                    </span>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="hero-image">
                    <i class="fas fa-school text-white" style="font-size: 8rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Visi Misi Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-3">
                <h3 class="text-primary fw-bold fs-5">
                    <i class="fas fa-bullseye me-2"></i>
                    Visi & Misi
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 mb-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-body text-center p-3">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 56px; height: 56px;">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h3 class="card-title text-primary fw-bold mb-2 fs-6">Visi</h3>
                        <p class="card-text">
                            "Menjadi SMK Unggulan yang menghasilkan lulusan berkualitas, berakhlak mulia, dan siap kerja sesuai dengan kebutuhan dunia usaha dan dunia industri"
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 14px;">
                    <div class="card-body text-center p-3">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 56px; height: 56px;">
                            <i class="fas fa-target"></i>
                        </div>
                        <h3 class="card-title text-primary fw-bold mb-2 fs-6">Misi</h3>
                        <ul class="list-unstyled text-start">
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Menyelenggarakan pendidikan kejuruan yang berkualitas</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Mengembangkan kompetensi siswa sesuai standar industri</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Membentuk karakter siswa yang berakhlak mulia</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Meningkatkan kerjasama dengan dunia usaha dan industri</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-primary me-2"></i>Mengembangkan inovasi pembelajaran yang efektif</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Nilai-Nilai Sekolah Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h3 class="text-primary fw-bold">
                    <i class="fas fa-heart me-2"></i>
                    Nilai-Nilai Sekolah
                </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-lightbulb fa-lg"></i>
                        </div>
                        <h3 class="h6 fw-bold mb-2">Kreativitas</h3>
                        <p class="card-text small">Mendorong siswa untuk berpikir kreatif dan inovatif dalam setiap aspek pembelajaran.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-handshake fa-lg"></i>
                        </div>
                        <h3 class="h6 fw-bold mb-2">Integritas</h3>
                        <p class="card-text small">Menanamkan nilai kejujuran, tanggung jawab, dan konsistensi dalam setiap tindakan.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <h3 class="h6 fw-bold mb-2">Kolaborasi</h3>
                        <p class="card-text small">Mengembangkan kemampuan bekerja sama dan membangun tim yang solid.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="fas fa-star fa-lg"></i>
                        </div>
                        <h3 class="h6 fw-bold mb-2">Keunggulan</h3>
                        <p class="card-text small">Berusaha mencapai standar tertinggi dalam setiap aspek pendidikan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Sejarah Sekolah Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="text-primary fw-bold">
                    <i class="fas fa-history me-2"></i>
                    Sejarah Singkat
                </h3>
                <p class="text-muted">Perjalanan SMKN 4 Bogor dalam membangun pendidikan kejuruan berkualitas</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5">
                        <div class="timeline">
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h5 class="fw-bold text-primary">2009</h5>
                                    <h6 class="fw-bold">Pendirian SMKN 4 Bogor</h6>
                                    <p class="text-muted mb-0">SMKN 4 Bogor didirikan sebagai sekolah menengah kejuruan negeri dengan fokus pada Teknik Fabrikasi Logam dan Manufaktur.</p>
                                </div>
                            </div>
                            <div class="timeline-item mb-4">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h5 class="fw-bold text-success">2013</h5>
                                    <h6 class="fw-bold">Implementasi Kurikulum 2013</h6>
                                    <p class="text-muted mb-0">Sekolah mengadopsi Kurikulum 2013 REV untuk meningkatkan kualitas pembelajaran dan relevansi dengan dunia industri.</p>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h5 class="fw-bold text-info">Sekarang</h5>
                                    <h6 class="fw-bold">Kepemimpinan Berkelanjutan</h6>
                                    <p class="text-muted mb-0">Dibawah kepemimpinan <strong>Mulya Murprihartono</strong> sebagai Kepala Sekolah dan <strong>Makmun Nawawi</strong> sebagai Operator, sekolah terus berkomitmen menghasilkan lulusan berkualitas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fasilitas Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="text-primary fw-bold">
                    <i class="fas fa-building me-2"></i>
                    Fasilitas Sekolah
                </h3>
                <p class="text-muted">Infrastruktur modern untuk mendukung pembelajaran yang optimal</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-laptop fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Lab Komputer</h5>
                        <p class="card-text small">Laboratorium komputer modern dengan perangkat terbaru untuk pembelajaran teknologi informasi dan digital.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-tools fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Bengkel Praktik</h5>
                        <p class="card-text small">Bengkel praktik yang lengkap dengan peralatan modern untuk pembelajaran teknik fabrikasi logam dan manufaktur.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-book fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Perpustakaan</h5>
                        <p class="card-text small">Perpustakaan dengan koleksi buku yang lengkap dan ruang baca yang nyaman untuk mendukung pembelajaran.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-wifi fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Internet & IT</h5>
                        <p class="card-text small">Fasilitas internet berkecepatan tinggi dan infrastruktur IT yang mendukung pembelajaran digital.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistik Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="text-primary fw-bold">
                    <i class="fas fa-chart-bar me-2"></i>
                    Statistik Sekolah
                </h3>
                <p class="text-muted">Data dan pencapaian SMKN 4 Bogor</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                        <h3 class="h3 fw-bold text-primary mb-2">800+</h3>
                        <h5 class="fw-bold mb-2">Siswa Aktif</h5>
                        <p class="text-muted small mb-0">Siswa yang sedang menempuh pendidikan di SMKN 4 Bogor</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                        <h3 class="h3 fw-bold text-success mb-2">45+</h3>
                        <h5 class="fw-bold mb-2">Guru & Staff</h5>
                        <p class="text-muted small mb-0">Tenaga pendidik dan kependidikan yang profesional</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-trophy fa-2x"></i>
                        </div>
                        <h3 class="h3 fw-bold text-warning mb-2">150+</h3>
                        <h5 class="fw-bold mb-2">Prestasi</h5>
                        <p class="text-muted small mb-0">Penghargaan dan prestasi yang diraih siswa</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card text-center border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-graduation-cap fa-2x"></i>
                        </div>
                        <h3 class="h3 fw-bold text-info mb-2">98%</h3>
                        <h5 class="fw-bold mb-2">Kelulusan</h5>
                        <p class="text-muted small mb-0">Tingkat kelulusan siswa yang sangat tinggi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Prestasi Section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="text-primary fw-bold">
                    <i class="fas fa-award me-2"></i>
                    Prestasi & Penghargaan
                </h3>
                <p class="text-muted">Pencapaian terbaik yang diraih SMKN 4 Bogor</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-medal fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Lomba Teknologi</h5>
                        <p class="card-text small">Juara 1 Lomba Teknologi Tingkat Provinsi Jawa Barat</p>
                        <span class="badge bg-warning text-dark">2023</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-star fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Sekolah Berprestasi</h5>
                        <p class="card-text small">Penghargaan Sekolah Berprestasi Tingkat Kota Bogor</p>
                        <span class="badge bg-success">2022</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-trophy fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Kompetensi Siswa</h5>
                        <p class="card-text small">Sertifikasi Kompetensi Siswa dengan Tingkat Kelulusan 100%</p>
                        <span class="badge bg-primary">2023</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Informasi Kontak Section -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h3 class="text-primary fw-bold">
                    <i class="fas fa-phone me-2"></i>
                    Informasi Kontak
                </h3>
                <p class="text-muted">Hubungi kami untuk informasi lebih lanjut</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-map-marker-alt fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Alamat</h5>
                        <p class="card-text small mb-0">Kp. Buntar Kelurahan Muarasari<br>Kota Bogor, Jawa Barat</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-user-tie fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Kepala Sekolah</h5>
                        <p class="card-text small mb-0"><strong>Mulya Murprihartono</strong><br>Kepala SMKN 4 Bogor</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="bg-info text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="fas fa-cogs fa-lg"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Operator</h5>
                        <p class="card-text small mb-0"><strong>Makmun Nawawi</strong><br>Operator SMKN 4 Bogor</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="section-padding bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">
                    <i class="fas fa-graduation-cap me-2"></i>
                    Bergabunglah dengan SMKN 4 Bogor
                </h3>
                <p class="lead mb-0">
                    Daftarkan diri Anda dan wujudkan impian menjadi lulusan SMK yang siap kerja dan berakhlak mulia.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('kontak') }}" class="btn btn-light btn-lg px-4 py-3">
                    <i class="fas fa-phone me-2"></i>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
