<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #ecf0f1;
        }
        
        body {
            background: linear-gradient(135deg, var(--light-bg) 0%, #bdc3c7 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px;
            transition: border-color 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color));
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-weight: 600;
        }
        
        .btn-outline-primary {
            border: 2px solid var(--secondary-color);
            color: var(--secondary-color);
            border-radius: 10px;
            padding: 10px 25px;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .logo-container {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 col-xl-6">
                <div class="card">
                    <div class="card-body p-4 p-md-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="logo-container mb-3">
                                <i class="bi bi-building display-4"></i>
                            </div>
                            <h2 class="fw-bold text-primary mb-2">Registro de Usuario</h2>
                            <p class="text-muted">Crea tu cuenta para comenzar tu período de prueba gratuita</p>
                        </div>

                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('register.post', ['locale' => app()->getLocale()]) }}">
                            @csrf

                            <div class="row g-3">
                                <!-- Nombre de Contacto -->
                                <div class="col-md-6">
                                    <label for="nombre_contacto" class="form-label fw-bold">
                                        <i class="bi bi-person me-2 text-primary"></i>Nombre de Contacto
                                    </label>
                                    <input id="nombre_contacto" type="text" 
                                           class="form-control @error('nombre_contacto') is-invalid @enderror" 
                                           name="nombre_contacto" value="{{ old('nombre_contacto') }}" 
                                           required autofocus autocomplete="name"
                                           placeholder="Tu nombre completo">
                                    @error('nombre_contacto')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-bold">
                                        <i class="bi bi-envelope me-2 text-primary"></i>Correo Electrónico
                                    </label>
                                    <input id="email" type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" 
                                           required autocomplete="email"
                                           placeholder="correo@ejemplo.com">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Móvil -->
                                <div class="col-md-6">
                                    <label for="movil" class="form-label fw-bold">
                                        <i class="bi bi-phone me-2 text-primary"></i>Número Móvil
                                    </label>
                                    <input id="movil" type="text" 
                                           class="form-control @error('movil') is-invalid @enderror" 
                                           name="movil" value="{{ old('movil') }}" 
                                           required autocomplete="tel"
                                           placeholder="+57 300 123 4567">
                                    @error('movil')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Nombre de la Empresa -->
                                <div class="col-md-6">
                                    <label for="empresa_nombre" class="form-label fw-bold">
                                        <i class="bi bi-building me-2 text-primary"></i>Nombre de la Empresa
                                    </label>
                                    <input id="empresa_nombre" type="text" 
                                           class="form-control @error('empresa_nombre') is-invalid @enderror" 
                                           name="empresa_nombre" value="{{ old('empresa_nombre') }}" 
                                           required autocomplete="organization"
                                           placeholder="Tu empresa o emprendimiento">
                                    @error('empresa_nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Plan Seleccionado -->
                                <div class="col-12">
                                    <label for="plan_seleccionado" class="form-label fw-bold">
                                        <i class="bi bi-star me-2 text-primary"></i>Plan Seleccionado
                                    </label>
                                    <select id="plan_seleccionado" 
                                            class="form-select @error('plan_seleccionado') is-invalid @enderror" 
                                            name="plan_seleccionado" required>
                                        <option value="">Selecciona un plan</option>
                                        @if(isset($planes))
                                            @foreach($planes as $plan)
                                                <option value="{{ $plan->nombre }}" {{ old('plan_seleccionado') == $plan->nombre ? 'selected' : '' }}>
                                                    {{ $plan->nombre }} - ${{ number_format($plan->precioPesos, 0) }} COP
                                                </option>
                                            @endforeach
                                        @else
                                            <option value="Plan Básico">Plan Básico - $50,000 COP</option>
                                            <option value="Plan Profesional">Plan Profesional - $100,000 COP</option>
                                            <option value="Plan Empresarial">Plan Empresarial - $200,000 COP</option>
                                        @endif
                                    </select>
                                    @error('plan_seleccionado')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Contraseña -->
                                <div class="col-md-6">
                                    <label for="password" class="form-label fw-bold">
                                        <i class="bi bi-lock me-2 text-primary"></i>Contraseña
                                    </label>
                                    <input id="password" type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="new-password"
                                           placeholder="Mínimo 8 caracteres">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-bold">
                                        <i class="bi bi-lock-fill me-2 text-primary"></i>Confirmar Contraseña
                                    </label>
                                    <input id="password_confirmation" type="password" 
                                           class="form-control" 
                                           name="password_confirmation" required autocomplete="new-password"
                                           placeholder="Repite tu contraseña">
                                </div>
                            </div>

                            <!-- Trial Info -->
                            <div class="alert alert-info mt-4" role="alert">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Período de Prueba:</strong> Obtienes 15 días gratuitos para probar todas las funciones del sistema.
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-person-plus me-2"></i>Crear Cuenta
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center mt-3">
                                <span class="text-muted">¿Ya tienes una cuenta?</span>
                                <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="text-decoration-none fw-bold">
                                    Iniciar Sesión
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
