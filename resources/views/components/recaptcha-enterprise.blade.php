@if(config('app.recaptcha.site_key'))
<div class="recaptcha-v3-container mb-3">
    <!-- Campo oculto para el token -->
    <input type="hidden" name="recaptcha_token" id="recaptcha_token" value="">
    
    <!-- Mensaje de error -->
    <div id="recaptcha-error" class="text-danger small mt-2" style="display: none;">
        <i class="bi bi-exclamation-circle me-1"></i>
        <span>Por favor complete la verificación de seguridad para continuar</span>
    </div>
    
    @error('recaptcha_token')
        <div class="text-danger small mt-2">
            <i class="bi bi-exclamation-circle me-1"></i>
            {{ $message }}
        </div>
    @enderror
    
    <!-- Indicador de protección -->
    <div class="text-muted small text-end mt-1">
        <small>🛡️ Protegido por reCAPTCHA</small>
    </div>
</div>

<!-- Script directo en HEAD -->
<script src="https://www.google.com/recaptcha/enterprise.js?render={{ config('app.recaptcha.site_key') }}" async defer></script>

<script>
(function() {
    const SITE_KEY = '{{ config('app.recaptcha.site_key') }}';
    const ACTION = '{{ $action ?? 'SUBMIT' }}';
    let isReady = false;
    
    // Función para cuando reCAPTCHA esté listo
    window.onRecaptchaReady = function() {
        if (typeof grecaptcha !== 'undefined' && grecaptcha.enterprise) {
            grecaptcha.enterprise.ready(function() {
                console.log('✅ reCAPTCHA Enterprise listo para:', ACTION);
                isReady = true;
                hideError();
            });
        }
    };
    
    // Auto-llamar cuando se carga el script
    if (typeof grecaptcha !== 'undefined') {
        window.onRecaptchaReady();
    } else {
        // Esperar a que se cargue
        setTimeout(function() {
            if (typeof grecaptcha !== 'undefined') {
                window.onRecaptchaReady();
            }
        }, 1000);
    }
    
    // Ejecutar reCAPTCHA
    async function executeRecaptcha() {
        if (!isReady) {
            console.warn('⚠️ reCAPTCHA no está listo aún');
            showError('Verificación de seguridad no está lista. Espera un momento.');
            return null;
        }
        
        try {
            console.log('🔄 Ejecutando reCAPTCHA...');
            const token = await grecaptcha.enterprise.execute(SITE_KEY, {
                action: ACTION
            });
            
            console.log('✅ Token generado:', token.substring(0, 20) + '...');
            
            // Guardar token
            const tokenField = document.getElementById('recaptcha_token');
            if (tokenField) {
                tokenField.value = token;
            }
            
            return token;
        } catch (error) {
            console.error('❌ Error en reCAPTCHA:', error);
            showError('Error en la verificación de seguridad');
            return null;
        }
    }
    
    function showError(message) {
        const errorEl = document.getElementById('recaptcha-error');
        if (errorEl) {
            errorEl.querySelector('span').textContent = message;
            errorEl.style.display = 'block';
        }
    }
    
    function hideError() {
        const errorEl = document.getElementById('recaptcha-error');
        if (errorEl) {
            errorEl.style.display = 'none';
        }
    }
    
    // Configurar manejo de formularios
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        if (!form) return;
        
        const recaptchaContainer = form.querySelector('.recaptcha-v3-container');
        if (!recaptchaContainer) return;
        
        console.log('🔧 Configurando interceptor de formulario para:', ACTION);
        
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            console.log('📝 Formulario enviado, ejecutando reCAPTCHA...');
            
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.textContent : '';
            
            // Cambiar botón
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = 'Verificando seguridad...';
            }
            
            // Ejecutar reCAPTCHA
            const token = await executeRecaptcha();
            
            if (token) {
                console.log('✅ Verificación exitosa, enviando formulario...');
                hideError();
                
                // Enviar formulario real
                const newForm = document.createElement('form');
                newForm.method = form.method;
                newForm.action = form.action;
                
                // Copiar todos los campos
                const formData = new FormData(form);
                for (let [key, value] of formData.entries()) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = value;
                    newForm.appendChild(input);
                }
                
                // Añadir token de reCAPTCHA
                const tokenInput = document.createElement('input');
                tokenInput.type = 'hidden';
                tokenInput.name = 'recaptcha_token';
                tokenInput.value = token;
                newForm.appendChild(tokenInput);
                
                document.body.appendChild(newForm);
                newForm.submit();
            } else {
                console.log('❌ Verificación falló');
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }
                showError('No se pudo completar la verificación. Inténtalo de nuevo.');
            }
        });
    });
})();
</script>

@else
<!-- reCAPTCHA no configurado -->
<div class="alert alert-warning small" role="alert">
    <i class="bi bi-exclamation-triangle me-1"></i>
    <strong>Aviso:</strong> La verificación de seguridad no está configurada.
</div>
@endif