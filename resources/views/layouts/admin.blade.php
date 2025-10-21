<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - Galeri Sekolah')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.ico') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            /* Theme colors */
            --blue-dark: #1a2b6b;   /* sidebar/navbar bg - dark blue */
            --blue-medium: #3b82f6; /* active/hover - royal blue */
            --cyan: #00bfff;        /* icons/primary buttons/accents - sky blue */
            --text-dark: #333333;   /* body text */
            --card-bg: #FFFFFF;     /* cards/content background */

            /* Sidebar tokens */
            --sidebar-bg: #FFFFFF;
            --sidebar-text: #333333;
            --sidebar-text-muted: #666666;
            --sidebar-hover: rgba(59, 130, 246, 0.1); /* light blue tint */
            --sidebar-active: var(--blue-medium);
            --sidebar-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --sidebar-width: 220px;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #F5F8FF;
            min-height: 100vh;
            overflow-x: hidden;
            max-width: 100%;
            color: var(--text-dark);
        }

        /* Prevent horizontal scroll globally */
        * {
            box-sizing: border-box;
        }

        .container-fluid {
            max-width: 100%;
            overflow-x: hidden;
            padding-left: 10px;
            padding-right: 10px;
        }

        .row {
            margin-left: 0;
            margin-right: 0;
            max-width: 100%;
        }

        .col, .col-1, .col-2, .col-3, .col-4, .col-5, .col-6, 
        .col-7, .col-8, .col-9, .col-10, .col-11, .col-12,
        .col-sm, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6,
        .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12,
        .col-md, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6,
        .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12,
        .col-lg, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6,
        .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12,
        .col-xl, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6,
        .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12 {
            padding-left: 5px;
            padding-right: 5px;
            max-width: 100%;
        }

        .sidebar {
            min-height: 100vh;
            background: var(--sidebar-bg);
            color: var(--sidebar-text);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1040;
            overflow-y: auto;
            width: var(--sidebar-width);
            box-shadow: var(--sidebar-shadow);
            border-right: 1px solid #e2e8f0;
            padding: 1.5rem 0;
        }
        
        @media (max-width: 767.98px) {
            .sidebar {
                width: 200px;
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            .sidebar.show {
                transform: translateX(0);
            }
        }

        .sidebar-header {
            padding: 0 1rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
            margin-bottom: 1rem;
        }

        .sidebar-logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
        }

        .sidebar-logo-icon {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 0.5rem;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 12px;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-logo-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-3px); }
        }

        .sidebar-logo-icon i {
            font-size: 1.2rem;
            color: var(--cyan);
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--sidebar-text);
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .sidebar-subtitle {
            font-size: 0.75rem;
            color: var(--sidebar-text-muted);
            margin: 0.25rem 0 0 0;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            padding: 1rem 0.75rem;
        }

        .nav-link {
            padding: 0.8rem 1.5rem;
            color: var(--sidebar-text);
            display: flex;
            align-items: center;
            font-weight: 500;
            text-decoration: none;
            border: none;
            font-size: 0.9rem;
            white-space: nowrap;
            border-radius: 8px;
            margin: 0.2rem 0.75rem;
            transition: all 200ms ease;
            position: relative;
        }

        .nav-link::before {
            display: none;
        }

        .nav-link:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text);
            transform: translateX(2px);
        }

        .nav-link.active {
            background: var(--sidebar-active);
            color: #FFFFFF;
            font-weight: 600;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .nav-link i {
            font-size: 1.1rem;
            margin-right: 0.8rem;
            width: 20px;
            text-align: center;
            color: var(--cyan);
            transition: all 0.2s ease;
        }

        .nav-link:hover i {
            color: var(--cyan);
        }

        .nav-link.active i { 
            color: #FFFFFF; 
        }

        .main-content {
            margin-left: var(--sidebar-width);
            transition: margin-left 0.3s ease;
            width: calc(100% - var(--sidebar-width));
            max-width: calc(100% - var(--sidebar-width));
            overflow-x: hidden;
            padding: 80px 20px 20px 20px;
            position: relative;
            background: transparent;
            min-height: 100vh;
        }
        
        @media (max-width: 767.98px) {
            .main-content {
                margin-left: var(--sidebar-width);
                padding: 1.5rem;
                transition: all 0.3s ease;
                min-height: 100vh;
                position: relative;
                overflow: visible;
            }
        }

        .card {
            border: none;
            background: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 16px 30px rgba(26, 61, 156, 0.08);
            max-width: 100%;
            overflow: hidden;
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .card:hover { transform: translateY(-2px); box-shadow: 0 22px 40px rgba(26, 61, 156, 0.14); }

        /* Ensure all elements don't overflow */
        .table-responsive {
            max-width: 100%;
            overflow-x: auto;
        }

        .table {
            max-width: 100%;
            table-layout: fixed;
        }

        .btn {
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .form-control, .form-select {
            max-width: 100%;
        }

        .alert {
            max-width: 100%;
            word-wrap: break-word;
        }

        .navbar {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.85);
            border-bottom: 1px solid rgba(26, 61, 156, 0.08);
            padding: 0.5rem 1.5rem;
            position: fixed;
            top: 0;
            right: 0;
            left: var(--sidebar-width);
            z-index: 1030;
            height: 60px;
            margin: 0;
            width: calc(100% - var(--sidebar-width));
            transition: background-color 0.3s ease;
        }
        
        .navbar:hover {
            background: rgba(255, 255, 255, 0.9);
        }
        
        @media (max-width: 767.98px) {
            .navbar {
                left: 0;
                width: 100%;
                max-width: 100%;
                height: 60px;
                padding: 0.4rem 0.8rem;
            }
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--blue-dark);
            font-size: 1.25rem;
            margin: 0;
        }

        .navbar-text {
            color: var(--text-dark);
            font-weight: 500;
            font-size: 0.9rem;
            margin: 0;
        }

        .navbar-nav {
            align-items: center;
        }

        .page-content {
            padding: 1rem 1.5rem;
            max-width: 100%;
            overflow-x: hidden;
        }

        @media (max-width: 767.98px) {
            .page-content {
                padding: 0.75rem 1rem;
            }
        }

        @media (max-width: 576px) {
            .page-content {
                padding: 0.5rem 0.75rem;
            }
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.4);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover { 
            background: rgba(59, 130, 246, 0.6); 
        }

        /* Mobile Toggle Button */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1050;
            background: var(--blue-medium);
            border: none;
            border-radius: 10px;
            color: #fff;
            padding: 0.5rem 0.6rem;
            box-shadow: 0 10px 24px rgba(46, 99, 246, 0.35);
            transition: transform 180ms ease, box-shadow 180ms ease;
        }

        .sidebar-toggle:hover { transform: translateY(-1px); box-shadow: 0 14px 30px rgba(46, 99, 246, 0.45); }

        @media (max-width: 767.98px) {
            .sidebar-toggle {
                display: block;
                top: 0.75rem;
                left: 0.75rem;
            }
        }
    </style>
    
    @yield('styles')
    @stack('styles')
