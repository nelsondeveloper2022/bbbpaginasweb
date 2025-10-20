@extends('layouts.app')

@section('title', 'Iniciar Sesión - BBB Páginas Web')
@section('description', 'Inicia sesión en tu cuenta de BBB Páginas Web')

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
        max-width: 450px;
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
    
    .auth-link {
        color: var(--primary-red);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }
    
    .auth-link:hover {
        color: var(--primary-gold);
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-header">
                        <div class="mb-3">
                            <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB Páginas Web" style="height: 50px; width: auto;">
                        </div>
                        <h2 class="fw-bold mb-0">Iniciar Sesión</h2>
                        <p class="mb-0 mt-2 opacity-90">Accede a tu cuenta BBB</p>
                    </div>
                    
                    <div class="auth-body">
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="form-floating mb-3">
                                <input id="email" type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" 
                                       required autocomplete="email" autofocus
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
                            <div class="form-floating mb-3">
                                <input id="password" type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       name="password" required autocomplete="current-password"
                                       placeholder="Contraseña">
                                <label for="password">
                                    <i class="bi bi-lock me-2"></i>Contraseña
                                </label>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="form-check mb-3">
                                <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                                <label for="remember_me" class="form-check-label">
                                    Recordarme
                                </label>
                            </div>

                            <!-- reCAPTCHA Enterprise -->
                            {{-- Temporalmente deshabilitado mientras se configura correctamente --}}
                            {{-- <x-recaptcha-enterprise action="LOGIN" /> --}}

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-auth">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Iniciar Sesión
                            </button>

                            <!-- Forgot Password Link -->
                            @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <!-- Trigger modal -->
                                    <a href="#" class="auth-link small" id="forgot-password-link">
                                        <i class="bi bi-shield-lock me-1"></i>¿Olvidaste tu contraseña?
                                    </a>
                                </div>
                            @endif
                        </form>

                        <!-- Modal de Recuperación de Contraseña (FUERA del formulario de login) -->
                        @if (Route::has('password.request'))
                            <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-hidden="true">
                                                                            <div class="modal-dialog modal-dialog-centered">
                                                                                <div class="modal-content" style="border-radius: 20px; border: none; box-shadow: 0 15px 35px rgba(0,0,0,0.2);">
                                                                                    <!-- Modal Header con gradiente -->
                                                                                    <div class="modal-header" style="background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%); border: none; border-radius: 20px 20px 0 0; padding: 25px 30px;">
                                                                                        <div class="w-100 text-center">
                                                                                            <i class="bi bi-key-fill" style="font-size: 36px; color: white; margin-bottom: 10px; display: block;"></i>
                                                                                            <h5 class="modal-title fw-bold mb-0" style="color: white; font-size: 22px;">Recuperar Contraseña</h5>
                                                                                            <p class="mb-0 mt-2" style="color: rgba(255,255,255,0.9); font-size: 14px;">Te enviaremos un enlace para restablecer tu contraseña</p>
                                                                                        </div>
                                                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 20px; top: 20px;"></button>
                                                                                    </div>
                                                                                    
                                                                                    <!-- Modal Body -->
                                                                                    <div class="modal-body" style="padding: 30px;">
                                                                                        <!-- Alert container -->
                                                                                        <div id="fp-alert" style="display:none; border-radius: 10px; animation: slideDown 0.3s ease;"></div>
                                                                                        
                                                                                        <!-- Descripción -->
                                                                                        <div class="mb-4 text-center">
                                                                                            <p class="text-muted mb-0" style="font-size: 15px;">
                                                                                                Ingresa tu correo electrónico y te enviaremos un enlace seguro para crear una nueva contraseña.
                                                                                            </p>
                                                                                        </div>
                                                                                        
                                                                                        <!-- Form -->
                                                                                        <form id="forgot-password-form" novalidate>
                                                                                            @csrf
                                                                                            <div class="form-floating mb-3">
                                                                                                <input type="email" 
                                                                                                       class="form-control" 
                                                                                                       id="fp-email" 
                                                                                                       name="email" 
                                                                                                       placeholder="correo@ejemplo.com"
                                                                                                       style="border: 2px solid #e9ecef; border-radius: 10px; padding: 12px; height: auto;">
                                                                                                <label for="fp-email">
                                                                                                    <i class="bi bi-envelope me-2"></i>Correo Electrónico
                                                                                                </label>
                                                                                            </div>
                                                                                            
                                                                                            <!-- Security notice -->
                                                                                            <div class="alert" style="background-color: #fff3cd; border-left: 4px solid var(--primary-gold); border-radius: 8px; padding: 12px 15px; margin-bottom: 0;">
                                                                                                <div class="d-flex align-items-start">
                                                                                                    <i class="bi bi-shield-check" style="color: var(--primary-gold); font-size: 20px; margin-right: 10px; margin-top: 2px;"></i>
                                                                                                    <small style="color: #856404; line-height: 1.5;">
                                                                                                        <strong>Seguro y confidencial:</strong> El enlace expirará en 60 minutos por tu seguridad.
                                                                                                    </small>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                    
                                                                                    <!-- Modal Footer -->
                                                                                    <div class="modal-footer" style="border: none; padding: 20px 30px 30px; background-color: #f8f9fa; border-radius: 0 0 20px 20px;">
                                                                                        <button type="button" 
                                                                                                class="btn btn-light" 
                                                                                                data-bs-dismiss="modal"
                                                                                                style="border-radius: 10px; padding: 10px 20px; font-weight: 600; border: 2px solid #dee2e6;">
                                                                                            <i class="bi bi-x-circle me-1"></i>Cancelar
                                                                                        </button>
                                                                                        <button type="button" 
                                                                                                id="fp-submit" 
                                                                                                class="btn"
                                                                                                style="background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%); 
                                                                                                       border: none; 
                                                                                                       color: white; 
                                                                                                       font-weight: 600; 
                                                                                                       padding: 10px 30px; 
                                                                                                       border-radius: 10px; 
                                                                                                       transition: all 0.3s ease;">
                                                                                            <i class="bi bi-send-fill me-2"></i>
                                                                                            <span id="fp-submit-text">Enviar Enlace</span>
                                                                                            <span id="fp-submit-loading" style="display: none;">
                                                                                                <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                                                                                Enviando...
                                                                                            </span>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                        @endif
                        
                        <!-- Registration Link -->
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted mb-2">¿No tienes una cuenta?</p>
                            <a href="{{ route('register', ['locale' => app()->getLocale()]) }}" class="auth-link">
                                <i class="bi bi-person-plus me-1"></i>Regístrate aquí
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    @push('scripts')
                    <style>
                        @keyframes slideDown {
                            from {
                                opacity: 0;
                                transform: translateY(-10px);
                            }
                            to {
                                opacity: 1;
                                transform: translateY(0);
                            }
                        }
                        
                        #fp-submit:hover {
                            transform: translateY(-2px);
                            box-shadow: 0 5px 15px rgba(210, 46, 35, 0.4) !important;
                        }
                        
                        #fp-submit:disabled {
                            opacity: 0.7;
                            cursor: not-allowed;
                        }
                    </style>
                    <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        var forgotLink = document.getElementById('forgot-password-link');
                        var modalEl = document.getElementById('forgotPasswordModal');
                        
                        if (forgotLink && modalEl && typeof bootstrap !== 'undefined') {
                            var modal = new bootstrap.Modal(modalEl);
                            var submitBtn = document.getElementById('fp-submit');
                            var submitText = document.getElementById('fp-submit-text');
                            var submitLoading = document.getElementById('fp-submit-loading');
                            var emailInput = document.getElementById('fp-email');
                            var alertDiv = document.getElementById('fp-alert');
                            
                            // Abrir modal
                            forgotLink.addEventListener('click', function (e) {
                                e.preventDefault();
                                modal.show();
                                // Limpiar campos y alertas al abrir
                                emailInput.value = '';
                                alertDiv.style.display = 'none';
                            });

                            // Submit del formulario
                            submitBtn.addEventListener('click', function (e) {
                                e.preventDefault();
                                
                                var email = emailInput.value.trim();
                                
                                // Validación básica
                                if (!email || !email.includes('@')) {
                                    showAlert('danger', '<i class="bi bi-exclamation-triangle me-2"></i>Por favor ingresa un correo electrónico válido.');
                                    return;
                                }
                                
                                // Deshabilitar botón y mostrar loading
                                submitBtn.disabled = true;
                                submitText.style.display = 'none';
                                submitLoading.style.display = 'inline';
                                alertDiv.style.display = 'none';
                                
                                // Obtener token del meta tag (más confiable)
                                var token = document.querySelector('meta[name="csrf-token"]');
                                var csrfToken = token ? token.getAttribute('content') : '';
                                
                                console.log('CSRF Token:', csrfToken); // Debug

                                fetch("{{ route('password.email') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Accept': 'application/json'
                                    },
                                    body: JSON.stringify({ email: email })
                                })
                                .then(function (res) {
                                    return res.json().then(function (data) {
                                        return { status: res.status, body: data };
                                    }).catch(function () { 
                                        return { status: res.status, body: {} }; 
                                    });
                                })
                                .then(function (result) {
                                    // Re-habilitar botón
                                    submitBtn.disabled = false;
                                    submitText.style.display = 'inline';
                                    submitLoading.style.display = 'none';
                                    
                                    if (result.status === 200) {
                                        showAlert('success', 
                                            '<i class="bi bi-check-circle me-2"></i><strong>¡Enlace enviado!</strong><br>' +
                                            (result.body.message || 'Revisa tu correo electrónico para restablecer tu contraseña.')
                                        );
                                        // Limpiar campo de email
                                        emailInput.value = '';
                                        
                                        // Cerrar modal después de 3 segundos
                                        setTimeout(function() {
                                            modal.hide();
                                        }, 3000);
                                    } else if (result.status === 422) {
                                        var msg = 'Error: comprueba el correo ingresado.';
                                        if (result.body.errors && result.body.errors.email) {
                                            msg = result.body.errors.email.join(' ');
                                        }
                                        showAlert('danger', '<i class="bi bi-exclamation-circle me-2"></i>' + msg);
                                    } else {
                                        showAlert('danger', 
                                            '<i class="bi bi-exclamation-circle me-2"></i>' +
                                            (result.body.message || 'Ocurrió un error al intentar enviar el enlace.')
                                        );
                                    }
                                })
                                .catch(function (err) {
                                    // Re-habilitar botón
                                    submitBtn.disabled = false;
                                    submitText.style.display = 'inline';
                                    submitLoading.style.display = 'none';
                                    
                                    showAlert('danger', '<i class="bi bi-wifi-off me-2"></i>Error de conexión. Por favor, intenta nuevamente.');
                                    console.error('Error:', err);
                                });
                            });
                            
                            // Función helper para mostrar alertas
                            function showAlert(type, message) {
                                alertDiv.className = 'alert alert-' + type;
                                alertDiv.innerHTML = message;
                                alertDiv.style.display = 'block';
                                
                                // Auto-scroll a la alerta
                                alertDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                            }
                            
                            // Permitir submit con Enter
                            emailInput.addEventListener('keypress', function(e) {
                                if (e.key === 'Enter') {
                                    e.preventDefault();
                                    submitBtn.click();
                                }
                            });
                        }
                    });
                    </script>
                    @endpush

                    @endsection