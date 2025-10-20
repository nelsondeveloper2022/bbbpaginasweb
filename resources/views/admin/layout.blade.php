<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Panel de Administración BBB</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bbb.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --admin-primary: #d22e23;
            --admin-secondary: #f0ac21;
            --admin-success: #10b981;
            --admin-danger: #dc3545;
            --admin-warning: #f0ac21;
            --admin-info: #0dcaf0;
            --admin-dark: #2c3e50;
            --admin-light: #f8f9fa;
            --admin-red-dark: #b01e1a;
            --admin-gold-dark: #d4941c;
        }

        body {
            background-color: var(--admin-light);
            font-family: 'Inter', sans-serif;
        }

        /* Sidebar */
        .admin-sidebar {
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-red-dark) 50%, var(--admin-dark) 100%);
            min-height: 100vh;
            width: 280px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            padding: 0;
            box-shadow: 2px 0 15px rgba(210, 46, 35, 0.15);
        }

        .admin-sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(240, 172, 33, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .admin-sidebar .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 2;
        }

        .admin-sidebar .sidebar-header h4 {
            color: white;
            margin: 0;
            font-weight: 700;
        }

        .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 0;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .admin-sidebar .nav-link:hover,
        .admin-sidebar .nav-link.active {
            color: white;
            background: rgba(240, 172, 33, 0.2);
            backdrop-filter: blur(10px);
            border-left: 4px solid var(--admin-secondary);
        }

        .admin-sidebar .nav-link i {
            width: 20px;
            margin-right: 10px;
        }

        /* Main content */
        .admin-main {
            margin-left: 280px;
            min-height: 100vh;
        }

        .admin-header {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(210, 46, 35, 0.1);
        }

        .admin-content {
            padding: 2rem;
        }

        /* Cards */
        .admin-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .admin-card-header {
            background: linear-gradient(45deg, var(--admin-primary), var(--admin-secondary));
            color: white;
            padding: 1rem 1.5rem;
            font-weight: 600;
        }

        /* Stats cards */
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e5e7eb;
            height: 100%;
            transition: transform 0.2s ease;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(210, 46, 35, 0.1);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        /* Tables */
        .table-admin {
            margin-bottom: 0;
        }

        .table-admin th {
            background-color: #f8fafc;
            border-top: none;
            font-weight: 600;
            color: var(--admin-dark);
            padding: 1rem;
        }

        .table-admin td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #e5e7eb;
        }

        .table-admin tbody tr:hover {
            background-color: rgba(210, 46, 35, 0.02);
        }

        /* Status badges */
        .status-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-admin {
            background: linear-gradient(45deg, var(--admin-primary), var(--admin-secondary));
            color: white;
        }

        .status-active {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-trial {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-expired {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Buttons */
        .btn-admin-primary {
            background: linear-gradient(45deg, var(--admin-primary), var(--admin-red-dark));
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-admin-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(210, 46, 35, 0.4);
            color: white;
            background: linear-gradient(45deg, #e8342a, var(--admin-primary));
        }

        .btn-admin-danger {
            background: linear-gradient(45deg, var(--admin-danger), #dc2626);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-admin-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
            color: white;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .admin-sidebar.show {
                transform: translateX(0);
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-content {
                padding: 1rem;
            }
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border-left: 4px solid var(--admin-success);
        }

        .alert-danger {
            background-color: #fee2e2;
            color: #991b1b;
            border-left: 4px solid var(--admin-danger);
        }

        .alert-info {
            background-color: #dbeafe;
            color: #1e40af;
            border-left: 4px solid var(--admin-info);
        }

        /* Estilos adicionales para la gestión avanzada */
        .landing-info {
            background-color: #f8f9fa;
            border-left: 4px solid #d22e23;
            padding: 0.75rem;
            margin-bottom: 0.5rem;
        }

        .color-preview {
            display: inline-block;
            width: 20px;
            height: 20px;
            border-radius: 3px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
            margin-right: 0.5rem;
        }

        .table-admin tbody tr:hover {
            background-color: rgba(210, 46, 35, 0.05);
        }

        .btn-group .btn {
            margin-right: 0;
        }

        .publish-button {
            background: linear-gradient(45deg, #28a745, #20c997);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .publish-button:hover {
            background: linear-gradient(45deg, #218838, #1ea584);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        }

        .landing-status {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
        }

        /* WhatsApp Styles */
        .whatsapp-btn {
            border-color: #25d366 !important;
            color: #25d366 !important;
            transition: all 0.3s ease;
        }

        .whatsapp-btn:hover {
            background-color: #25d366 !important;
            color: white !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
        }

        .template-preview {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 1.5rem;
            margin: 1rem 0;
            position: relative;
        }

        .template-preview::before {
            content: '';
            position: absolute;
            top: -1px;
            left: -1px;
            right: -1px;
            bottom: -1px;
            background: linear-gradient(45deg, #25d366, #128c7e);
            border-radius: 12px;
            z-index: -1;
        }

        .whatsapp-modal .modal-header {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            color: white;
            border-bottom: none;
        }

        .whatsapp-modal .btn-close {
            filter: invert(1);
        }

        .parameter-input {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .parameter-input:focus {
            border-color: #25d366;
            box-shadow: 0 0 0 0.2rem rgba(37, 211, 102, 0.25);
        }

        .template-card {
            border: 1px solid #dee2e6;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .template-card:hover {
            border-color: #25d366;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.15);
        }

        .template-card.selected {
            border-color: #25d366;
            background-color: rgba(37, 211, 102, 0.05);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="admin-sidebar">
        <div class="sidebar-header">
            <h4>
                <i class="fas fa-shield-alt me-2"></i>
                Panel Admin
            </h4>
            <small class="text-white-50">BBB Páginas Web</small>
        </div>
        
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                   href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
                   href="{{ route('admin.users') }}">
                    <i class="fas fa-users"></i>
                    Usuarios
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.admins*') || request()->routeIs('admin.create-admin') ? 'active' : '' }}" 
                   href="{{ route('admin.admins') }}">
                    <i class="fas fa-user-shield"></i>
                    Administradores
                </a>
            </li>
            <li class="nav-item mt-auto">
                <hr class="text-white-50">
                <div class="px-3 py-2">
                    <small class="text-white-50">Conectado como:</small><br>
                    <small class="text-white">{{ Auth::user()->name }}</small>
                </div>
                <form method="POST" action="{{ route('admin.logout') }}" class="px-3">
                    @csrf
                    <button type="submit" class="nav-link border-0 bg-transparent w-100 text-start">
                        <i class="fas fa-sign-out-alt"></i>
                        Cerrar Sesión
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">@yield('page-title', 'Panel de Administración')</h5>
                    <small class="text-muted">{{ now()->format('d/m/Y H:i:s') }}</small>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-primary me-2">
                        <i class="fas fa-user-shield me-1"></i>
                        Administrador
                    </span>
                    <span class="text-muted">{{ Auth::user()->name }}</span>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="admin-content">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Admin JS -->
    <script>
        // Auto dismiss alerts
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                if (alert.querySelector('.btn-close')) {
                    let bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);

        // Mobile sidebar toggle
        function toggleSidebar() {
            document.querySelector('.admin-sidebar').classList.toggle('show');
        }
    </script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>