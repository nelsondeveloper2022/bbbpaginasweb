<!-- Contact Form Component -->
<form class="contact-form" id="contactForm" novalidate>
    @csrf
    <div class="row">
        <!-- Nombre -->
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Nombre Completo *</label>
            <input type="text" class="form-control" id="name" name="name" 
                   placeholder="Tu nombre completo" required>
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <!-- Email -->
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" class="form-control" id="email" name="email" 
                   placeholder="tu@empresa.com" required>
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <!-- Teléfono -->
        <div class="col-md-6 mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="tel" class="form-control" id="phone" name="phone" 
                   placeholder="+34 600 123 456">
            @error('phone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <!-- País -->
        <div class="col-md-6 mb-3">
            <label for="country" class="form-label">País *</label>
            <select class="form-select" id="country" name="country" required>
                <option value="">Selecciona tu país</option>
                <option value="colombia">Colombia</option>
                <option value="mexico">México</option>
                <option value="espana">España</option>
                <option value="otro">Otro</option>
            </select>
            @error('country')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <!-- Plan de Interés -->
        <div class="col-12 mb-3">
            <label for="plan" class="form-label">Plan de Interés</label>
            <select class="form-select" id="plan" name="plan">
                <option value="">Selecciona un plan (opcional)</option>
                @if(isset($plans) && $plans->count() > 0)
                    @foreach($plans as $plan)
                        <option value="{{ $plan->slug }}">{{ $plan->nombre }}</option>
                    @endforeach
                @else
                    <option value="basico">Básico</option>
                    <option value="profesional">Profesional</option>
                    <option value="premium">Premium</option>
                    <option value="personalizado">Personalizado</option>
                @endif
            </select>
            @error('plan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <!-- Mensaje -->
        <div class="col-12 mb-3">
            <label for="message" class="form-label">Mensaje *</label>
            <textarea class="form-control" id="message" name="message" rows="4"
                      placeholder="Cuéntanos sobre tu empresa y cómo podemos ayudarte..." required></textarea>
            @error('message')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
    </div>
    
    <button type="submit" class="submit-btn">
        <i class="fas fa-paper-plane me-2"></i>Enviar Mensaje
    </button>
</form>

<style>
    .contact-form .is-invalid {
        border-color: #dc3545;
    }
    
    .contact-form .error-message {
        display: block;
        margin-top: 0.25rem;
    }
    
    .submit-btn {
        background: linear-gradient(135deg, var(--primary-red) 0%, var(--primary-gold) 100%);
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .submit-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(210, 46, 35, 0.4);
    }
    
    .submit-btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
        transform: none;
    }
</style>