/**
 * Funcionalidad avanzada para el formulario de registro
 */

class RegistrationForm {
    constructor() {
        this.form = document.getElementById('registerForm');
        this.submitBtn = document.getElementById('submitBtn');
        this.passwordInput = document.getElementById('password');
        this.confirmPasswordInput = document.getElementById('password_confirmation');
        this.phoneInput = document.getElementById('movil');
        this.emailInputs = document.querySelectorAll('input[type="email"]');
        this.planRadios = document.querySelectorAll('input[name="plan_id"]');
        
        this.init();
    }
    
    init() {
        this.setupPasswordStrength();
        this.setupPasswordConfirmation();
        this.setupPhoneFormatting();
        this.setupEmailValidation();
        this.setupPlanSelection();
        this.setupFormSubmission();
        this.setupRealTimeValidation();
        this.initializeSelectedPlan();
    }
    
    setupPasswordStrength() {
        const strengthBar = document.querySelector('.strength-fill');
        const strengthText = document.querySelector('.strength-text');
        
        this.passwordInput.addEventListener('input', (e) => {
            const password = e.target.value;
            const strength = this.calculatePasswordStrength(password);
            
            strengthBar.style.width = strength.percentage + '%';
            strengthBar.style.background = strength.color;
            strengthText.textContent = strength.text;
            strengthText.style.color = strength.color;
            
            // Añadir clase de validación visual
            if (strength.percentage >= 75) {
                e.target.classList.add('valid');
                e.target.classList.remove('invalid');
            } else if (password.length > 0) {
                e.target.classList.add('invalid');
                e.target.classList.remove('valid');
            } else {
                e.target.classList.remove('valid', 'invalid');
            }
        });
    }
    
    calculatePasswordStrength(password) {
        let strength = 0;
        let text = 'Muy débil';
        let color = '#dc3545';
        
        // Criterios de fortaleza
        if (password.length >= 8) strength += 25;
        if (password.match(/[a-z]/)) strength += 25;
        if (password.match(/[A-Z]/)) strength += 25;
        if (password.match(/[0-9]/)) strength += 25;
        if (password.match(/[^a-zA-Z0-9]/)) strength += 10; // Caracteres especiales (bonus)
        
        if (strength >= 85) {
            text = 'Muy fuerte';
            color = '#28a745';
        } else if (strength >= 75) {
            text = 'Fuerte';
            color = '#28a745';
        } else if (strength >= 50) {
            text = 'Media';
            color = '#ffc107';
        } else if (strength >= 25) {
            text = 'Débil';
            color = '#fd7e14';
        }
        
        return {
            percentage: Math.min(strength, 100),
            text: text,
            color: color
        };
    }
    
    setupPasswordConfirmation() {
        this.confirmPasswordInput.addEventListener('input', (e) => {
            const password = this.passwordInput.value;
            const confirmation = e.target.value;
            
            if (confirmation && confirmation !== password) {
                e.target.setCustomValidity('Las contraseñas no coinciden');
                e.target.classList.add('invalid');
                e.target.classList.remove('valid');
            } else if (confirmation && confirmation === password) {
                e.target.setCustomValidity('');
                e.target.classList.add('valid');
                e.target.classList.remove('invalid');
            } else {
                e.target.setCustomValidity('');
                e.target.classList.remove('valid', 'invalid');
            }
        });
        
        // También verificar cuando se cambia la contraseña principal
        this.passwordInput.addEventListener('input', () => {
            if (this.confirmPasswordInput.value) {
                this.confirmPasswordInput.dispatchEvent(new Event('input'));
            }
        });
    }
    
