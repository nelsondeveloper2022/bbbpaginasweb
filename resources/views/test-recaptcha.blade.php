@extends('layouts.app')

@section('title', 'Prueba reCAPTCHA Enterprise - BBB Páginas Web')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .test-container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 0;
    }
    
    .test-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        overflow: hidden;
        max-width: 500px;
        width: 100%;
    }
    
    .test-header {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        color: white;
        padding: 2rem;
        text-align: center;
    }
    
    .test-body {
        padding: 2rem;
    }
    
    .btn-test {
        background: var(--primary-gold);
        border: none;
        color: var(--dark-bg);
        font-weight: 600;
        padding: 12px;
        border-radius: 10px;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-test:hover {
        background: #e09a1d;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(240, 172, 33, 0.4);
        color: var(--dark-bg);
    }
</style>
@endpush

@section('content')
<div class="test-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="test-card">
                    <div class="test-header">
                        <div class="mb-3">
                            <img src="{{ asset('images/logo-bbb.png') }}" alt="BBB Páginas Web" style="height: 50px; width: auto;">
                        </div>
                        <h2 class="fw-bold mb-0">Prueba reCAPTCHA Enterprise</h2>
                        <p class="mb-0 mt-2 opacity-90">Verificación de seguridad v3</p>
                    </div>
                    
                    <div class="test-body">
                        @if (session('success'))
                            <div class="alert alert-success mb-4" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                <strong>Error en la verificación:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('test-recaptcha') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="test_input" class="form-label">
                                    <i class="bi bi-keyboard me-2"></i>Campo de prueba
                                </label>
                                <input id="test_input" type="text" 
                                       class="form-control" 
                                       name="test_input" 
                                       placeholder="Escribe algo para probar"
                                       required>
                            </div>

                            <!-- reCAPTCHA Enterprise -->
                            <x-recaptcha-enterprise action="TEST" />

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-test">
                                <i class="bi bi-shield-check me-2"></i>
                                Probar Verificación
                            </button>
                        </form>

                        <div class="mt-4 pt-3 border-top">
                            <h6 class="text-muted mb-2">Información del Sistema:</h6>
                            <ul class="list-unstyled small">
                                <li><strong>reCAPTCHA configurado:</strong> 
                                    @if(config('app.recaptcha.site_key'))
                                        <span class="text-success">✓ Sí</span>
                                    @else
                                        <span class="text-danger">✗ No</span>
                                    @endif
                                </li>
                                <li><strong>Site Key:</strong> {{ Str::mask(config('app.recaptcha.site_key'), '*', 10, -10) }}</li>
                                <li><strong>Project ID:</strong> {{ config('app.recaptcha.project_id') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection