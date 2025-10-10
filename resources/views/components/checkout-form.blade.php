{{-- Formulario de información del cliente para checkout --}}
<div class="checkout-card">
    <h3 class="section-title">Información del cliente</h3>
    <form id="checkout-form" method="POST" action="{{ route('public.checkout.process', $empresa->slug) }}">
        @csrf
        {{-- Los items del carrito y total se enviarán vía JavaScript --}}
        <input type="hidden" name="items" id="cart-items" value="">
        <input type="hidden" name="total" id="cart-total" value="0">
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre">Nombre completo *</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required 
                           value="{{ old('nombre') }}" placeholder="Ingrese su nombre completo">
                    @error('nombre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Correo electrónico *</label>
                    <input type="email" id="email" name="email" class="form-control" required 
                           value="{{ old('email') }}" placeholder="ejemplo@correo.com">
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="documento">Documento de identidad *</label>
                    <input type="text" id="documento" name="documento" class="form-control" required 
                           value="{{ old('documento') }}" placeholder="Número de documento">
                    @error('documento')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="telefono">Teléfono *</label>
                    <input type="tel" id="telefono" name="telefono" class="form-control" required 
                           value="{{ old('telefono') }}" placeholder="Ej: 3001234567">
                    @error('telefono')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="terms" required> 
                Acepto los términos y condiciones *
            </label>
            @error('terms')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100" id="submit-btn">
            <i class="fas fa-credit-card me-2"></i>
            Procesar Pago
        </button>

        <div class="text-center mt-3">
            <small class="text-muted">
                <i class="fas fa-shield-alt me-1"></i>
                Pago 100% seguro procesado por Wompi
            </small>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('submit-btn');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validar que hay items en el carrito
            const cartItems = getCartItems(); // Esta función debe existir en la página de la tienda
            const cartTotal = getCartTotal(); // Esta función debe existir en la página de la tienda
            
            if (!cartItems || cartItems.length === 0) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Carrito vacío',
                        text: 'Debe agregar al menos un producto al carrito antes de proceder al pago.',
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#ffc107'
                    });
                } else {
                    alert('Debe agregar al menos un producto al carrito antes de proceder al pago.');
                }
                return false;
            }
            
            // Actualizar campos ocultos con datos del carrito
            document.getElementById('cart-items').value = JSON.stringify(cartItems);
            document.getElementById('cart-total').value = cartTotal;
            
            // Validar campos requeridos
            const requiredFields = [
                { id: 'nombre', name: 'Nombre completo' },
                { id: 'email', name: 'Correo electrónico' },
                { id: 'documento', name: 'Documento de identidad' },
                { id: 'telefono', name: 'Teléfono' }
            ];
            
            let isValid = true;
            let errorMessage = '';
            
            // Remover mensajes de error previos
            document.querySelectorAll('.field-error').forEach(el => el.remove());
            
            for (const field of requiredFields) {
                const input = document.getElementById(field.id);
                if (!input.value.trim()) {
                    isValid = false;
                    errorMessage += `• ${field.name} es requerido\n`;
                    
                    // Agregar clase de error y mensaje
                    input.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'text-danger mt-1 field-error';
                    errorDiv.textContent = `${field.name} es requerido`;
                    input.parentNode.appendChild(errorDiv);
                } else {
                    input.classList.remove('is-invalid');
                }
            }
            
            // Validar checkbox de términos
            const termsCheckbox = document.querySelector('input[name="terms"]');
            if (!termsCheckbox.checked) {
                isValid = false;
                errorMessage += '• Debe aceptar los términos y condiciones\n';
                
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-danger mt-1 field-error';
                errorDiv.textContent = 'Debe aceptar los términos y condiciones';
                termsCheckbox.parentNode.parentNode.appendChild(errorDiv);
            }
            
            // Validar formato de email
            const emailInput = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailInput.value.trim() && !emailRegex.test(emailInput.value.trim())) {
                isValid = false;
                errorMessage += '• El formato del correo electrónico no es válido\n';
                
                emailInput.classList.add('is-invalid');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'text-danger mt-1 field-error';
                errorDiv.textContent = 'El formato del correo electrónico no es válido';
                emailInput.parentNode.appendChild(errorDiv);
            }
            
            if (!isValid) {
                // Mostrar alerta con errores
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Error en el formulario',
                        text: 'Por favor, corrija los siguientes errores:\n' + errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#dc3545'
                    });
                } else {
                    alert('Por favor, corrija los siguientes errores:\n' + errorMessage);
                }
                return false;
            }
            
            // Si todo está válido, deshabilitar botón y mostrar loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Procesando...';
            
            // Mostrar loading con SweetAlert
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Procesando pago',
                    text: 'Por favor espere mientras procesamos su información...',
                    icon: 'info',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
            
            // Enviar formulario
            this.submit();
        });
        
        // Remover clase de error cuando el usuario empiece a escribir
        document.querySelectorAll('#checkout-form input').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('is-invalid');
                const errorDiv = this.parentNode.querySelector('.field-error');
                if (errorDiv) {
                    errorDiv.remove();
                }
            });
        });
    }
    
    // Funciones auxiliares para el carrito - estas deben ser implementadas en la página de la tienda
    function getCartItems() {
        // Esta función debe retornar un array de objetos con la estructura:
        // [{ id: productId, cantidad: quantity, precio: price }]
        
        // Ejemplo de implementación si usas localStorage:
        const cart = JSON.parse(localStorage.getItem('cart') || '[]');
        return cart.map(item => ({
            id: item.id,
            cantidad: item.quantity || 1,
            precio: item.price || 0
        }));
        
        // O si usas una variable global:
        // return window.cartItems || [];
    }
    
    function getCartTotal() {
        // Esta función debe retornar el total del carrito
        const items = getCartItems();
        return items.reduce((total, item) => {
            return total + (item.precio * item.cantidad);
        }, 0);
    }
});
</script>

<style>
.checkout-card {
    background: white;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.section-title {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 1.5rem;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 0.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
    display: block;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    padding: 0.75rem 1rem;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    outline: none;
}

.form-control.is-invalid {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.2rem rgba(220,53,69,0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    border-radius: 8px;
    padding: 1rem 2rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.4);
}

.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

.text-danger {
    font-size: 0.875rem;
    font-weight: 500;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

@media (max-width: 768px) {
    .checkout-card {
        padding: 1.5rem;
        margin: 1rem;
    }
}
</style>