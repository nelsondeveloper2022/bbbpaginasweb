@extends('layouts.dashboard')

@section('title', 'Crear Pasarela de Pago - BBB Páginas Web')
@section('description', 'Configurar una nueva pasarela de pago')

@section('content')
<div class="content-header">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="dashboard-title">
                <i class="bi bi-plus-circle text-primary-gold me-2"></i>
                Nueva Pasarela de Pago
            </h1>
            <p class="text-muted mb-0">Configura una nueva pasarela para recibir pagos online</p>
        </div>
        <div>
                        <a href="{{ route('admin.pagos.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <form action="{{ route('admin.pagos.pasarelas.store') }}" method="POST" id="pasarelaForm">
            @csrf
            
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-gear me-2"></i>
                        Configuración de la Pasarela
                    </h5>
                </div>
                <div class="card-body">
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="pasarela" class="form-label">
                                        Tipo de Pasarela <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('pasarela') is-invalid @enderror" 
                                            id="pasarela" 
                                            name="pasarela" 
                                            required
                                            onchange="mostrarCamposPasarela()">
                                        <option value="">Selecciona una pasarela</option>
                                        <option value="wompi" {{ old('pasarela') === 'wompi' ? 'selected' : '' }}>
                                            Wompi
                                        </option>
                                        <option value="payu" {{ old('pasarela') === 'payu' ? 'selected' : '' }}>
                                            PayU
                                        </option>
                                        <option value="stripe" {{ old('pasarela') === 'stripe' ? 'selected' : '' }}>
                                            Stripe
                                        </option>
                                        <option value="mercado_pago" {{ old('pasarela') === 'mercado_pago' ? 'selected' : '' }}>
                                            MercadoPago
                                        </option>
                                        <option value="paypal" {{ old('pasarela') === 'paypal' ? 'selected' : '' }}>
                                            PayPal
                                        </option>
                                    </select>
                                    @error('pasarela')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="environment" class="form-label">
                                        Entorno <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('environment') is-invalid @enderror" 
                                            id="environment" 
                                            name="environment" 
                                            required>
                                        <option value="sandbox" {{ old('environment', 'sandbox') === 'sandbox' ? 'selected' : '' }}>
                                            Sandbox (Pruebas)
                                        </option>
                                        <option value="production" {{ old('environment') === 'production' ? 'selected' : '' }}>
                                            Producción
                                        </option>
                                    </select>
                                    @error('environment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="public_key" class="form-label">
                                    Clave Pública <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('public_key') is-invalid @enderror" 
                                       id="public_key" 
                                       name="public_key" 
                                       value="{{ old('public_key') }}" 
                                       required
                                       placeholder="Ingresa la clave pública">
                                @error('public_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text" id="public_key_help">
                                    Esta clave es pública y se puede mostrar en el frontend
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6">
                            <div class="mb-3">
                                <label for="private_key" class="form-label">
                                    Clave Privada <span class="text-danger">*</span>
                                </label>
                                <input type="password" 
                                       class="form-control @error('private_key') is-invalid @enderror" 
                                       id="private_key" 
                                       name="private_key" 
                                       value="{{ old('private_key') }}" 
                                       required
                                       placeholder="Ingresa la clave privada">
                                @error('private_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text" id="private_key_help">
                                    Esta clave es secreta y no se debe compartir
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campos específicos para Wompi -->
                    <div id="wompi-fields" style="display: none;">
                        <hr>
                        <h6 class="text-primary-gold mb-3">
                            <i class="bi bi-credit-card me-2"></i>
                            Configuración Wompi
                        </h6>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               role="switch" 
                                               id="sandbox" 
                                               name="sandbox"
                                               value="1"
                                               {{ old('sandbox', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sandbox">
                                            <strong>Modo Sandbox (Pruebas)</strong>
                                        </label>
                                    </div>
                                    <div class="form-text">
                                        Activa esto para realizar pruebas sin dinero real
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="webhook_url" class="form-label">URL del Webhook</label>
                                    <input type="url" 
                                           class="form-control @error('webhook_url') is-invalid @enderror" 
                                           id="webhook_url" 
                                           name="webhook_url" 
                                           value="{{ old('webhook_url') }}" 
                                           placeholder="https://tudominio.com/webhook/wompi">
                                    @error('webhook_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        URL donde Wompi enviará las notificaciones de pago
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Campos específicos para otras pasarelas -->
                    <div id="other-fields" style="display: none;">
                        <hr>
                        <h6 class="text-primary-gold mb-3">
                            <i class="bi bi-gear me-2"></i>
                            Configuración Adicional
                        </h6>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="merchant_id" class="form-label">ID del Comerciante</label>
                                    <input type="text" 
                                           class="form-control @error('merchant_id') is-invalid @enderror" 
                                           id="merchant_id" 
                                           name="merchant_id" 
                                           value="{{ old('merchant_id') }}" 
                                           placeholder="ID proporcionado por la pasarela">
                                    @error('merchant_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="mb-3">
                                    <label for="api_key" class="form-label">API Key</label>
                                    <input type="text" 
                                           class="form-control @error('api_key') is-invalid @enderror" 
                                           id="api_key" 
                                           name="api_key" 
                                           value="{{ old('api_key') }}" 
                                           placeholder="Clave API adicional (si aplica)">
                                    @error('api_key')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.pagos.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary-gold">
                            <i class="bi bi-check-circle me-1"></i>
                            Configurar Pasarela
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="col-lg-4">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>
                    Información de la Pasarela
                </h6>
            </div>
            <div class="card-body" id="pasarela-info">
                <div class="text-center text-muted py-4">
                    <i class="bi bi-arrow-up-left" style="font-size: 2rem;"></i>
                    <p class="mt-2 mb-0">Selecciona una pasarela para ver más información</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const pasarelaInfo = {
    wompi: {
        name: 'Wompi',
        description: 'Pasarela de pagos colombiana que permite recibir pagos con tarjetas de crédito y débito.',
        features: [
            'Tarjetas de crédito y débito',
            'PSE (Pagos Seguros en Línea)',
            'Bancolombia Button',
            'Nequi'
        ],
        countries: ['Colombia'],
        currencies: ['COP'],
        website: 'https://wompi.co',
        publicKeyFormat: 'pub_test_xxxxxxx o pub_prod_xxxxxxx',
        privateKeyFormat: 'prv_test_xxxxxxx o prv_prod_xxxxxxx'
    },
    payu: {
        name: 'PayU',
        description: 'Procesador de pagos para Latinoamérica con amplia cobertura regional.',
        features: [
            'Tarjetas de crédito y débito',
            'Transferencias bancarias',
            'Pagos en efectivo',
            'Billeteras digitales'
        ],
        countries: ['Colombia', 'Perú', 'México', 'Argentina', 'Brasil', 'Chile'],
        currencies: ['COP', 'PEN', 'MXN', 'ARS', 'BRL', 'CLP', 'USD'],
        website: 'https://payu.com',
        publicKeyFormat: 'Clave pública del comerciante',
        privateKeyFormat: 'Clave secreta del comerciante'
    },
    stripe: {
        name: 'Stripe',
        description: 'Plataforma de pagos global con amplia gama de funcionalidades.',
        features: [
            'Tarjetas de crédito y débito',
            'Apple Pay / Google Pay',
            'SEPA Direct Debit',
            'Transferencias bancarias'
        ],
        countries: ['Global (40+ países)'],
        currencies: ['135+ monedas'],
        website: 'https://stripe.com',
        publicKeyFormat: 'pk_test_xxxxxxx o pk_live_xxxxxxx',
        privateKeyFormat: 'sk_test_xxxxxxx o sk_live_xxxxxxx'
    },
    mercadopago: {
        name: 'MercadoPago',
        description: 'Solución de pagos de MercadoLibre para Latinoamérica.',
        features: [
            'Tarjetas de crédito y débito',
            'Dinero en cuenta de MercadoPago',
            'Pagos en efectivo',
            'Cuotas sin interés'
        ],
        countries: ['Argentina', 'Brasil', 'Chile', 'Colombia', 'México', 'Perú', 'Uruguay'],
        currencies: ['ARS', 'BRL', 'CLP', 'COP', 'MXN', 'PEN', 'UYU'],
        website: 'https://mercadopago.com',
        publicKeyFormat: 'Access Token público',
        privateKeyFormat: 'Access Token privado'
    },
    paypal: {
        name: 'PayPal',
        description: 'Plataforma de pagos digitales global con amplio reconocimiento.',
        features: [
            'Cuenta PayPal',
            'Tarjetas de crédito y débito',
            'PayPal Credit',
            'Venmo (EE.UU.)'
        ],
        countries: ['Global (200+ países)'],
        currencies: ['100+ monedas'],
        website: 'https://paypal.com',
        publicKeyFormat: 'Client ID',
        privateKeyFormat: 'Client Secret'
    }
};

function updatePasarelaFields() {
    const select = document.getElementById('nombre_pasarela');
    const selectedPasarela = select.value;
    
    // Ocultar todos los campos específicos
    document.getElementById('wompi-fields').style.display = 'none';
    document.getElementById('other-fields').style.display = 'none';
    
    // Actualizar información de la pasarela
    updatePasarelaInfo(selectedPasarela);
    
    // Mostrar campos específicos según la pasarela
    if (selectedPasarela === 'wompi') {
        document.getElementById('wompi-fields').style.display = 'block';
    } else if (selectedPasarela && selectedPasarela !== 'wompi') {
        document.getElementById('other-fields').style.display = 'block';
    }
    
    // Actualizar placeholders y ayudas
    updateFieldHelpers(selectedPasarela);
}

function updatePasarelaInfo(pasarela) {
    const infoContainer = document.getElementById('pasarela-info');
    
    if (!pasarela || !pasarelaInfo[pasarela]) {
        infoContainer.innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="bi bi-arrow-up-left" style="font-size: 2rem;"></i>
                <p class="mt-2 mb-0">Selecciona una pasarela para ver más información</p>
            </div>
        `;
        return;
    }
    
    const info = pasarelaInfo[pasarela];
    
    infoContainer.innerHTML = `
        <div class="text-center mb-3">
            <h5 class="text-primary-gold">${info.name}</h5>
            <p class="small text-muted">${info.description}</p>
        </div>
        
        <div class="mb-3">
            <h6 class="text-primary-gold">🌟 Métodos de pago</h6>
            <ul class="small text-muted list-unstyled">
                ${info.features.map(feature => `<li>• ${feature}</li>`).join('')}
            </ul>
        </div>
        
        <div class="mb-3">
            <h6 class="text-primary-gold">🌎 Países</h6>
            <p class="small text-muted">${info.countries.join(', ')}</p>
        </div>
        
        <div class="mb-3">
            <h6 class="text-primary-gold">💰 Monedas</h6>
            <p class="small text-muted">${info.currencies.join(', ')}</p>
        </div>
        
        <div class="mb-3">
            <h6 class="text-primary-gold">🔗 Sitio web</h6>
            <a href="${info.website}" target="_blank" class="small text-primary">
                ${info.website} <i class="bi bi-box-arrow-up-right"></i>
            </a>
        </div>
        
        <div class="alert alert-info small">
            <strong>Formato de claves:</strong><br>
            <strong>Pública:</strong> ${info.publicKeyFormat}<br>
            <strong>Privada:</strong> ${info.privateKeyFormat}
        </div>
    `;
}

function updateFieldHelpers(pasarela) {
    const publicKeyHelp = document.getElementById('public_key_help');
    const privateKeyHelp = document.getElementById('private_key_help');
    
    if (pasarela && pasarelaInfo[pasarela]) {
        const info = pasarelaInfo[pasarela];
        publicKeyHelp.textContent = `Formato: ${info.publicKeyFormat}`;
        privateKeyHelp.textContent = `Formato: ${info.privateKeyFormat}`;
    } else {
        publicKeyHelp.textContent = 'Esta clave es pública y se puede mostrar en el frontend';
        privateKeyHelp.textContent = 'Esta clave es secreta y no se debe compartir';
    }
}

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    updatePasarelaFields();
});
</script>
@endpush