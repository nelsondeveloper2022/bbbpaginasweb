<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard - BBB Páginas Web')</title>
    <meta name="description" content="@yield('description', 'Panel de control BBB Páginas Web')">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bbb.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo-bbb.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-red: #d22e23;
            --primary-gold: #f0ac21;
            --dark-bg: #2c3e50;
            --light-gray: #f8f9fa;
            --medium-gray: #6c757d;
            --white: #ffffff;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(135deg, var(--dark-bg) 0%, #34495e 100%);
            color: white;
            z-index: 1000;
            transition: all 0.3s ease;
            border-right: 3px solid var(--primary-gold);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .sidebar-header {
            padding: 1.5rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .sidebar-header .logo {
            height: 40px;
            width: auto;
            margin-bottom: 0.5rem;
        }

        .sidebar-header h4 {
            color: var(--primary-gold);
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }

        .sidebar-header .brand-text {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 500;
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .sidebar-nav {
            padding: 1rem 0;
            flex-grow: 1;
        }

        .nav-item {
            margin: 0.25rem 0;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.25rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-gold);
            background: rgba(240, 172, 33, 0.1);
            border-right: 3px solid var(--primary-gold);
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 1.1rem;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: var(--primary-gold);
            border-radius: 0 2px 2px 0;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            padding: 0;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        }

        .top-bar .user-menu {
            display: flex;
            align-items: center;
            margin-left: auto;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-red), var(--primary-gold));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 0.75rem;
        }

        .user-info h6 {
            margin: 0;
            color: #333;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .user-info small {
            color: var(--medium-gray);
            font-size: 0.8rem;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            border-radius: 8px;
            min-width: 200px;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(240, 172, 33, 0.1);
            color: var(--primary-gold);
        }

        .dropdown-item i {
            width: 20px;
            margin-right: 8px;
        }

        /* Content Area */
        .content-area {
            padding: 2rem 1.5rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            color: var(--dark-bg);
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
        }

        .page-subtitle {
            color: var(--medium-gray);
            margin-top: 0.25rem;
            font-size: 0.95rem;
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f0f0f0;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--dark-bg);
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Trial Badge */
        .trial-badge {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .trial-badge.expired {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        .trial-badge.warning {
            background: linear-gradient(135deg, #ffc107, #e0a800);
            color: #212529;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-area {
                padding: 1rem;
            }

            .top-bar {
                padding: 0.75rem 1rem;
            }
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            background: var(--primary-gold);
            border: none;
            color: var(--dark-bg);
            padding: 0.5rem;
            border-radius: 6px;
            margin-right: 1rem;
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
        }

        /* Utility Classes */
        .text-primary-red { color: var(--primary-red) !important; }
        .text-primary-gold { color: var(--primary-gold) !important; }
        .bg-primary-red { background-color: var(--primary-red) !important; }
        .bg-primary-gold { background-color: var(--primary-gold) !important; }

        /* Buttons */
        .btn-primary-gold {
            background: var(--primary-gold);
            border: none;
            color: var(--dark-bg);
            font-weight: 600;
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary-gold:hover {
            background: #e09a1d;
            color: var(--dark-bg);
            transform: translateY(-1px);
        }

        .btn-outline-primary-gold {
            border: 2px solid var(--primary-gold);
            color: var(--primary-gold);
            background: transparent;
            font-weight: 600;
            padding: 0.6rem 1.25rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary-gold:hover {
            background: var(--primary-gold);
            color: var(--dark-bg);
        }

        /* Additional Styles */
        .btn-warning {
            background: linear-gradient(45deg, #f39c12, #e67e22);
            border: none;
            border-radius: 10px;
            color: white;
        }

        .btn-warning:hover {
            background: linear-gradient(45deg, #e67e22, #d35400);
            color: white;
        }

        .stat-card {
            background: linear-gradient(135deg, #fff, #f8f9fa);
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .trial-alert {
            border-left: 5px solid #f39c12;
            background: rgba(243, 156, 18, 0.1);
        }

        .expired-alert {
            border-left: 5px solid var(--primary-red);
            background: rgba(210, 46, 35, 0.1);
        }

        /* Sidebar User Section */
        .sidebar-user-section {
            padding: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            flex-shrink: 0;
        }

        .sidebar-divider {
            border-color: rgba(255, 255, 255, 0.1);
            margin: 0 0 1rem 0;
        }

        .user-profile-card {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
        }

        .user-avatar-sidebar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-red), var(--primary-gold));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 1.2rem;
            margin-right: 0.75rem;
            flex-shrink: 0;
        }

        .user-details {
            flex-grow: 1;
            min-width: 0;
        }

        .user-name {
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 0 0 0.25rem 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-email {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.75rem;
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .trial-badge-sidebar {
            background: var(--primary-gold);
            color: var(--dark-bg);
            padding: 0.2rem 0.5rem;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 0.5rem;
            display: inline-block;
        }

        .sidebar-actions {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .sidebar-action-btn {
            display: flex;
            align-items: center;
            padding: 0.6rem 0.75rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .sidebar-action-btn:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--primary-gold);
        }

        .sidebar-action-btn.logout-btn:hover {
            background: rgba(220, 53, 69, 0.2);
            color: #ff6b6b;
        }

        .sidebar-action-btn i {
            width: 16px;
            margin-right: 0.5rem;
            font-size: 0.9rem;
        }

        /* Responsive improvements for better space utilization */
        @media (min-width: 1200px) {
            .col-xl-3 {
                flex: 0 0 auto;
                width: 23%;
            }
        }

        /* Enhanced header with action buttons */
        .content-header {
            background: linear-gradient(135deg, rgba(210, 46, 35, 0.05), rgba(240, 172, 33, 0.05));
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .dashboard-title {
            color: var(--dark-bg);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        /* Plan badge improvements */
        .plan-badge {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .plan-badge.active {
            background: linear-gradient(135deg, var(--primary-gold), #ffd700);
            color: var(--dark-bg);
        }

        .plan-badge.expired {
            background: linear-gradient(135deg, var(--primary-red), #dc3545);
            color: white;
        }

        /* Disabled nav links */
        .nav-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: auto; /* Allow click for custom handler */
            background: rgba(220, 53, 69, 0.1) !important;
            border-left: 3px solid #dc3545;
            position: relative;
        }

        .nav-link.disabled:hover {
            background: rgba(220, 53, 69, 0.15) !important;
            transform: none;
        }

        .nav-link.disabled span {
            text-decoration: line-through;
        }

        /* Info Group Styles */
        .info-group {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f3f4;
            transition: all 0.3s ease;
        }

        .info-group:last-child {
            border-bottom: none;
        }

        .info-group:hover {
            background-color: rgba(240, 172, 33, 0.03);
            border-radius: 6px;
            margin: 0.75rem -0.5rem;
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid transparent;
        }

        .info-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.4rem;
            display: block;
        }

        .info-value {
            font-size: 0.95rem;
            color: #495057;
            font-weight: 500;
            line-height: 1.4;
            word-wrap: break-word;
        }

        .info-value strong {
            color: #212529;
            font-weight: 600;
        }

        .info-value code {
            font-size: 0.85rem;
            color: var(--primary-red);
            background-color: #f8f9fa !important;
            border: 1px solid #e9ecef;
        }

        .info-value .badge {
            font-size: 0.7rem;
            padding: 0.35em 0.6em;
        }

        .info-value .social-links a {
            font-size: 1.2rem;
            transition: transform 0.2s ease;
        }

        .info-value .social-links a:hover {
            transform: scale(1.2);
        }

        /* Profile completion progress */
        .profile-completion {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .profile-completion .progress {
            flex-grow: 1;
            height: 6px;
            background-color: #e9ecef;
            border-radius: 3px;
        }

        .profile-completion .progress-bar {
            border-radius: 3px;
        }

        /* Section dividers */
        .mb-4 h6.fw-bold {
            position: relative;
            padding-bottom: 0.5rem;
            margin-bottom: 1rem;
        }

        .mb-4 h6.fw-bold::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 2px;
            background: linear-gradient(90deg, var(--primary-gold), var(--primary-red));
            border-radius: 1px;
        }

        /* Card enhancements */
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            border-radius: 12px;
        }

        .card-header {
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
            border-bottom: 1px solid #e9ecef;
            border-radius: 12px 12px 0 0 !important;
        }

        /* Mobile responsiveness improvements */
        @media (max-width: 768px) {
            .info-group {
                padding: 0.5rem 0;
            }
            
            .info-label {
                font-size: 0.75rem;
            }
            
            .info-value {
                font-size: 0.9rem;
            }
            
            .profile-completion {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }
        }

        /* Toast notifications styles */
        .colored-toast.swal2-toast {
            background: linear-gradient(135deg, #28a745, #20c997) !important;
            color: white !important;
            border: none !important;
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3) !important;
        }

        .colored-toast.swal2-toast .swal2-title {
            color: white !important;
            font-weight: 600 !important;
        }

        .colored-toast.swal2-toast .swal2-icon {
            border: 2px solid white !important;
            color: white !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB Logo" class="logo">
            <h4>BBB Dashboard</h4>
            <div class="brand-text">Sistema de Gestión</div>
        </div>
        
        @php
            $user = auth()->user();
            $isLicenseExpired = $user->trial_ends_at && $user->trial_ends_at->isPast();
            $isTrialExpired = $user->trial_ends_at && $user->trial_ends_at->isPast();
            $hasActiveLicense = $user->hasActiveLicense();
            
            // Verificar si el plan actual permite productos
            $planPermiteProductos = false;
            if ($user->plan && $user->plan->aplicaProductos) {
                $planPermiteProductos = true;
            }
        @endphp
        
        <ul class="sidebar-nav list-unstyled">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                @if($isLicenseExpired)
                    <a href="#" class="nav-link disabled" onclick="showLicenseExpiredMessage(); return false;" title="Licencia vencida - Gestiona tu plan para acceder">
                        <i class="bi bi-palette"></i>
                        <span>Configura tu Landing</span>
                        <i class="bi bi-lock-fill ms-auto text-danger" style="font-size: 0.8rem;"></i>
                    </a>
                @else
                    <a href="{{ route('admin.landing.configurar') }}" class="nav-link {{ Request::routeIs('admin.landing.*') ? 'active' : '' }}">
                        <i class="bi bi-palette"></i>
                        <span>Configura tu Landing</span>
                    </a>
                @endif
            </li>
            
            <!-- Módulo de Clientes -->
            @if($planPermiteProductos)
            <li class="nav-item">
                @if($isTrialExpired && !$hasActiveLicense)
                    <a href="#" class="nav-link disabled" onclick="showTrialExpiredMessage(); return false;" title="Trial vencido - Gestiona tu plan para acceder">
                        <i class="bi bi-people"></i>
                        <span>Clientes</span>
                        <i class="bi bi-lock-fill ms-auto text-danger" style="font-size: 0.8rem;"></i>
                    </a>
                @else
                    <a href="{{ route('admin.clientes.index') }}" class="nav-link {{ Request::routeIs('admin.clientes.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span>Clientes</span>
                        @php
                            $clientesCount = Auth::user()->empresa ? App\Models\BbbCliente::forEmpresa(Auth::user()->empresa->idEmpresa)->count() : 0;
                        @endphp
                        @if($clientesCount > 0)
                            <span class="badge bg-primary ms-auto">{{ $clientesCount }}</span>
                        @endif
                    </a>
                @endif
            </li>
            @endif
            
            <!-- Módulo de Productos -->
            @if($planPermiteProductos)
            <li class="nav-item">
                @if($isLicenseExpired)
                    <a href="#" class="nav-link disabled" onclick="showLicenseExpiredMessage(); return false;" title="Licencia vencida - Gestiona tu plan para acceder">
                        <i class="bi bi-box-seam"></i>
                        <span>Productos</span>
                        <i class="bi bi-lock-fill ms-auto text-danger" style="font-size: 0.8rem;"></i>
                    </a>
                @else
                    <a href="{{ route('admin.productos.index') }}" class="nav-link {{ Request::routeIs('admin.productos.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam"></i>
                        <span>Productos</span>
                    </a>
                @endif
            </li>
            @endif
            
            <!-- Módulo de Ventas Online -->
            @if($planPermiteProductos)
            <li class="nav-item">
                @if($isLicenseExpired)
                    <a href="#" class="nav-link disabled" onclick="showLicenseExpiredMessage(); return false;" title="Licencia vencida - Gestiona tu plan para acceder">
                        <i class="bi bi-cart-check"></i>
                        <span>Ventas Online</span>
                        <i class="bi bi-lock-fill ms-auto text-danger" style="font-size: 0.8rem;"></i>
                    </a>
                @else
                    <a href="{{ route('admin.ventas.index') }}" class="nav-link {{ Request::routeIs('admin.ventas.*') ? 'active' : '' }}">
                        <i class="bi bi-cart-check"></i>
                        <span>Ventas Online</span>
                    </a>
                @endif
            </li>
            @endif
            
            <!-- Módulo de Configuración de Pagos Wompi -->
            @if($planPermiteProductos)
            <li class="nav-item">
                @if($isLicenseExpired)
                    <a href="#" class="nav-link disabled" onclick="showLicenseExpiredMessage(); return false;" title="Licencia vencida - Gestiona tu plan para acceder">
                        <i class="bi bi-credit-card-2-back"></i>
                        <span>Configuración de Pagos</span>
                        <i class="bi bi-lock-fill ms-auto text-danger" style="font-size: 0.8rem;"></i>
                    </a>
                @else
                    <a href="{{ route('admin.pagos.index') }}" class="nav-link {{ Request::routeIs('admin.pagos.*') ? 'active' : '' }}">
                        <i class="bi bi-credit-card-2-back"></i>
                        <span>Configuración de Pagos</span>
                    </a>
                @endif
            </li>
            @endif
            
            <li class="nav-item">
                @if($isLicenseExpired)
                    <a href="#" class="nav-link disabled" onclick="showLicenseExpiredMessage(); return false;" title="Licencia vencida - Gestiona tu plan para acceder">
                        <i class="bi bi-building-gear"></i>
                        <span>Perfil y Empresa</span>
                        <i class="bi bi-lock-fill ms-auto text-danger" style="font-size: 0.8rem;"></i>
                    </a>
                @else
                    <a href="{{ route('admin.profile.edit') }}" class="nav-link {{ Request::routeIs('admin.profile.*') ? 'active' : '' }}">
                        <i class="bi bi-building-gear"></i>
                        <span>Perfil y Empresa</span>
                    </a>
                @endif
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.plans.index') }}" class="nav-link {{ Request::routeIs('admin.plans.*') ? 'active' : '' }}">
                    <i class="bi bi-credit-card-2-front"></i>
                    <span>Gestionar Plan</span>
                    @if($isLicenseExpired)
                        <span class="badge bg-danger ms-auto" style="font-size: 0.65rem;">¡Requerido!</span>
                    @endif
                </a>
            </li>
            
            <!-- Separador para ayuda -->
            <li class="nav-divider my-3">
                <hr class="sidebar-divider" style="border-color: rgba(255,255,255,0.2);">
            </li>
            
            <!-- BBB Academy -->
            <li class="nav-item">
                <a href="{{ route('admin.documentation.index') }}" class="nav-link {{ Request::routeIs('admin.documentation.*') ? 'active' : '' }}" 
                   style="background: rgba(102, 126, 234, 0.1); border-left: 3px solid #667eea;">
                    <i class="bi bi-mortarboard-fill text-primary"></i>
                    <span>BBB Academy</span>
                    <span class="badge bg-primary ms-auto" style="font-size: 0.6rem;">NUEVO</span>
                </a>
            </li>
            
            <li class="nav-item">
                @php
                    $empresaSlug = auth()->user()->empresa?->slug ?? 'sin-empresa';
                    $whatsappMessage = "Hola, necesito ayuda con mi cuenta de BBB Páginas Web. Mi empresa es: " . $empresaSlug;
                @endphp
                <a href="https://wa.me/{{ config('app.support.mobile') }}?text={{ urlencode($whatsappMessage) }}" 
                   target="_blank" 
                   class="nav-link text-success" 
                   style="background: rgba(37, 211, 102, 0.1);">
                    <i class="bi bi-whatsapp"></i>
                    <span>Ayuda por WhatsApp</span>
                    <i class="bi bi-box-arrow-up-right ms-auto" style="font-size: 0.8rem;"></i>
                </a>
            </li>
            
            <li class="nav-item">
                @php
                    $soporteMessage = "Hola, necesito soporte técnico para BBB Páginas Web. Mi empresa es: " . $empresaSlug;
                @endphp
                <a href="https://wa.me/{{ config('app.support.mobile') }}?text={{ urlencode($soporteMessage) }}" 
                   target="_blank" 
                   class="nav-link text-info" 
                   style="background: rgba(13, 202, 240, 0.1);">
                    <i class="bi bi-headset"></i>
                    <span>Soporte Técnico</span>
                    <i class="bi bi-box-arrow-up-right ms-auto" style="font-size: 0.8rem;"></i>
                </a>
            </li>

        </ul>

        <!-- User Profile Section at Bottom -->
        <div class="sidebar-user-section">
            <hr class="sidebar-divider">
            
            <!-- Admin Impersonation indicator -->
            @if(session('impersonating_admin_id'))
                <div class="alert alert-warning alert-sm mb-2 p-2" style="font-size: 0.8rem;">
                    <i class="fas fa-user-shield me-1"></i>
                    <strong>Modo Admin</strong>
                    <br><small>Admin: {{ session('impersonating_admin_name', 'Administrador') }}</small>
                </div>
            @endif
            
            <div class="user-profile-card">
                <div class="user-avatar-sidebar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="user-details">
                    <h6 class="user-name">
                        {{ auth()->user()->name }}
                        @if(session('impersonating_admin_id'))
                            <i class="fas fa-eye text-warning ms-1" title="Vista como cliente"></i>
                        @endif
                    </h6>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                    @if(auth()->user()->empresa && auth()->user()->empresa->nombre)
                        <div class="user-company text-warning">
                            <i class="bi bi-building"></i> {{ auth()->user()->empresa->nombre }}
                        </div>
                    @endif
                    @if(auth()->user()->isOnTrial())
                        <div class="trial-badge-sidebar">
                            <i class="bi bi-gift"></i> Prueba Gratuita
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="sidebar-actions">
                @if(session('impersonating_admin_id'))
                    <a href="{{ route('admin.stop-impersonating') }}" class="sidebar-action-btn mb-2" style="background: #f39c12; color: white;">
                        <i class="fas fa-arrow-left"></i>
                        <span>Regresar al Admin</span>
                    </a>
                @endif
                
                <form method="POST" action="{{ route('logout') }}" class="d-inline w-100">
                    @csrf
                    <button type="submit" class="sidebar-action-btn logout-btn">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Cerrar Sesión</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Bar -->
        <div class="top-bar d-flex align-items-center">
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="user-menu dropdown ms-auto">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-info">
                        <h6>{{ auth()->user()->name }}</h6>
                        <small>{{ auth()->user()->email }}</small>
                        @if(auth()->user()->empresa && auth()->user()->empresa->nombre)
                            <small class="text-warning d-block">
                                <i class="bi bi-building"></i> {{ auth()->user()->empresa->nombre }}
                            </small>
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                                                <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                            <i class="bi bi-person-gear"></i>
                            Mi Perfil
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#managePlanModal">
                            <i class="bi bi-credit-card-2-front"></i>
                            Mi Plan
                        </a>
                    </li>
                    @php
                        $lastRenovacion = auth()->user()->renovaciones()->completed()->latest()->first();
                    @endphp
                    <li>
                        @php
                            $userLastRenovacion = auth()->user()->renovaciones()->latest()->first();
                        @endphp
                        @if($userLastRenovacion)
                            <a class="dropdown-item" href="javascript:void(0)" onclick="downloadInvoice('{{ $userLastRenovacion->id }}')">
                                <i class="bi bi-receipt"></i>
                                Descargar Último Recibo
                                @if($userLastRenovacion->status !== 'completed')
                                    <small class="text-warning ms-1">({{ ucfirst($userLastRenovacion->status) }})</small>
                                @endif
                            </a>
                        @else
                            <span class="dropdown-item text-muted">
                                <i class="bi bi-receipt"></i>
                                Sin recibos disponibles
                            </span>
                        @endif
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.plans.index') }}">
                            <i class="bi bi-grid-3x3-gap"></i>
                            Ver Todos los Planes
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right"></i>
                                Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content Area -->
        <div class="content-area">
            {{-- Alert for expired trial/plan --}}
            @if(session('trial_expired'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Plan Expirado</h6>
                            <p class="mb-0">Tu plan ha vencido. <a href="{{ route('admin.plans.index') }}" class="alert-link">Adquiere un nuevo plan</a> para continuar.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Alert for plan expiring soon --}}
            @if(session('trial_expiring_soon'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clock-history me-3 fs-4"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Plan por Vencer</h6>
                            <p class="mb-0">Tu plan vence pronto. <a href="{{ route('admin.plans.index') }}" class="alert-link">Renuévalo ahora</a> para evitar interrupciones.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Alert for no plan assigned --}}
            @if(session('no_plan_assigned'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-info-circle me-3 fs-4"></i>
                        <div>
                            <h6 class="alert-heading mb-1">Sin Plan Asignado</h6>
                            <p class="mb-0"><a href="{{ route('admin.plans.index') }}" class="alert-link">Selecciona un plan</a> para comenzar a usar la plataforma.</p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" data-bs-autohide="true" data-bs-delay="7000">
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                        <h6 class="mb-0 fw-bold">Se encontraron los siguientes errores:</h6>
                    </div>
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li class="mb-1">{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert-dismissible');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000); // 5 segundos (ajústalo si quieres más tiempo)
            });
        });

        // Function to show license expired message
        function showLicenseExpiredMessage() {
            Swal.fire({
                title: '🔒 Licencia Vencida',
                html: `
                    <div class="text-center">
                        <div class="mb-3">
                            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <p class="mb-3">Tu licencia ha vencido y no puedes acceder a esta función.</p>
                        <p class="text-muted">Para continuar usando la plataforma, necesitas gestionar tu plan.</p>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-credit-card me-1"></i> Gestionar Plan',
                cancelButtonText: 'Cerrar',
                confirmButtonColor: '#d22e23',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'license-expired-modal'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("admin.plans.index") }}';
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const sidebar = document.getElementById('sidebar');
            
            if (mobileMenuBtn && sidebar) {
                mobileMenuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });

                // Close sidebar when clicking outside on mobile
                document.addEventListener('click', function(e) {
                    if (window.innerWidth <= 768) {
                        if (!sidebar.contains(e.target) && !mobileMenuBtn.contains(e.target)) {
                            sidebar.classList.remove('show');
                        }
                    }
                });
            }
        });

        // Función para descargar recibo de pago (Global)
        window.downloadInvoice = function(renovacionId) {
            const receiptUrl = renovacionId ? `/receipt/download/${renovacionId}` : '/receipt/download-latest';
            
            // Mostrar loading con timer más corto
            try {
                // Abrir el recibo en una nueva ventana/pestaña
                const receiptWindow = window.open(receiptUrl, '_blank');
                
                // Verificar si se bloqueó la ventana emergente
                if (!receiptWindow || receiptWindow.closed || typeof receiptWindow.closed == 'undefined') {
                    // Si se bloqueó, cerrar loading y mostrar mensaje
                    Swal.close();
                    Swal.fire({
                        title: 'Ventana bloqueada',
                        html: `
                            <div class="text-center">
                                <i class="bi bi-window-x text-warning mb-3" style="font-size: 3rem;"></i>
                                <p>Tu navegador bloqueó la ventana emergente.</p>
                                <p class="text-muted">Haz clic en el botón de abajo para descargar el recibo:</p>
                            </div>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: '<i class="bi bi-download me-1"></i> Descargar Recibo',
                        cancelButtonText: 'Cancelar',
                        confirmButtonColor: '#007bff',
                        cancelButtonColor: '#6c757d'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Usar enlace directo si la ventana emergente está bloqueada
                            Swal.close();
                            const link = document.createElement('a');
                            link.href = receiptUrl;
                            link.target = '_blank';
                            link.click();
                        }
                    });
                } else {
                    // Ventana abierta exitosamente, cerrar loading después de un breve momento
                    Swal.close();
                    setTimeout(() => {
                        
                        // Mostrar confirmación de éxito
                        Swal.fire({
                            title: '¡Recibo Generado!',
                            text: 'El recibo se ha abierto en una nueva pestaña.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                            toast: true,
                            position: 'top-end',
                            customClass: {
                                popup: 'colored-toast'
                            }
                        });
                    }, 800); // Tiempo reducido para mejor UX
                }
            } catch (error) {
                console.error('Error al abrir recibo:', error);
                Swal.close();
                Swal.fire({
                    title: 'Error',
                    text: 'No se pudo generar el recibo. Por favor, intenta nuevamente.',
                    icon: 'error',
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#dc3545'
                });
            }
        };

        // Función auxiliar para mostrar loading
        function showLoadingAlert(message) {
            Swal.fire({
                title: 'Cargando...',
                text: message,
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        }
    </script>
    
    @stack('scripts')
    
    <!-- Plan Management Modal -->
    @include('components.manage-plan-modal')
</body>
</html>