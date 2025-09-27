@extends('layouts.app')

@section('title', __('plans.checkout.title') . ' - ' . $plan->nombre)
@section('description', __('plans.checkout.title') . ' ' . $plan->nombre)

@push('styles')
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .checkout-hero {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        padding: 6rem 0 3rem;
        color: white;
        text-align: center;
    }

    .checkout-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .checkout-content {
        padding: 4rem 0;
        background: #f8f9fa;
        min-height: 70vh;
    }

    .checkout-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .plan-summary {
        border: 2px solid var(--primary-gold);
        background: linear-gradient(135deg, #fff9e6 0%, #ffffff 100%);
    }

    .plan-summary .plan-icon {
        font-size: 2rem;
        color: var(--primary-gold);
        margin-bottom: 1rem;
    }

    .plan-summary .plan-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-red);
        margin-bottom: 1rem;
    }

    .price-display {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: white;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .price-cop, .price-usd {
        text-align: center;
        padding: 1rem;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .price-cop:hover, .price-usd:hover {
        border-color: var(--primary-gold);
    }

    .price-cop.selected {
        border-color: var(--primary-red);
        background: #fff5f5;
    }

    .price-usd.selected {
        border-color: var(--primary-gold);
        background: #fff9e6;
    }

    .price-amount {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .price-cop .price-amount {
        color: var(--primary-red);
    }

    .price-usd .price-amount {
        color: var(--primary-gold);
    }

    .checkout-form .form-group {
        margin-bottom: 1.5rem;
    }

    .checkout-form label {
        font-weight: 600;
        color: var(--primary-red);
        margin-bottom: 0.5rem;
        display: block;
    }

    .checkout-form .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .checkout-form .form-control:focus {
        border-color: var(--primary-gold);
        box-shadow: 0 0 0 0.2rem rgba(218, 165, 32, 0.25);
    }

    .submit-btn {
        background: var(--primary-red);
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 25px;
        font-weight: 600;
        font-size: 1.1rem;
        width: 100%;
        transition: all 0.3s ease;
    }

    .submit-btn:hover {
        background: #b01e1a;
        transform: translateY(-2px);
    }

    .feature-list {
        max-height: 300px;
        overflow-y: auto;
    }

    .feature-list ul {
        list-style: none;
        padding: 0;
    }

    .feature-list li {
        padding: 8px 0;
        color: #666;
        border-bottom: 1px solid #f0f0f0;
    }

    .feature-list li:last-child {
        border-bottom: none;
    }

    .feature-list i {
        color: var(--primary-gold);
        margin-right: 10px;
        width: 20px;
    }

    .plan-selector {
        margin-top: 2rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
    }

    .plan-selector h6 {
        color: var(--primary-red);
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .plan-option {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 15px;
        margin-bottom: 8px;
        background: white;
        border-radius: 8px;
        border: 2px solid transparent;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .plan-option:hover {
        border-color: var(--primary-gold);
    }

    .plan-option.current {
        border-color: var(--primary-red);
        background: rgba(218, 32, 27, 0.05);
    }

    .plan-option-name {
        font-weight: 600;
        color: var(--primary-red);
        font-size: 0.9rem;
    }

    .plan-option-price {
        font-size: 0.8rem;
        color: #666;
    }

    .plan-option i {
        color: var(--primary-gold);
        margin-right: 8px;
    }
</style>
@endpush

@section('content')
<!-- Checkout Hero -->
<section class="checkout-hero">
    <div class="container">
        <h1>{{ __('plans.checkout.title') }}</h1>
        <p>{{ __('plans.checkout.subtitle') }} {{ $plan->nombre }}</p>
    </div>
</section>

<!-- Checkout Content -->
<section class="checkout-content">
    <div class="container">
        <div class="row">
            <!-- Plan Summary -->
            <div class="col-lg-5 mb-4">
                <div class="checkout-card plan-summary">
                    <div class="text-center">
                        <div class="plan-icon">
                            <i class="{{ $plan->icono }}"></i>
                        </div>
                        <h3 class="plan-name">{{ $plan->nombre }}</h3>
                    </div>

                    <!-- Price Selection -->
                    <div class="price-display">
                        <div class="price-cop selected" data-currency="COP" data-price="{{ $plan->precioPesos }}">
                            <div class="price-amount">${{ number_format($plan->precioPesos, 0, ',', '.') }}</div>
                            <div>Pesos Colombianos</div>
                        </div>
                        <div class="price-usd" data-currency="USD" data-price="{{ $plan->preciosDolar }}">
                            <div class="price-amount">${{ number_format($plan->preciosDolar, 0, ',', '.') }}</div>
                            <div>Dólares Americanos</div>
                        </div>
                    </div>

                    <!-- Features -->
                    <div class="feature-list">
                        <h5 style="color: var(--primary-red); margin-bottom: 1rem;">{{ __('plans.checkout.includes') }}</h5>
                        {!! $plan->descripcion !!}
                    </div>

                    <!-- Plan Selector -->
                    <div class="plan-selector">
                        <h6>{{ __('plans.checkout.change_plan') }}</h6>
                        @foreach($availablePlans as $availablePlan)
                            <div class="plan-option {{ $availablePlan->idPlan === $plan->idPlan ? 'current' : '' }}" 
                                 data-slug="{{ $availablePlan->slug }}"
                                 onclick="changePlan('{{ $availablePlan->slug }}')">
                                <div>
                                    <i class="{{ $availablePlan->icono }}"></i>
                                    <span class="plan-option-name">{{ $availablePlan->nombre }}</span>
                                </div>
                                <div class="plan-option-price">
                                    <span class="price-cop-display">${{ number_format($availablePlan->precioPesos, 0, ',', '.') }} COP</span>
                                    <span class="price-usd-display" style="display: none;">${{ number_format($availablePlan->preciosDolar, 0, ',', '.') }} USD</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Checkout Form -->
            <div class="col-lg-7">
                <div class="checkout-card">
                    <h3 style="color: var(--primary-red); margin-bottom: 2rem;">{{ __('plans.checkout.contact_info') }}</h3>
                    
                    <form method="POST" action="{{ route('checkout.process', ['locale' => app()->getLocale(), 'planSlug' => $plan->slug]) }}" class="checkout-form" id="checkout-form">
                        @csrf
                        
                        <input type="hidden" name="currency" id="selected-currency" value="COP">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombrecontacto">{{ __('plans.checkout.name') }} *</label>
                                    <input type="text" class="form-control" id="nombrecontacto" name="nombrecontacto" required value="{{ old('nombrecontacto') }}">
                                    @error('nombrecontacto')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">{{ __('plans.checkout.email') }} *</label>
                                    <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="movil">{{ __('plans.checkout.phone') }} *</label>
                                    <input type="tel" class="form-control" id="movil" name="movil" required value="{{ old('movil') }}" placeholder="{{ __('plans.checkout.phone_placeholder') }}">
                                    @error('movil')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sitioweb">{{ __('plans.checkout.website') }}</label>
                                    <input type="text" class="form-control" id="sitioweb" name="sitioweb" value="{{ old('sitioweb') }}" placeholder="{{ __('plans.checkout.website_placeholder') }}">
                                    @error('sitioweb')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>
                                <input type="checkbox" required> 
                                {{ __('plans.checkout.terms') }} *
                            </label>
                        </div>

                        <button type="submit" class="submit-btn">
                            <i class="fas fa-paper-plane me-2"></i>
                            {{ __('plans.checkout.submit') }}
                        </button>

                        <div class="text-center mt-3">
                            <small class="text-muted">
                                {{ __('plans.checkout.contact_note') }}
                            </small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceCop = document.querySelector('.price-cop');
    const priceUsd = document.querySelector('.price-usd');
    const currencyInput = document.getElementById('selected-currency');
    const form = document.getElementById('checkout-form');
    
    // Manejar envío del formulario con AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        // Deshabilitar botón y mostrar loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Limpiar cookies del formulario
                document.cookie = 'checkout_form=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                
                // Mostrar SweetAlert2
                Swal.fire({
                    title: '{{ __("plans.checkout_success_title") }}',
                    text: '{{ __("plans.checkout_success_text") }}',
                    icon: 'success',
                    confirmButtonText: '{{ __("plans.checkout_success_button") }}',
                    confirmButtonColor: '#DAA520',
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Iniciar proceso de pago con Wompi
                        console.log('Usuario confirmó, iniciando proceso de pago con Wompi...');
                        procesarPagoWompi(data.carrito_id);
                    }
                });
            } else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Ocurrió un error al procesar la solicitud',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al enviar la información. Por favor, inténtelo de nuevo.',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
        })
        .finally(() => {
            // Restaurar botón
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });
    
    // Manejo de selección de precio
    priceCop.addEventListener('click', function() {
        priceCop.classList.add('selected');
        priceUsd.classList.remove('selected');
        currencyInput.value = 'COP';
        updatePlanSelectorPrices('COP');
        saveFormDataToCookies();
    });
    
    priceUsd.addEventListener('click', function() {
        priceUsd.classList.add('selected');
        priceCop.classList.remove('selected');
        currencyInput.value = 'USD';
        updatePlanSelectorPrices('USD');
        saveFormDataToCookies();
    });

    // Actualizar precios en el selector de planes
    function updatePlanSelectorPrices(currency) {
        const copPrices = document.querySelectorAll('.price-cop-display');
        const usdPrices = document.querySelectorAll('.price-usd-display');
        
        if (currency === 'COP') {
            copPrices.forEach(p => p.style.display = 'inline');
            usdPrices.forEach(p => p.style.display = 'none');
        } else {
            copPrices.forEach(p => p.style.display = 'none');
            usdPrices.forEach(p => p.style.display = 'inline');
        }
    }

    // Guardar datos del formulario en cookies
    function saveFormDataToCookies() {
        const formData = {
            nombrecontacto: document.getElementById('nombrecontacto').value,
            email: document.getElementById('email').value,
            movil: document.getElementById('movil').value,
            sitioweb: document.getElementById('sitioweb').value,
            currency: currencyInput.value
        };
        
        document.cookie = `checkout_form=${encodeURIComponent(JSON.stringify(formData))}; path=/; max-age=3600`; // 1 hora
    }

    // Cargar datos desde cookies
    function loadFormDataFromCookies() {
        const cookies = document.cookie.split(';');
        const checkoutCookie = cookies.find(cookie => cookie.trim().startsWith('checkout_form='));
        
        if (checkoutCookie) {
            try {
                const formData = JSON.parse(decodeURIComponent(checkoutCookie.split('=')[1]));
                
                document.getElementById('nombrecontacto').value = formData.nombrecontacto || '';
                document.getElementById('email').value = formData.email || '';
                document.getElementById('movil').value = formData.movil || '';
                document.getElementById('sitioweb').value = formData.sitioweb || '';
                
                if (formData.currency) {
                    currencyInput.value = formData.currency;
                    if (formData.currency === 'USD') {
                        priceUsd.classList.add('selected');
                        priceCop.classList.remove('selected');
                        updatePlanSelectorPrices('USD');
                    } else {
                        priceCop.classList.add('selected');
                        priceUsd.classList.remove('selected');
                        updatePlanSelectorPrices('COP');
                    }
                }
            } catch (e) {
                console.log('Error loading form data from cookies:', e);
            }
        }
    }

    // Guardar datos cuando el usuario escriba en los campos
    ['nombrecontacto', 'email', 'movil', 'sitioweb'].forEach(fieldId => {
        const field = document.getElementById(fieldId);
        field.addEventListener('input', saveFormDataToCookies);
        field.addEventListener('blur', saveFormDataToCookies);
    });

    // Cargar datos al cargar la página
    loadFormDataFromCookies();

    // Función para procesar pago con Wompi
    async function procesarPagoWompi(carritoId) {
        try {
            // Mostrar loading
            Swal.fire({
                title: '{{ __("plans.processing_payment") }}',
                text: '{{ __("plans.processing_payment_text") }}',
                icon: 'info',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Crear transacción en Wompi
            const response = await fetch('/api/payments/wompi/create-transaction', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    carrito_id: carritoId
                })
            });

            const data = await response.json();

            if (data.success && data.data && data.data.checkout_url) {
                // Cerrar el loading y mostrar mensaje de redirección
                Swal.fire({
                    title: '{{ __("plans.redirecting_to_payment") }}',
                    text: '{{ __("plans.redirecting_to_wompi") }}',
                    icon: 'success',
                    timer: 1500,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        // Redirigir inmediatamente a Wompi
                        setTimeout(() => {
                            window.location.href = data.data.checkout_url;
                        }, 500);
                    }
                });
            } else {
                // Error al crear transacción
                Swal.fire({
                    title: 'Error',
                    text: data.message || '{{ __("plans.payment_error") }}',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#dc3545'
                });
            }
        } catch (error) {
            console.error('Error al procesar pago:', error);
            Swal.fire({
                title: 'Error',
                text: '{{ __("plans.payment_error_network") }}',
                icon: 'error',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc3545'
            });
        }
    }
});

// Función global para cambiar de plan
function changePlan(planSlug) {
    // Guardar datos del formulario antes de cambiar
    const formData = {
        nombrecontacto: document.getElementById('nombrecontacto').value,
        email: document.getElementById('email').value,
        movil: document.getElementById('movil').value,
        sitioweb: document.getElementById('sitioweb').value,
        currency: document.getElementById('selected-currency').value
    };
    
    document.cookie = `checkout_form=${encodeURIComponent(JSON.stringify(formData))}; path=/; max-age=3600`;
    
    // Redirigir al nuevo plan
    const currentLocale = '{{ app()->getLocale() }}';
    window.location.href = `/${currentLocale}/checkout/${planSlug}`;
}
</script>
@endsection