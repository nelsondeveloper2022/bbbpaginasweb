@extends('layouts.app')

@section('title', 'Recuperar Contraseña - BBB Páginas Web')
@section('description', 'Recupera el acceso a tu cuenta de BBB Páginas Web')

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
    
    .info-box {
        background-color: #fff3cd;
        border-left: 4px solid var(--primary-gold);
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
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
                            <i class="bi bi-key-fill" style="font-size: 48px;"></i>
                        </div>
                        <h2 class="fw-bold mb-0">Recuperar Contraseña</h2>
                        <p class="mb-0 mt-2 opacity-90">Restablece el acceso a tu cuenta</p>
                    </div>
                    
                    <div class="auth-body">
                        <!-- Info Message -->
                        <div class="info-box">
                            <div class="d-flex align-items-start">
                                <i class="bi bi-info-circle me-2" style="font-size: 20px; color: var(--primary-gold);"></i>
                                <small style="color: #856404;">
                                    Ingresa tu correo electrónico y te enviaremos un enlace seguro para crear una nueva contraseña.
                                </small>
                            </div>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="alert alert-success mb-4" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                            </div>
                        @endif

                        <!-- Form -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="form-floating mb-3">
                                <input id="email" type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" 
                                       required autofocus
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

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-auth">
                                <i class="bi bi-send-fill me-2"></i>
                                Enviar Enlace de Recuperación
                            </button>
                        </form>

                        <!-- Back to Login Link -->
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted mb-2">¿Recordaste tu contraseña?</p>
                            <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="auth-link">
                                <i class="bi bi-arrow-left me-1"></i>Volver al inicio de sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
