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
                        <form method="POST" action="{{ route('login.post', ['locale' => app()->getLocale()]) }}">
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
                            <x-recaptcha-enterprise action="LOGIN" />

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-auth">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Iniciar Sesión
                            </button>

                            <!-- Forgot Password Link -->
                            @if (Route::has('password.request'))
                                <div class="text-center mt-3">
                                    <a href="{{ route('password.request') }}" class="auth-link small">
                                        ¿Olvidaste tu contraseña?
                                    </a>
                                </div>
                            @endif
                        </form>

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
@endsection