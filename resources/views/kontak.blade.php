@extends('layouts.app')

@section('title', 'Kontak - SMKN 4 BOGOR')

@section('styles')
<style>
    .card {
        transition: all 0.3s ease;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .map-container {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .map-container iframe {
        border-radius: 8px;
    }
    
    /* Single column layout with contact and map side by side */
    .contact-container {
        display: flex;
        flex-direction: row;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .contact-info {
        flex: 1;
        padding-right: 20px;
        border-right: 1px solid #e0e0e0;
    }
    
    .map-section {
        flex: 1;
        padding-left: 20px;
    }
    
    @media (max-width: 768px) {
        .contact-container {
            flex-direction: column;
        }
        .contact-info, .map-section {
            width: 100%;
            padding: 0;
            border-right: none;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
    }
</style>
@endsection

@section('content')
<!-- Page Header -->
<section class="py-5 bg-info text-white">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold">
                    <i class="fas fa-envelope me-3"></i>
                    Kontak Sekolah
                </h1>
                <p class="lead">Hubungi kami untuk informasi lebih lanjut</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section - Updated Layout -->
<section class="py-5">
    <div class="container">
        <!-- Single Column with Contact and Map Side by Side -->
        <div class="row">
            <div class="col-12">
                <div class="contact-container">
                    <!-- Contact Info Section -->
                    <div class="contact-info">
                        <h3 class="mb-4">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informasi Kontak
                        </h3>
                        <div class="mb-4">
                            <h5><i class="fas fa-map-marker-alt text-primary me-2"></i>Alamat</h5>
                            <p class="mb-0">Kp. Buntar, Kelurahan Muarasari<br>
                            Kecamatan Bogor Selatan<br>
                            Kota Bogor, Jawa Barat 16137</p>
                        </div>
                        <div class="mb-4">
                            <h5><i class="fas fa-phone text-primary me-2"></i>Telepon</h5>
                            <p class="mb-0">(0251) 7547-381</p>
                        </div>
                        <div class="mb-4">
                            <h5><i class="fas fa-envelope text-primary me-2"></i>Email</h5>
                            <p class="mb-0">info@smkn4bogor.sch.id</p>
                        </div>
                        <div class="mb-4">
                            <h5><i class="fas fa-clock text-primary me-2"></i>Jam Operasional</h5>
                            <p class="mb-0">Senin - Jumat: 07:00 - 15:00<br>
                            Sabtu: 07:00 - 12:00</p>
                        </div>
                    </div>

                    <!-- Map Section -->
                    <div class="map-section">
                        <h3 class="mb-4">
                            <i class="fas fa-map text-primary me-2"></i>
                            Lokasi Sekolah
                        </h3>
                        <div class="map-container" style="height: 400px; width: 100%;">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.325!2d106.797!3d-6.597!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5a123456789%3A0x1234567890abcdef!2sSMKN%204%20Bogor!5e0!3m2!1sen!2sid!4v1234567890123!5m2!1sen!2sid" 
                                width="100%" 
                                height="100%" 
                                style="border:0; border-radius: 8px;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3 class="mb-4">
                            <i class="fas fa-share-alt text-primary me-2"></i>
                            Media Sosial
                        </h3>
                        <div class="row justify-content-center">
                            <div class="col-md-4 col-6 mb-3 text-center">
                                <a href="https://www.facebook.com/people/SMK-NEGERI-4-KOTA-BOGOR/100054636630766" target="_blank" class="btn btn-primary btn-lg w-100">
                                    <i class="fab fa-facebook-f me-2"></i>
                                    Facebook
                                </a>
                            </div>
                            <div class="col-md-4 col-6 mb-3 text-center">
                                <a href="https://www.instagram.com/smkn4kotabogor/" target="_blank" class="btn btn-danger btn-lg w-100">
                                    <i class="fab fa-instagram me-2"></i>
                                    Instagram
                                </a>
                            </div>
                            <div class="col-md-4 col-6 mb-3 text-center">
                                <a href="https://www.youtube.com/@smknegeri4bogor905" target="_blank" class="btn btn-danger btn-lg w-100">
                                    <i class="fab fa-youtube me-2"></i>
                                    YouTube
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- School Profile -->
        @if($profile)
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="mb-4">
                    <i class="fas fa-school text-primary me-2"></i>
                    Profil Sekolah
                </h3>
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h4>
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            {{ $profile->judul }}
                        </h4>
                        <p class="mb-0">
                            <i class="fas fa-align-left me-2 text-muted"></i>
                            {{ $profile->isi }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>
</section>
@endsection
