@extends('layouts.app')

@section('title', 'Registro - BBB Páginas Web')
@section('description', 'Crea tu cuenta y comienza tu período de prueba gratuita')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .auth-container {
        min                            <!-- reCAPTCHA Enterprise -->
                            <div class="col-12">
                                <x-recaptcha-enterprise action="REGISTER" />
                            </div>ght: calc(100vh - 200px);
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
        max-width: 600px;
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
    
    .form-floating > .form-control, .form-floating > .form-select {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .form-floating > .form-control:focus, .form-floating > .form-select:focus {
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
    
    .trial-info {
        background: linear-gradient(135deg, #e8f5e8 0%, #f0f8ff 100%);
        border: 2px solid var(--primary-gold);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    
    .trial-info .trial-icon {
        color: var(--primary-gold);
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }
    
    .billing-warning {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 0.75rem;
        margin-top: 0.5rem;
        display: none;
    }
    
    .billing-warning.show {
        display: block;
    }
    
    .billing-warning .warning-icon {
        color: #f39c12;
    }
</style>
@endpush

@section('content')
<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-7">
                <div class="auth-card">
                    <div class="auth-header">
                        <div class="mb-3">
                            <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB Páginas Web" style="height: 50px; width: auto;">
                        </div>
                        <h2 class="fw-bold mb-0">Registro de Usuario</h2>
                        <p class="mb-0 mt-2 opacity-90">Crea tu cuenta para comenzar tu período de prueba gratuita</p>
                    </div>
                    
                    <div class="auth-body">
                        <!-- Trial Info -->
                        <div class="trial-info">
                            <div class="trial-icon">
                                <i class="bi bi-gift"></i>
                            </div>
                            <h5 class="fw-bold text-success mb-1">¡15 Días de Prueba Gratuita!</h5>
                            <p class="mb-0 text-muted small">
                                Sin compromisos • Sin tarjeta de crédito • Cancela cuando quieras
                            </p>
                        </div>

                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row g-3">
                                <!-- Nombre de Contacto -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input id="name" type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               name="name" value="{{ old('name') }}" 
                                               required autocomplete="name" autofocus
                                               placeholder="Nombre completo">
                                        <label for="name">
                                            <i class="bi bi-person me-2"></i>Nombre de Contacto
                                        </label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email Personal -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input id="email" type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               name="email" value="{{ old('email') }}" 
                                               required autocomplete="email"
                                               placeholder="correo@personal.com">
                                        <label for="email">
                                            <i class="bi bi-envelope me-2"></i>Email Personal
                                        </label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Teléfono Móvil -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input id="movil" type="tel" 
                                               class="form-control @error('movil') is-invalid @enderror" 
                                               name="movil" value="{{ old('movil') }}" 
                                               required autocomplete="tel"
                                               placeholder="+57 300 123 4567">
                                        <label for="movil">
                                            <i class="bi bi-telephone me-2"></i>Teléfono Móvil
                                        </label>
                                        @error('movil')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Empresa -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input id="empresa_nombre" type="text" 
                                               class="form-control @error('empresa_nombre') is-invalid @enderror" 
                                               name="empresa_nombre" value="{{ old('empresa_nombre') }}" 
                                               required autocomplete="organization"
                                               placeholder="Nombre de la empresa">
                                        <label for="empresa_nombre">
                                            <i class="fas fa-building me-2"></i>Nombre de la Empresa
                                        </label>
                                        @error('empresa_nombre')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email Corporativo -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input id="empresa_email" type="email" 
                                               class="form-control @error('empresa_email') is-invalid @enderror" 
                                               name="empresa_email" value="{{ old('empresa_email') }}" 
                                               required autocomplete="email"
                                               placeholder="info@empresa.com">
                                        <label for="empresa_email">
                                            <i class="fas fa-envelope me-2"></i>Email Corporativo
                                        </label>
                                        @error('empresa_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Dirección (Opcional) -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input id="empresa_direccion" type="text" 
                                               class="form-control @error('empresa_direccion') is-invalid @enderror" 
                                               name="empresa_direccion" value="{{ old('empresa_direccion') }}" 
                                               autocomplete="street-address"
                                               placeholder="Dirección de la empresa (opcional)">
                                        <label for="empresa_direccion">
                                            <i class="bi bi-geo-alt me-2"></i>Dirección (Opcional)
                                        </label>
                                        @error('empresa_direccion')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Plan -->
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select id="plan_id" 
                                                class="form-select @error('plan_id') is-invalid @enderror" 
                                                name="plan_id" required>
                                            <option value="">Selecciona un plan</option>
                                            @if(isset($planes) && $planes->count() > 0)
                                                @php
                                                    $selectedPlanSlug = request('plan');
                                                @endphp
                                                @foreach($planes as $plan)
                                                    @php
                                                        $isSelected = false;
                                                        // Verificar si hay un plan preseleccionado por URL o por old() input
                                                        if (old('plan_id')) {
                                                            $isSelected = old('plan_id') == $plan->idPlan;
                                                        } elseif ($selectedPlanSlug) {
                                                            $isSelected = $plan->slug == $selectedPlanSlug;
                                                        }
                                                    @endphp
                                                    <option value="{{ $plan->idPlan }}" 
                                                            data-price="{{ $plan->precioPesos }}"
                                                            data-slug="{{ $plan->slug }}"
                                                            {{ $isSelected ? 'selected' : '' }}>
                                                        {{ $plan->nombre }} - ${{ number_format($plan->precioPesos, 0, ',', '.') }} COP
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label for="plan_id">
                                            <i class="bi bi-clipboard-check me-2"></i>Plan Seleccionado
                                        </label>
                                        @error('plan_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <!-- Billing Warning for Rental Plan -->
                                    <div id="billingWarning" class="billing-warning">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-info-circle warning-icon me-2"></i>
                                            <small class="fw-bold">
                                                <strong>Información:</strong> Este plan tiene cobro trimestral (cada 3 meses)
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input id="password" type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               name="password" required autocomplete="new-password"
                                               placeholder="Contraseña">
                                        <label for="password">
                                            <i class="bi bi-lock me-2"></i>Contraseña
                                        </label>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input id="password_confirmation" type="password" 
                                               class="form-control" 
                                               name="password_confirmation" required autocomplete="new-password"
                                               placeholder="Confirmar contraseña">
                                        <label for="password_confirmation">
                                            <i class="bi bi-lock-fill me-2"></i>Confirmar Contraseña
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <!-- reCAPTCHA Enterprise -->
                            <div class="col-12">
                                <x-recaptcha-enterprise action="REGISTER" />
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-auth mt-4">
                                <i class="bi bi-person-plus-fill me-2"></i>
                                Crear Cuenta y Comenzar Prueba
                            </button>
                        </form>

                        <!-- Login Link -->
                        <div class="text-center mt-4 pt-3 border-top">
                            <p class="text-muted mb-2">¿Ya tienes una cuenta?</p>
                            <a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="auth-link">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Inicia sesión aquí
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const planSelect = document.getElementById('plan_id');
    const billingWarning = document.getElementById('billingWarning');
    
    function checkPlanSelection() {
        const selectedOption = planSelect.options[planSelect.selectedIndex];
        
        if (selectedOption && selectedOption.value) {
            const planSlug = selectedOption.getAttribute('data-slug');
            
            // Show billing warning for the first plan (assuming it's the one with biweekly billing)
            if (planSlug === 'web-en-arriendo') {
                billingWarning.classList.add('show');
            } else {
                billingWarning.classList.remove('show');
            }
        } else {
            billingWarning.classList.remove('show');
        }
    }
    
    // Function to preselect plan based on URL parameter
    function preselectPlanFromURL() {
        const urlParams = new URLSearchParams(window.location.search);
        const planSlug = urlParams.get('plan');
        
        if (planSlug && planSelect) {
            // Find the option with matching slug
            const options = planSelect.querySelectorAll('option');
            options.forEach(option => {
                if (option.getAttribute('data-slug') === planSlug) {
                    option.selected = true;
                    // Trigger change event to update billing warning
                    planSelect.dispatchEvent(new Event('change'));
                }
            });
        }
    }
    
    // Check on page load
    preselectPlanFromURL();
    checkPlanSelection();
    
    // Check when plan changes
    planSelect.addEventListener('change', checkPlanSelection);
    
    // Optional: Update URL when plan changes to maintain consistency
    planSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const planSlug = selectedOption.getAttribute('data-slug');
            if (planSlug) {
                const url = new URL(window.location);
                url.searchParams.set('plan', planSlug);
                // Update URL without reloading the page
                window.history.replaceState({}, '', url);
            }
        }
    });
});
</script>
@endpush
@endsection