</head>
<body>
    <!-- Mobile Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <div class="sidebar-logo">
                        <div class="sidebar-logo-icon">
                            <img src="{{ asset('images/logo smkn 4.png') }}" alt="SMKN 4 Logo" style="width: 50px; height: 50px; object-fit: contain;">
                        </div>
                        <div>
                            <h4 class="sidebar-title">SMKN 4 BOGOR</h4>
                            <p class="sidebar-subtitle">Admin Panel</p>
                        </div>
                    </div>
                </div>
                
                <nav class="sidebar-nav">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <a class="nav-link {{ request()->routeIs('admin.petugas.*') ? 'active' : '' }}" href="{{ route('admin.petugas.index') }}">
                        <i class="fas fa-users"></i>
                        <span>Kelola Petugas</span>
                    </a>
                    
                    <a class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}" href="{{ route('admin.kategori.index') }}">
                        <i class="fas fa-tags"></i>
                        <span>Kelola Kategori</span>
                    </a>
                    
                    <a class="nav-link {{ request()->routeIs('admin.fotos.*') ? 'active' : '' }}" href="{{ route('admin.fotos.index') }}">
                        <i class="fas fa-images"></i>
                        <span>Kelola Galeri</span>
                    </a>
                    
                    <a class="nav-link {{ request()->routeIs('admin.reports.gallery') || request()->routeIs('admin.reports.gallery.index') ? 'active' : '' }}" href="{{ route('admin.reports.gallery.index') }}">
                        <i class="fas fa-chart-pie"></i>
                        <span>Laporan Galeri</span>
                    </a>
                    
                    <a class="nav-link {{ request()->routeIs('admin.comments.moderation') ? 'active' : '' }}" href="{{ route('admin.comments.moderation') }}">
                        <i class="fas fa-comments"></i>
                        <span>Moderasi Komentar</span>
                    </a>
                    
                    <a class="nav-link {{ request()->routeIs('admin.agenda.*') ? 'active' : '' }}" href="{{ route('admin.agenda.index') }}">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Kelola Agenda</span>
                    </a>
                    
                    <a class="nav-link" href="{{ route('admin.logout') }}" onclick="return confirm('Yakin ingin logout?')">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        <span class="navbar-brand mb-0 h1">@yield('page-title', 'Dashboard')</span>
                        <div class="navbar-nav ms-auto">
                            <span class="navbar-text">
                                <i class="fas fa-user me-2"></i>
                                {{ Session::get('admin_username') }}
                            </span>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <div class="page-content">

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mobile Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
                
                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function(event) {
                    if (window.innerWidth <= 767.98) {
                        if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                            sidebar.classList.remove('show');
                        }
                    }
                });
                
                // Close sidebar when window is resized to desktop
                window.addEventListener('resize', function() {
                    if (window.innerWidth > 767.98) {
                        sidebar.classList.remove('show');
                    }
                });
            }
        });
    </script>
    
    @yield('scripts')
    @stack('scripts')
</body>
</html>


