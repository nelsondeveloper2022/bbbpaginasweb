<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración - BBB Páginas Web</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-bbb.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root {
            --primary-red: #d22e23;
            --primary-gold: #f0ac21;
            --dark-bg: #2c3e50;
            --light-gray: #f8f9fa;
        }

        body {
            background: linear-gradient(135deg, var(--primary-red) 0%, #b01e1a 50%, var(--dark-bg) 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        /* Patrón de fondo sutil */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(240, 172, 33, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(240, 172, 33, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .container-fluid {
            position: relative;
            z-index: 1;
        }
        
        .login-card {
            backdrop-filter: blur(15px);
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 10px 25px rgba(210, 46, 35, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.8);
            overflow: hidden;
            position: relative;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-red), var(--primary-gold));
        }
        
        .btn-admin {
            background: linear-gradient(45deg, var(--primary-red), #c41e1a);
            border: none;
            color: white;
            font-weight: 600;
            padding: 14px 35px;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-admin::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(240, 172, 33, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-admin:hover::before {
            left: 100%;
        }
        
        .btn-admin:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(210, 46, 35, 0.4);
            color: white;
            background: linear-gradient(45deg, #e8342a, var(--primary-red));
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-red);
            box-shadow: 0 0 0 0.2rem rgba(210, 46, 35, 0.15);
            background-color: #fff;
        }

        .input-group-text {
            border: 2px solid #e9ecef;
            border-right: none;
            background: var(--light-gray);
            color: var(--primary-red);
            border-radius: 10px 0 0 10px;
            font-size: 1.1rem;
            width: 50px;
            justify-content: center;
        }

        .form-control:focus + .input-group-text,
        .input-group .form-control:focus ~ .input-group-text {
            border-color: var(--primary-red);
        }
        
        .admin-badge {
            background: linear-gradient(45deg, var(--primary-red), var(--primary-gold));
            color: white;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(210, 46, 35, 0.3);
        }

        .logo-container {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, var(--primary-red), var(--primary-gold));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 8px 25px rgba(210, 46, 35, 0.3);
        }

        .logo-container img {
            width: 50px;
            height: 50px;
        }

        .back-link {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .back-link:hover {
            color: var(--primary-gold);
            transform: translateX(-5px);
        }

        .alert {
            border-radius: 12px;
            border: none;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        h4 {
            color: var(--dark-bg);
            font-weight: 700;
        }

        .form-label {
            color: var(--dark-bg);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .text-muted {
            color: #6c757d !important;
        }

        /* Responsive mejoras */
        @media (max-width: 768px) {
            .login-card {
                margin: 1rem;
                border-radius: 15px;
            }
            
            .btn-admin {
                padding: 12px 25px;
                font-size: 0.95rem;
            }
        }
    </style>
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-11 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="login-card p-5">
                    <div class="text-center mb-4">
                        <div class="logo-container">
                            <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB Logo">
                        </div>
                        <h4 class="mb-3">Panel de Administración</h4>
                        <span class="admin-badge">
                            <i class="fas fa-shield-alt me-2"></i>
                            Acceso Restringido
                        </span>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                <small>{{ $error }}</small><br>
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small>{{ session('error') }}</small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.post') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="email" class="form-label">Email de Administrador</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-user-shield"></i>
                                </span>
                                <input id="email" type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autocomplete="email" 
                                       autofocus
                                       placeholder="admin@ejemplo.com">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       placeholder="••••••••">
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-admin">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Acceder al Panel
                            </button>
                        </div>
                    </form>

                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Solo personal autorizado
                        </small>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="back-link">
                        <i class="fas fa-arrow-left me-2"></i>
                        Volver al sitio principal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>