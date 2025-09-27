@if(config('app.recaptcha.site_key'))
<div class="recaptcha-container mb-3" id="recaptcha-container">
    <div class="g-recaptcha" 
         data-sitekey="{{ config('app.recaptcha.site_key') }}"
         data-theme="{{ $theme ?? 'light' }}"
         data-size="{{ $size ?? 'normal' }}"
         data-callback="onRecaptchaSuccess"
         data-expired-callback="onRecaptchaExpired">
    </div>
    
    <div id="recaptcha-error" class="invalid-feedback d-block mt-2" style="display: none;">
        <i class="bi bi-exclamation-circle me-1"></i>
        <span>Por favor complete la verificación de reCAPTCHA</span>
    </div>
    
    @error('recaptcha')
        <div class="invalid-feedback d-block mt-2">
            <i class="bi bi-exclamation-circle me-1"></i>
            {{ $message }}
        </div>
    @enderror
</div>

@push('head')
    <script src="https://www.google.com/recaptcha/api.js?onload=onRecaptchaLoad&render=explicit" async defer></script>
@endpush

@push('scripts')
<script>
    let recaptchaWidget = null;
    
    // Callback cuando la API de reCAPTCHA se carga
    function onRecaptchaLoad() {
        console.log('reCAPTCHA API loaded');
        const recaptchaElement = document.querySelector('.g-recaptcha');
        if (recaptchaElement && typeof grecaptcha !== 'undefined') {
            try {
                recaptchaWidget = grecaptcha.render(recaptchaElement, {
                    'sitekey': recaptchaElement.getAttribute('data-sitekey'),
                    'theme': recaptchaElement.getAttribute('data-theme') || 'light',
                    'size': recaptchaElement.getAttribute('data-size') || 'normal',
                    'callback': onRecaptchaSuccess,
                    'expired-callback': onRecaptchaExpired
                });
                console.log('reCAPTCHA rendered successfully', recaptchaWidget);
            } catch (error) {
                console.error('Error rendering reCAPTCHA:', error);
                showRecaptchaError('Error al cargar la verificación de seguridad');
            }
        }
    }
    
    // Callback cuando reCAPTCHA se completa exitosamente
    function onRecaptchaSuccess(token) {
        console.log('reCAPTCHA verified successfully');
        
        // Habilitar botón de envío
        const submitButton = document.querySelector('button[type="submit"], input[type="submit"]');
        if (submitButton) {
            submitButton.disabled = false;
            submitButton.classList.remove('disabled');
        }
        
        // Ocultar mensajes de error
        hideRecaptchaError();
        
        // Disparar event personalizado
        document.dispatchEvent(new CustomEvent('recaptchaVerified', { detail: { token } }));
    }
    
    // Callback cuando reCAPTCHA expira
    function onRecaptchaExpired() {
        console.log('reCAPTCHA expired');
        
        // Deshabilitar botón de envío
        const submitButton = document.querySelector('button[type="submit"], input[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.classList.add('disabled');
        }
        
        showRecaptchaError('La verificación ha expirado. Por favor, inténtalo de nuevo.');
        
        // Disparar event personalizado
        document.dispatchEvent(new CustomEvent('recaptchaExpired'));
    }
    
    // Mostrar error de reCAPTCHA
    function showRecaptchaError(message) {
        const errorElement = document.getElementById('recaptcha-error');
        if (errorElement) {
            errorElement.querySelector('span').textContent = message;
            errorElement.style.display = 'block';
        }
    }
    
    // Ocultar error de reCAPTCHA
    function hideRecaptchaError() {
        const errorElement = document.getElementById('recaptcha-error');
        if (errorElement) {
            errorElement.style.display = 'none';
        }
    }
    
    // Inicializar cuando el DOM esté listo
    document.addEventListener('DOMContentLoaded', function() {
        // Deshabilitar botón de envío inicialmente si hay reCAPTCHA
        const submitButton = document.querySelector('button[type="submit"], input[type="submit"]');
        const recaptchaContainer = document.querySelector('.recaptcha-container');
        
        if (submitButton && recaptchaContainer) {
            submitButton.disabled = true;
            submitButton.classList.add('disabled');
        }
        
        // Verificar antes del envío del formulario
        const form = document.querySelector('form');
        if (form && recaptchaContainer) {
            form.addEventListener('submit', function(e) {
                if (typeof grecaptcha !== 'undefined') {
                    const response = grecaptcha.getResponse(recaptchaWidget);
                    if (!response || response.length === 0) {
                        e.preventDefault();
                        showRecaptchaError('Por favor complete la verificación de seguridad');
                        return false;
                    }
                }
            });
        }
    });
    
    // Función para resetear reCAPTCHA
    function resetRecaptcha() {
        if (typeof grecaptcha !== 'undefined' && recaptchaWidget !== null) {
            grecaptcha.reset(recaptchaWidget);
            
            // Deshabilitar botón de envío
            const submitButton = document.querySelector('button[type="submit"], input[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.classList.add('disabled');
            }
        }
    }
    
    // Función para verificar si reCAPTCHA está completado
    function isRecaptchaCompleted() {
        if (typeof grecaptcha !== 'undefined' && recaptchaWidget !== null) {
            const response = grecaptcha.getResponse(recaptchaWidget);
            return response && response.length > 0;
        }
        return false;
    }
</script>
@endpush

<style>
    .recaptcha-container .g-recaptcha {
        margin: 10px 0;
    }
    
    .recaptcha-container .invalid-feedback {
        font-size: 0.875em;
        color: #dc3545;
    }
    
    .recaptcha-container .recaptcha-info {
        font-size: 0.875em;
        color: #6c757d;
        margin-top: 8px;
    }
    
    /* Responsive para móviles */
    @media (max-width: 576px) {
        .recaptcha-container .g-recaptcha {
            transform: scale(0.77);
            transform-origin: 0 0;
            margin-bottom: 15px;
        }
    }
    
    /* Estilo para botones deshabilitados */
    button.disabled, input.disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>
@else
<!-- reCAPTCHA no configurado -->
<div class="alert alert-warning small" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i>
    <strong>Nota:</strong> La verificación de seguridad no está configurada en este entorno.
</div>
@endif