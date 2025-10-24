<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SMKN 4 BOGOR')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* FORCE NAVBAR TO SHOW - OVERRIDE TAILWIND */
        nav.navbar {
            display: flex !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 9999 !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            padding: 10px 0 !important;
            margin: 0 !important;
            width: 100% !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1) !important;
        }
        
        nav.navbar .container {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            max-width: 1200px !important;
            margin: 0 auto !important;
            padding: 0 15px !important;
        }
        
        nav.navbar .navbar-brand {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            font-weight: 700 !important;
            font-size: 1.4rem !important;
            color: #333 !important;
            text-decoration: none !important;
            margin-right: auto !important;
        }
        
        nav.navbar .navbar-collapse {
            display: flex !important;
            flex-basis: auto !important;
            flex-grow: 1 !important;
            align-items: center !important;
        }
        
        nav.navbar .navbar-nav {
            display: flex !important;
            flex-direction: row !important;
            padding-left: 0 !important;
            margin-bottom: 0 !important;
            list-style: none !important;
            margin-left: auto !important;
        }
        
        nav.navbar .nav-item {
            display: inline-block !important;
        }
        
        nav.navbar .nav-link {
            display: block !important;
            color: #333 !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            margin: 0 8px !important;
            padding: 8px 16px !important;
            border-radius: 15px !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
        }
        
        nav.navbar .nav-link:hover,
        nav.navbar .nav-link.active {
            background-color: rgba(13, 110, 253, 0.1) !important;
            color: #0d6efd !important;
        }
        
        /* Reset all margins and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Ensure html and body take full height */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            padding: 0 !important;
            margin: 0;
        }
        
        /* Navbar styling */
        .navbar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            z-index: 9999 !important;
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            box-shadow: none !important;
            border-bottom: none !important;
            padding: 10px 0 !important;
            margin: 0 !important;
            width: 100% !important;
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: space-between !important;
        }
        
        /* Adjust main content to account for fixed navbar (dynamic) */
        :root { --navbar-h: 64px; }
        main {
            padding-top: calc(var(--navbar-h) + 16px);
            min-height: calc(100vh - 120px);
        }
        
        /* KECILKAN LAYOUT KOLOM */
        .container {
            max-width: 1000px !important;
        }
        
        .container-fluid {
            max-width: 1200px !important;
        }
        
        /* LAYOUT COMPACT */
        .row {
            margin-left: -8px;
            margin-right: -8px;
            margin-bottom: 0.5rem;
        }
        
        .row > * {
            padding-left: 8px;
            padding-right: 8px;
        }
        
        .g-4 {
            --bs-gutter-x: 0.75rem;
            --bs-gutter-y: 0.75rem;
        }
        
        .g-3 {
            --bs-gutter-x: 0.5rem;
            --bs-gutter-y: 0.5rem;
        }
        
        /* KECILKAN CARD SPACING */
        .card {
            margin-bottom: 8px;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        .card-header {
            padding: 0.75rem;
        }
        
        
        /* NAVBAR TRANSPARAN TOTAL - REMOVED CONFLICTING STYLES */
        
        .navbar-brand {
            font-weight: 700 !important;
            font-size: 1.4rem !important;
            color: #333 !important;
            text-transform: uppercase !important;
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            text-decoration: none !important;
            margin-right: auto !important;
        }
        
        .navbar .navbar-brand,
        .navbar .navbar-nav .nav-link {
            color: #333 !important;
        }
        
        .navbar .container {
            background: transparent !important;
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
            justify-content: space-between !important;
            width: 100% !important;
            max-width: 1200px !important;
            margin: 0 auto !important;
            padding: 0 15px !important;
        }
        
        .navbar-collapse {
            display: flex !important;
            flex-basis: auto !important;
            flex-grow: 1 !important;
            align-items: center !important;
        }
        
        .navbar-nav {
            display: flex !important;
            flex-direction: row !important;
            padding-left: 0 !important;
            margin-bottom: 0 !important;
            list-style: none !important;
        }
        
        /* REMOVED CONFLICTING TRANSPARENT STYLES */
        .school-logo {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .school-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 8px;
        }
        .navbar-nav .nav-link {
            color: #333 !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            margin: 0 8px !important;
            padding: 8px 16px !important;
            border-radius: 15px !important;
            transition: all 0.3s ease !important;
            text-decoration: none !important;
            display: block !important;
        }
        
        .nav-item {
            display: inline-block !important;
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd !important;
        }
        .navbar-toggler {
            border: 1px solid #ddd;
            padding: 4px 8px;
            background-color: #f8f9fa;
        }
        .navbar-toggler:focus {
            box-shadow: none;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%2851, 51, 51, 0.9%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 10px;
        }
        .dropdown-item:hover {
            background-color: #f8f9fa;
        }
        .login-btn {
            background: #f5f5f5 !important;
            color: #000 !important;
            border: none;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 600;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .login-btn:hover {
            background: #e0e0e0 !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .hero-section {
            color: inherit;
            padding: 20px 0;
            position: relative;
            overflow: hidden;
            height: auto;
            min-height: auto;
        }
        .hero-section--full {
            color: white;
            padding: 0;
            height: 100vh;
            min-height: 100vh;
            margin-top: -10px;
            padding-top: 10px;
        }
        .hero-background {
            position: relative;
            width: 100%;
            height: 100%;
        }
        .hero-slideshow {
            position: relative;
            width: 100%;
            height: 100%;
        }
        
        .hero-bg-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.8);
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }
        
        .hero-bg-image.active {
            opacity: 1;
        }
        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-overlay h3 {
            font-size: 1.8rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.7);
        }
        .hero-overlay p {
            font-size: 1rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.7);
        }
        .card {
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            margin-bottom: 8px;
            border-radius: 8px;
        }
        .card:hover {
            transform: translateY(-3px);
        }
        .card-body {
            padding: 0.75rem;
        }
        .section-padding {
            padding: 0.75rem 0;
        }
        
        /* KECILKAN SEMUA SECTION */
        section {
            padding: 1rem 0 !important;
        }
        
        .py-3 {
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }
        
        .py-4 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }
        
        .py-5 {
            padding-top: 1.25rem !important;
            padding-bottom: 1.25rem !important;
        }
        .section-title {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        
        h1 {
            font-size: 1.5rem !important;
            margin-bottom: 0.5rem !important;
        }
        
        h2 {
            font-size: 1.25rem !important;
            margin-bottom: 0.5rem !important;
        }
        
        h3 {
            font-size: 1.1rem !important;
            margin-bottom: 0.5rem !important;
        }
        
        h4 {
            font-size: 1rem !important;
            margin-bottom: 0.5rem !important;
        }
        
        h5 {
            font-size: 0.9rem !important;
            margin-bottom: 0.5rem !important;
        }
        
        h6 {
            font-size: 0.8rem !important;
            margin-bottom: 0.5rem !important;
        }
        
        .lead {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        .btn-medium {
            padding: 0.5rem 1.5rem;
            font-size: 0.9rem;
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 50px 0 20px;
        }
        
        /* Quick Access Section Styles */
        .quick-access-card {
            padding: 2rem 1rem;
            border-radius: 15px;
            background: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .quick-access-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: var(--bs-primary);
        }
        
        .quick-access-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            font-size: 2rem;
            color: white;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .quick-access-card:hover .quick-access-icon {
            transform: scale(1.1);
        }
        
        /* Jurusan Card Styles */
        .jurusan-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 2px solid transparent;
            overflow: hidden;
        }
        
        .jurusan-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            border-color: var(--bs-primary);
        }
        
        .jurusan-image {
            position: relative;
            overflow: hidden;
            height: 200px;
        }
        
        .jurusan-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .jurusan-card:hover .jurusan-image img {
            transform: scale(1.1);
        }
        
        .jurusan-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(227, 242, 253, 0.9) 0%, rgba(187, 222, 251, 0.9) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .jurusan-card:hover .jurusan-overlay {
            opacity: 1;
        }
        
        .jurusan-icon {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--bs-primary);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        
        .jurusan-content {
            padding: 1.5rem;
        }
        
        .jurusan-content h5 {
            color: var(--bs-primary);
            font-weight: 700;
        }
        
        .jurusan-content .btn {
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .jurusan-content .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Smooth scrolling site-wide */
        html { scroll-behavior: smooth; }
        @media (prefers-reduced-motion: reduce) {
            html { scroll-behavior: auto; }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <div class="school-logo">
                    <img src="{{ asset('images/logo smkn 4.png') }}" alt="Logo SMKN 4 BOGOR">
                </div>
                <span>SMKN 4 BOGOR</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <span class="nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </span>
                            Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('galeri') ? 'active' : '' }}" href="{{ route('galeri') }}">
                            <span class="nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                    <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                    <polyline points="21 15 16 10 5 21"></polyline>
                                </svg>
                            </span>
                            Galeri
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('agenda.*') ? 'active' : '' }}" href="{{ route('agenda.index') }}">
                            <span class="nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </span>
                            Agenda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('informasi.*') ? 'active' : '' }}" href="{{ route('informasi.index') }}">
                            <span class="nav-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                                    <polyline points="14,2 14,8 20,8"></polyline>
                                    <line x1="16" y1="13" x2="8" y2="13"></line>
                                    <line x1="16" y1="17" x2="8" y2="17"></line>
                                    <polyline points="10,9 9,9 8,9"></polyline>
                                </svg>
                            </span>
                            Informasi
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-graduation-cap me-2"></i>SMKN 4 BOGOR</h5>
                    <p class="mt-3">Website galeri sekolah yang menampilkan berbagai kegiatan, prestasi, dan informasi terkini tentang sekolah kami.</p>
                </div>
                <div class="col-md-4">
                    <h5><i class="fas fa-info-circle me-2"></i>Informasi Kontak</h5>
                    <ul class="list-unstyled mt-3">
                        <li><i class="fas fa-map-marker-alt me-2"></i>Jl. Raya Tajur, Muarasari, Bogor Selatan, Kota Bogor, 
                        Jawa Barat, 16137</li>
                        <li><i class="fas fa-phone me-2"></i>(0251) 7547-381</li>
                        <li><i class="fas fa-envelope me-2"></i>info@smkn4bogor.sch.id</li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5><i class="fas fa-share-alt me-2"></i>Media Sosial</h5>
                    <div class="mt-3">
                        <a href="https://www.facebook.com/people/SMK-NEGERI-4-KOTA-BOGOR/100054636630766" target="_blank" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="https://www.instagram.com/smkn4kotabogor/" target="_blank" class="text-white me-3"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="https://www.youtube.com/@smknegeri4bogor905" target="_blank" class="text-white me-3"><i class="fab fa-youtube fa-2x"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} SMKN 4 BOGOR. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Smooth Scrolling Script -->
    <script>
        function openModal(modalId) {
            const modal = new bootstrap.Modal(document.getElementById(modalId));
            modal.show();
        }
        
        // Hero Slideshow Function
        function initHeroSlideshow() {
            const images = document.querySelectorAll('.hero-bg-image');
            if (images.length === 0) return;
            
            let currentIndex = 0;
            
            function nextSlide() {
                // Remove active class from current image
                images[currentIndex].classList.remove('active');
                
                // Move to next image
                currentIndex = (currentIndex + 1) % images.length;
                
                // Add active class to new image
                images[currentIndex].classList.add('active');
            }
            
            // Start slideshow every 3 seconds
            setInterval(nextSlide, 3000);
        }
        
        // Smooth scrolling and active navigation
        function initSmoothScrolling() {
            const navLinks = document.querySelectorAll('a[href^="#"]');
            
            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    
                    if (targetElement) {
                        // Update active nav link
                        document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));
                        this.classList.add('active');
                        
                        // Smooth scroll to target with navbar offset
                        const navbarHeight = document.querySelector('.navbar').offsetHeight;
                        const targetPosition = targetElement.offsetTop - navbarHeight - 20;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                        
                        // Update URL hash
                        history.pushState(null, null, '#' + targetId);
                    }
                });
            });
        }
        
        // Update active navigation based on scroll position
        function initScrollSpy() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link[href^="#"]');
            
            function updateActiveNav() {
                let current = '';
                
                sections.forEach(section => {
                    const sectionTop = section.offsetTop - 100;
                    const sectionHeight = section.offsetHeight;
                    
                    if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                        current = section.getAttribute('id');
                    }
                });
                
                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            }
            
            window.addEventListener('scroll', updateActiveNav);
            updateActiveNav(); // Initial call
        }
        
        function setNavbarOffset() {
            const nav = document.querySelector('.navbar');
            if (!nav) return;
            const h = nav.offsetHeight || 64;
            document.documentElement.style.setProperty('--navbar-h', h + 'px');
        }

        // FORCE NAVBAR TO SHOW IMMEDIATELY
        function forceNavbarShow() {
            const navbar = document.querySelector('nav.navbar');
            if (navbar) {
                navbar.style.display = 'flex';
                navbar.style.position = 'fixed';
                navbar.style.top = '0';
                navbar.style.left = '0';
                navbar.style.right = '0';
                navbar.style.zIndex = '9999';
                navbar.style.background = 'rgba(255, 255, 255, 0.95)';
                navbar.style.backdropFilter = 'blur(10px)';
                navbar.style.padding = '10px 0';
                navbar.style.width = '100%';
                navbar.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
                
                // Force container
                const container = navbar.querySelector('.container');
                if (container) {
                    container.style.display = 'flex';
                    container.style.alignItems = 'center';
                    container.style.justifyContent = 'space-between';
                    container.style.width = '100%';
                    container.style.maxWidth = '1200px';
                    container.style.margin = '0 auto';
                    container.style.padding = '0 15px';
                }
                
                // Force navbar brand
                const brand = navbar.querySelector('.navbar-brand');
                if (brand) {
                    brand.style.display = 'flex';
                    brand.style.alignItems = 'center';
                    brand.style.gap = '12px';
                    brand.style.fontWeight = '700';
                    brand.style.fontSize = '1.4rem';
                    brand.style.color = '#333';
                    brand.style.textDecoration = 'none';
                    brand.style.marginRight = 'auto';
                }
                
                // Force navbar collapse
                const collapse = navbar.querySelector('.navbar-collapse');
                if (collapse) {
                    collapse.style.display = 'flex';
                    collapse.style.flexBasis = 'auto';
                    collapse.style.flexGrow = '1';
                    collapse.style.alignItems = 'center';
                }
                
                // Force navbar nav
                const nav = navbar.querySelector('.navbar-nav');
                if (nav) {
                    nav.style.display = 'flex';
                    nav.style.flexDirection = 'row';
                    nav.style.paddingLeft = '0';
                    nav.style.marginBottom = '0';
                    nav.style.listStyle = 'none';
                    nav.style.marginLeft = 'auto';
                }
                
                // Force nav items
                const navItems = navbar.querySelectorAll('.nav-item');
                navItems.forEach(item => {
                    item.style.display = 'inline-block';
                });
                
                // Force nav links
                const navLinks = navbar.querySelectorAll('.nav-link');
                navLinks.forEach(link => {
                    link.style.display = 'block';
                    link.style.color = '#333';
                    link.style.fontWeight = '600';
                    link.style.fontSize = '14px';
                    link.style.margin = '0 8px';
                    link.style.padding = '8px 16px';
                    link.style.borderRadius = '15px';
                    link.style.textDecoration = 'none';
                    link.style.transition = 'all 0.3s ease';
                });
            }
        }
        
        // Run immediately
        forceNavbarShow();
        
        // Run on DOM ready
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, setting up smooth scrolling...');
            
            // Force navbar again
            forceNavbarShow();
            
            // Initialize hero slideshow
            initHeroSlideshow();
            
            // Initialize smooth scrolling
            initSmoothScrolling();
            
            // Initialize scroll spy
            initScrollSpy();
            
            // Ensure main offset respects fixed navbar height
            setNavbarOffset();
            window.addEventListener('resize', setNavbarOffset, { passive: true });
            
            // Handle anchor links on page load
            if (window.location.hash) {
                const target = document.querySelector(window.location.hash);
                if (target) {
                    setTimeout(() => {
                        setNavbarOffset();
                        const navbarHeight = document.querySelector('.navbar').offsetHeight;
                        const targetPosition = target.offsetTop - navbarHeight - 20;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }, 500);
                }
            }
        });
    </script>
    
    @yield('scripts')
    
    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1090;"></div>
</body>
</html>
