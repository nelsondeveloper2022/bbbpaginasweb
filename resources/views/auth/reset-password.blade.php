@extends('layouts.app')

@section('title', 'Restablecer Contraseña - BBB Páginas Web')
@section('description', 'Crea una nueva contraseña para tu cuenta de BBB Páginas Web')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .auth-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .auth-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
    }
    
    .auth-header {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .auth-body {
        padding: 2rem;
    }
    
    .form-floating > .form-control {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .form-floating > .form-control:focus {
        border-color: var(--primary-gold);
        box-shadow: 0 0 0 0.2rem rgba(240, 172, 33, 0.25);
    }
    
    .btn-auth {
        background: var(--primary-gold);
        border: none;
        color: var(--dark-bg);
        font-weight: 600;
        padding: 12px;
        border-radius: 10px;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-auth:hover {
        background: #e09a1d;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(240, 172, 33, 0.4);
        color: var(--dark-bg);
    }
    
    .password-requirements {
        background-color: #f8f9fa;
        border-left: 4px solid var(--primary-gold);
        padding: 15px;
        border-radius: 8px;
        margin-top: 20px;
        font-size: 14px;
    }
    
    .password-requirements ul {
        margin: 0;
        padding-left: 20px;
    }
    
    .password-requirements li {
        margin: 5px 0;
        color: #666;
    }
    
    .password-toggle {
        cursor: pointer;
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 10;
    }
    
    .password-toggle:hover {
        color: var(--primary-gold);
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="auth-card">
                    <div class="auth-header">
                        <div class="mb-3">
                            <i class="bi bi-shield-lock-fill" style="font-size: 48px;"></i>
                        </div>
                        <h2 class="fw-bold mb-0">Nueva Contraseña</h2>
                        <p class="mb-0 mt-2 opacity-90">Crea una contraseña segura para tu cuenta</p>
                    </div>
                    
                    <div class="auth-body">
                        <!-- Form -->
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address (readonly) -->
                            <div class="form-floating mb-3">
                                <input id="email" type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email', $request->email) }}" 
                                       required readonly
                                       style="background-color: #f8f9fa;"
                                       placeholder="correo@ejemplo.com">
                                <label for="email">
                                    <i class="bi bi-envelope me-2"></i>Correo Electrónico
                                </label>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-3 position-relative">
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="new-password"
                                       placeholder="Contraseña">
                                <label for="password">
                                    <i class="bi bi-lock me-2"></i>Nueva Contraseña
                                </label>
                                <i class="bi bi-eye password-toggle" id="togglePassword"></i>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-floating mb-3 position-relative">
                                <input id="password_confirmation" type="password" 
                                       class="form-control" 
                                       name="password_confirmation" required autocomplete="new-password"
                                       placeholder="Confirmar contraseña">
                                <label for="password_confirmation">
                                    <i class="bi bi-lock-fill me-2"></i>Confirmar Nueva Contraseña
                                </label>
                                <i class="bi bi-eye password-toggle" id="togglePasswordConfirm"></i>
                            </div>

                            <!-- Password Requirements -->
                            <div class="password-requirements">
                                <strong><i class="bi bi-info-circle me-2"></i>Requisitos de la contraseña:</strong>
                                <ul>
                                    <li>Mínimo 8 caracteres</li>
                                    <li>Incluye mayúsculas y minúsculas</li>
                                    <li>Incluye al menos un número</li>
                                    <li>Usa caracteres especiales (!@#$%^&*)</li>
                                </ul>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-auth mt-4">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Restablecer Contraseña
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle password visibility
    function setupPasswordToggle(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        
        if (toggle && input) {
            toggle.addEventListener('click', function() {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                
                // Toggle icon
                if (type === 'password') {
                    toggle.classList.remove('bi-eye-slash');
                    toggle.classList.add('bi-eye');
                } else {
                    toggle.classList.remove('bi-eye');
                    toggle.classList.add('bi-eye-slash');
                }
            });
        }
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        setupPasswordToggle('togglePassword', 'password');
        setupPasswordToggle('togglePasswordConfirm', 'password_confirmation');
        
        // Password strength indicator (opcional)
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                // Aquí podrías añadir lógica de validación en tiempo real
                // Por ejemplo, indicador visual de fortaleza de contraseña
            });
        }
    });
</script>
@endpush
@endsection
