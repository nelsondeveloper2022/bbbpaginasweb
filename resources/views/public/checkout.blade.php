<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - {{ $empresa->nombre }}</title>
    <meta name="description" content="Finaliza tu compra en {{ $empresa->nombre }}">

    @php
        $favicon = (isset($landing) && $landing && $landing->logo_url)
            ? asset('storage/' . $landing->logo_url)
            : asset('favicon.ico');
    @endphp
    <link rel="icon" href="{{ $favicon }}" type="image/png">
    <link rel="apple-touch-icon" href="{{ $favicon }}">
    <meta name="theme-color" content="{{ isset($landing) && $landing ? $landing->color_principal : '#050505' }}">
    <meta property="og:image" content="{{ $favicon }}">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    @if(isset($landing) && $landing)
    <link href="https://fonts.googleapis.com/css2?family={{ str_replace(' ', '+', $landing->tipografia) }}:wght@300;400;600;700&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    @endif
    
    <style>
        :root {
            --primary-color: {{ isset($landing) && $landing ? $landing->color_principal : '#050505' }};
            --secondary-color: {{ isset($landing) && $landing ? ($landing->color_secundario ?? '#258a00') : '#258a00' }};
            --font-family: '{{ isset($landing) && $landing ? $landing->tipografia : 'Inter' }}', sans-serif;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: var(--font-family);
            background: #f8f9fa;
            color: #333;
            line-height: 1.6;
        }

        .checkout-header {
            background: var(--primary-color);
            color: white;
            padding: 2rem 0;
        }

        .checkout-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .checkout-container {
            padding: 2rem 0;
        }

        .checkout-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .section-title {
            color: var(--primary-color);
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--secondary-color);
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #eee;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 1rem;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.25rem;
        }

        .cart-item-price {
            color: var(--secondary-color);
            font-weight: 600;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0.5rem 0;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover {
            background: var(--secondary-color);
            color: white;
            border-color: var(--secondary-color);
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 0.25rem;
        }

        .total-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            margin-top: 1rem;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }

        .total-final {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            border-top: 2px solid #ddd;
            padding-top: 0.5rem;
            margin-top: 0.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 2px rgba(37, 138, 0, 0.1);
        }

        .btn-primary {
            background: var(--secondary-color);
            border: none;
            padding: 1rem 2rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-primary:hover {
            background: #1e6d00;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: #6c757d;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background: #545b62;
            color: white;
            text-decoration: none;
        }

        .empty-cart {
            text-align: center;
            padding: 3rem 1rem;
            color: #666;
        }

        .empty-cart i {
            font-size: 4rem;
            color: #ccc;
            margin-bottom: 1rem;
        }

        .remove-item {
            color: #dc3545;
            cursor: pointer;
            font-size: 1.2rem;
            margin-left: 1rem;
        }

        .remove-item:hover {
            color: #c82333;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.25);
        }

        .text-danger {
            color: #dc3545 !important;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .field-error {
            margin-top: 0.25rem;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid transparent;
        }

        .alert-danger ul {
            padding-left: 1.5rem;
        }

        @media (max-width: 768px) {
            .checkout-header h1 {
                font-size: 1.5rem;
            }
            
            .checkout-card {
                padding: 1rem;
                margin: 0 1rem 1rem;
            }
            
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .cart-item-image {
                align-self: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="checkout-header">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h1>Finalizar Compra</h1>
                    <p class="mb-0">{{ $empresa->nombre }}</p>
                </div>
                <a href="{{ route('public.tienda', $empresa->slug) }}" class="btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver a la tienda
                </a>
            </div>
        </div>
    </header>

    <!-- Mostrar errores de validación -->
    @if ($errors->any())
        <div class="container mt-3">
            <div class="alert alert-danger">
                <h6><i class="fas fa-exclamation-triangle me-2"></i>Por favor, corrija los siguientes errores:</h6>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="checkout-container">
        <div class="container">
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="checkout-card">
                        <h3 class="section-title">Resumen de tu pedido</h3>
                        <div id="cart-items">
                            <!-- Los items del carrito se cargarán aquí via JavaScript -->
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="checkout-card">
                        <h3 class="section-title">Información del cliente</h3>
                        <form id="checkout-form" method="POST" action="{{ route('public.checkout.process', $empresa->slug) }}">
                            @csrf
                            <input type="hidden" name="total" id="cart-total-input" value="0">
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nombre">Nombre completo *</label>
                                        <input type="text" id="nombre" name="nombre" class="form-control" required value="{{ old('nombre') }}">
                                        @error('nombre')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Correo electrónico *</label>
                                        <input type="email" id="email" name="email" class="form-control" required value="{{ old('email') }}">
                                        @error('email')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="documento">Documento de identidad *</label>
                                        <input type="text" id="documento" name="documento" class="form-control" required value="{{ old('documento') }}">
                                        @error('documento')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telefono">Teléfono *</label>
                                        <input type="tel" id="telefono" name="telefono" class="form-control" required value="{{ old('telefono') }}">
                                        @error('telefono')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="direccion">Dirección de entrega</label>
                                        <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Ingresa tu dirección completa" value="{{ old('direccion') }}">
                                        <small class="form-text text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Incluye barrio, referencias y detalles importantes para la entrega
                                        </small>
                                        @error('direccion')
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
                        </form>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="checkout-card">
                        <h3 class="section-title">Total del pedido</h3>
                        <div class="total-section">
                            <div class="total-row">
                                <span>Subtotal:</span>
                                <span id="checkout-subtotal">$0</span>
                            </div>
                            <div class="total-row">
                                <span>Envío:</span>
                                <span id="checkout-shipping">
                                    @if($empresa->flete && $empresa->flete > 0)
                                        ${{ number_format($empresa->flete, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </span>
                            </div>
                            <div class="total-row total-final">
                                <span>Total:</span>
                                <span id="checkout-total">$0</span>
                            </div>
                        </div>

                        <div class="mt-3">
                            <h5>Método de pago</h5>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-credit-card me-2" style="color: var(--secondary-color);"></i>
                                <span>Wompi (Tarjeta de crédito/débito)</span>
                            </div>
                        </div>

                        <button type="button" id="process-payment" class="btn-primary" disabled>
                            <i class="fas fa-lock me-2"></i>Procesar pago
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Carrito de compras - manejo del localStorage
        class ShoppingCart {
            constructor() {
                this.items = this.getCartFromStorage();
                this.updateCartDisplay();
                this.updateTotals();
                this.bindEvents();
            }

            getCartFromStorage() {
                const cart = localStorage.getItem('shopping_cart_{{ $empresa->slug }}');
                return cart ? JSON.parse(cart) : [];
            }

            saveCartToStorage() {
                localStorage.setItem('shopping_cart_{{ $empresa->slug }}', JSON.stringify(this.items));
            }

            updateCartDisplay() {
                const cartContainer = document.getElementById('cart-items');
                
                if (this.items.length === 0) {
                    cartContainer.innerHTML = `
                        <div class="empty-cart">
                            <i class="fas fa-shopping-cart"></i>
                            <h4>Tu carrito está vacío</h4>
                            <p>Agrega algunos productos desde la tienda para continuar.</p>
                            <a href="{{ route('public.tienda', $empresa->slug) }}" class="btn-primary" style="width: auto; padding: 0.75rem 1.5rem; margin-top: 1rem;">
                                Ir a la tienda
                            </a>
                        </div>
                    `;
                    document.getElementById('process-payment').disabled = true;
                    return;
                }

                const itemsHtml = this.items.map(item => `
                    <div class="cart-item" data-product-id="${item.id}">
                        <img src="${item.image}" alt="${item.name}" class="cart-item-image">
                        <div class="cart-item-details">
                            <div class="cart-item-name">${item.name}</div>
                            <div class="cart-item-price">$${this.formatPrice(item.price)}</div>
                            <div class="quantity-controls">
                                <button class="quantity-btn decrease-qty" type="button">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" value="${item.quantity}" min="1" class="quantity-input" readonly>
                                <button class="quantity-btn increase-qty" type="button">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold">$${this.formatPrice(item.price * item.quantity)}</div>
                            <i class="fas fa-trash remove-item" title="Eliminar producto"></i>
                        </div>
                    </div>
                `).join('');

                cartContainer.innerHTML = itemsHtml;
                document.getElementById('process-payment').disabled = false;
            }

            updateTotals() {
                const subtotal = this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
                const flete = {{ $empresa->flete ?? 0 }};
                const total = subtotal + flete;
                
                document.getElementById('checkout-subtotal').textContent = '$' + this.formatPrice(subtotal);
                document.getElementById('checkout-total').textContent = '$' + this.formatPrice(total);
                document.getElementById('cart-total-input').value = total;
            }

            formatPrice(price) {
                return new Intl.NumberFormat('es-CO').format(price);
            }

            updateQuantity(productId, newQuantity) {
                if (newQuantity <= 0) {
                    this.removeItem(productId);
                    return;
                }

                const item = this.items.find(item => item.id === productId);
                if (item) {
                    item.quantity = newQuantity;
                    this.saveCartToStorage();
                    this.updateCartDisplay();
                    this.updateTotals();
                }
            }

            removeItem(productId) {
                this.items = this.items.filter(item => item.id !== productId);
                this.saveCartToStorage();
                this.updateCartDisplay();
                this.updateTotals();
            }

            bindEvents() {
                document.addEventListener('click', (e) => {
                    if (e.target.closest('.increase-qty')) {
                        const cartItem = e.target.closest('.cart-item');
                        const productId = parseInt(cartItem.dataset.productId);
                        const quantityInput = cartItem.querySelector('.quantity-input');
                        const newQuantity = parseInt(quantityInput.value) + 1;
                        quantityInput.value = newQuantity;
                        this.updateQuantity(productId, newQuantity);
                    }

                    if (e.target.closest('.decrease-qty')) {
                        const cartItem = e.target.closest('.cart-item');
                        const productId = parseInt(cartItem.dataset.productId);
                        const quantityInput = cartItem.querySelector('.quantity-input');
                        const newQuantity = parseInt(quantityInput.value) - 1;
                        if (newQuantity > 0) {
                            quantityInput.value = newQuantity;
                            this.updateQuantity(productId, newQuantity);
                        }
                    }

                    if (e.target.closest('.remove-item')) {
                        const cartItem = e.target.closest('.cart-item');
                        const productId = parseInt(cartItem.dataset.productId);
                        if (confirm('¿Estás seguro de que quieres eliminar este producto del carrito?')) {
                            this.removeItem(productId);
                        }
                    }
                });

                // Validar formulario
                const form = document.getElementById('checkout-form');
                const processButton = document.getElementById('process-payment');

                form.addEventListener('input', () => {
                    const requiredFields = form.querySelectorAll('input[required]');
                    let allValid = true;

                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            allValid = false;
                        }
                    });

                    processButton.disabled = !allValid || this.items.length === 0;
                });

                // Procesar pago
                processButton.addEventListener('click', () => {
                    if (this.items.length === 0) {
                        alert('Tu carrito está vacío');
                        return;
                    }

                    const formData = new FormData(form);
                    const customerData = {
                        nombre: formData.get('nombre'),
                        email: formData.get('email'),
                        documento: formData.get('documento'),
                        telefono: formData.get('telefono')
                    };

                    // Aquí se integraría con Wompi
                    this.processPayment(customerData);
                });
            }

            processPayment(customerData) {
                // Validar campos requeridos
                const requiredFields = ['nombre', 'email', 'documento', 'telefono'];
                let isValid = true;
                let errorMessage = '';

                // Remover mensajes de error previos
                document.querySelectorAll('.field-error').forEach(el => el.remove());

                for (const fieldName of requiredFields) {
                    const field = document.getElementById(fieldName);
                    if (!field.value.trim()) {
                        isValid = false;
                        errorMessage += `• ${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)} es requerido\n`;
                        
                        // Agregar clase de error y mensaje
                        field.classList.add('is-invalid');
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'text-danger mt-1 field-error';
                        errorDiv.textContent = `${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)} es requerido`;
                        field.parentNode.appendChild(errorDiv);
                    } else {
                        field.classList.remove('is-invalid');
                    }
                }

                // Validar email
                const emailField = document.getElementById('email');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailField.value.trim() && !emailRegex.test(emailField.value.trim())) {
                    isValid = false;
                    errorMessage += '• El formato del correo electrónico no es válido\n';
                    
                    emailField.classList.add('is-invalid');
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'text-danger mt-1 field-error';
                    errorDiv.textContent = 'El formato del correo electrónico no es válido';
                    emailField.parentNode.appendChild(errorDiv);
                }

                // Validar términos y condiciones
                const termsCheckbox = document.querySelector('input[name="terms"]');
                if (!termsCheckbox.checked) {
                    isValid = false;
                    errorMessage += '• Debe aceptar los términos y condiciones\n';
                }

                if (!isValid) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Errores en el formulario',
                            icon: 'error',
                            html: 'Por favor, corrija los siguientes errores:<br><br>' + errorMessage.replace(/\n/g, '<br>'),
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: 'var(--secondary-color)'
                        });
                    } else {
                        alert('Por favor, corrija los siguientes errores:\n' + errorMessage);
                    }
                    return;
                }

                // Crear inputs dinámicamente para cada item del carrito
                const form = document.getElementById('checkout-form');
                
                // Remover inputs de items anteriores si existen
                const existingItemInputs = form.querySelectorAll('[name^="items["]');
                existingItemInputs.forEach(input => input.remove());
                
                // Agregar cada item como input individual
                this.items.forEach((item, index) => {
                    // Input para ID
                    const idInput = document.createElement('input');
                    idInput.type = 'hidden';
                    idInput.name = `items[${index}][id]`;
                    idInput.value = item.id;
                    form.appendChild(idInput);
                    
                    // Input para cantidad
                    const cantidadInput = document.createElement('input');
                    cantidadInput.type = 'hidden';
                    cantidadInput.name = `items[${index}][cantidad]`;
                    cantidadInput.value = item.quantity;
                    form.appendChild(cantidadInput);
                    
                    // Input para precio
                    const precioInput = document.createElement('input');
                    precioInput.type = 'hidden';
                    precioInput.name = `items[${index}][precio]`;
                    precioInput.value = item.price;
                    form.appendChild(precioInput);
                });
                
                // Actualizar total
                document.getElementById('cart-total-input').value = this.items.reduce((sum, item) => sum + (item.price * item.quantity), 0);

                // Deshabilitar botón y mostrar loading
                const processButton = document.getElementById('process-payment');
                processButton.disabled = true;
                processButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Procesando...';

                // Enviar formulario
                document.getElementById('checkout-form').submit();
            }
        }

        // Inicializar carrito cuando cargue la página
        document.addEventListener('DOMContentLoaded', () => {
            new ShoppingCart();
        });
    </script>
</body>
</html>