    setupPhoneFormatting() {
        this.phoneInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            
            // Formatear según el país (Colombia por defecto)
            if (value.length > 0) {
                if (value.startsWith('57')) {
                    // Ya tiene código de país de Colombia
                    value = '+' + value.substring(0, 2) + ' ' + value.substring(2);
                } else if (value.startsWith('1') && value.length === 11) {
                    // Código de país de USA/Canadá
                    value = '+' + value.substring(0, 1) + ' ' + value.substring(1);
                } else if (!value.startsWith('+')) {
                    // Asumir Colombia si no hay código de país
                    value = '+57 ' + value;
                }
                
                // Formatear número colombiano
                if (value.startsWith('+57')) {
                    const number = value.replace('+57 ', '');
                    if (number.length >= 3) {
                        value = '+57 ' + number.substring(0, 3) + ' ' + 
                               number.substring(3, 6) + ' ' + 
                               number.substring(6, 10);
                    }
                }
            }
            
            e.target.value = value.trim();
            
            // Validar formato
            const phoneRegex = /^\+\d{1,3}\s\d{3}\s\d{3}\s\d{4}$/;
            if (value && phoneRegex.test(value)) {
                e.target.classList.add('valid');
                e.target.classList.remove('invalid');
            } else if (value) {
                e.target.classList.add('invalid');
                e.target.classList.remove('valid');
            } else {
                e.target.classList.remove('valid', 'invalid');
            }
        });
    }
    
    setupEmailValidation() {
        this.emailInputs.forEach(input => {
            input.addEventListener('blur', (e) => {
                const email = e.target.value;
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email && emailRegex.test(email)) {
                    e.target.classList.add('valid');
                    e.target.classList.remove('invalid');
                } else if (email) {
                    e.target.classList.add('invalid');
                    e.target.classList.remove('valid');
                } else {
                    e.target.classList.remove('valid', 'invalid');
                }
            });
            
            // Validación en tiempo real (más suave)
            input.addEventListener('input', (e) => {
                if (e.target.classList.contains('invalid') || e.target.classList.contains('valid')) {
                    // Solo re-validar si ya se había validado antes
                    setTimeout(() => {
                        e.target.dispatchEvent(new Event('blur'));
                    }, 500);
                }
            });
        });
    }
    
    setupPlanSelection() {
        this.planRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                // Remover selección visual de todos los planes
                this.planRadios.forEach(r => {
                    const card = r.closest('.plan-label').querySelector('.plan-card');
                    card.classList.remove('selected');
                });
                
                // Añadir selección visual al plan seleccionado
                const selectedCard = e.target.closest('.plan-label').querySelector('.plan-card');
                selectedCard.classList.add('selected');
                
                // Animación suave
                selectedCard.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    selectedCard.style.transform = '';
                }, 200);
            });
        });
    }
    
    setupFormSubmission() {
        this.form.addEventListener('submit', (e) => {
            // Verificar que todos los campos requeridos están completos
            const requiredFields = this.form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('invalid');
                    isValid = false;
                } else {
                    field.classList.remove('invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                this.showErrorMessage('Por favor completa todos los campos obligatorios.');
                return;
            }
            
            // Verificar que se haya seleccionado un plan
            const selectedPlan = document.querySelector('input[name="plan_id"]:checked');
            if (!selectedPlan) {
                e.preventDefault();
                this.showErrorMessage('Por favor selecciona un plan.');
                return;
            }
            
            // Mostrar estado de carga
            this.submitBtn.disabled = true;
            this.submitBtn.innerHTML = '<span class="loading-spinner"></span>Creando cuenta...';
            
            // Si llegamos aquí, el formulario es válido
            // El evento continuará normalmente
        });
    }
    
    setupRealTimeValidation() {
        // Validación en tiempo real para campos de texto
        const textInputs = this.form.querySelectorAll('input[type="text"], input[type="email"]');
        
        textInputs.forEach(input => {
            input.addEventListener('blur', (e) => {
                if (e.target.hasAttribute('required') && !e.target.value.trim()) {
                    e.target.classList.add('invalid');
                } else if (e.target.value.trim()) {
                    e.target.classList.remove('invalid');
                    if (!e.target.classList.contains('valid')) {
                        e.target.classList.add('valid');
                    }
                }
            });
        });
    }
    
    initializeSelectedPlan() {
        const checkedPlan = document.querySelector('input[name="plan_id"]:checked');
        if (checkedPlan) {
            const card = checkedPlan.closest('.plan-label').querySelector('.plan-card');
            card.classList.add('selected');
        }
    }
    
    showErrorMessage(message) {
        // Crear o actualizar mensaje de error
        let errorDiv = document.querySelector('.form-error-message');
        
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger form-error-message';
            this.form.insertBefore(errorDiv, this.form.firstChild);
        }
        
        errorDiv.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i>${message}`;
        errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
        // Remover el mensaje después de 5 segundos
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    new RegistrationForm();
});

// Utilidades adicionales
const RegisterUtils = {
    // Función para verificar disponibilidad de email (se puede conectar con backend)
    checkEmailAvailability: async function(email) {
        try {
            // Aquí se haría una petición AJAX al backend
            const response = await fetch(`/api/check-email?email=${encodeURIComponent(email)}`);
            return await response.json();
        } catch (error) {
            return { available: true };
        }
    },
    
    // Función para autocompletar información de empresa basada en email
    suggestCompanyInfo: function(email) {
        const domain = email.split('@')[1];
        if (domain && domain !== 'gmail.com' && domain !== 'hotmail.com' && domain !== 'yahoo.com') {
            const companyNameInput = document.getElementById('empresa_nombre');
            const companyEmailInput = document.getElementById('empresa_email');
            
            if (!companyNameInput.value) {
                // Sugerir nombre de empresa basado en dominio
                const suggestedName = domain.split('.')[0].charAt(0).toUpperCase() + domain.split('.')[0].slice(1);
                companyNameInput.placeholder = `¿Es "${suggestedName}" el nombre de tu empresa?`;
            }
            
            if (!companyEmailInput.value) {
                // Sugerir email corporativo
                companyEmailInput.value = `contacto@${domain}`;
            }
        }
    }
};