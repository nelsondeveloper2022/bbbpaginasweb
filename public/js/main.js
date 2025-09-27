/**
 * Main JavaScript file for BBB Backend
 * Loads company data and makes it available globally
 */

// Global variables to store company data
let empresaData = null;
let isEmpresaLoaded = false;
let planesData = null;
let arePlanesLoaded = false;

// Configuration
const API_BASE_URL = window.location.origin + '/api';
const DEFAULT_EMPRESA_ID = 1; // Change this to your default company ID

/**
 * Makes API call to get company plans
 * @param {number} idEmpresa - Company ID to fetch plans for
 * @returns {Promise<Array>} Plans data or empty array if error
 */
async function getEmpresaPlanes(idEmpresa = DEFAULT_EMPRESA_ID) {
    try {
        // Get current locale from HTML lang attribute or URL
        const currentLocale = document.documentElement.lang || 
                             window.location.pathname.split('/')[1] || 
                             'es';
        
        const response = await fetch(`${API_BASE_URL}/empresa/planes`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                idEmpresa: idEmpresa,
                locale: currentLocale
            })
        });

        const result = await response.json();

        if (result.success && result.data) {
            
            return result.data;
        } else {
            
            return [];
        }
    } catch (error) {
        
        return [];
    }
}

/**
 * Loads company plans and stores them in global variables
 * @param {number} idEmpresa - Company ID to load plans for
 */
async function loadEmpresaPlanes(idEmpresa = DEFAULT_EMPRESA_ID) {
    try {
        
        
        const data = await getEmpresaPlanes(idEmpresa);
        
        // Store data in global variables
        planesData = data;
        arePlanesLoaded = true;
        
        
        
        // Trigger custom event for other scripts to listen to
        document.dispatchEvent(new CustomEvent('empresaPlanesLoaded', {
            detail: data
        }));
        
        // Update plan select elements in the page
        updatePlanSelects(data);
        
        return true;
    } catch (error) {
        console.error('Error loading empresa planes:', error);
        return false;
    }
}

/**
 * Updates plan select elements based on available plans
 * @param {Array} planes - Array of plan objects
 */
function updatePlanSelects(planes) {
    const planSelects = document.querySelectorAll('select[name="plan"]');
    
    planSelects.forEach(select => {
        const parentContainer = select.closest('.form-group, .mb-3, .plan-select-container');
        
        if (planes && planes.length > 0) {
            // Show the select if there are plans
            if (parentContainer) {
                parentContainer.style.display = 'block';
            }
            select.style.display = 'block';
            
            // Clear existing options except the first (placeholder) option
            const firstOption = select.querySelector('option[value=""]');
            select.innerHTML = '';
            
            // Add placeholder option
            if (firstOption) {
                select.appendChild(firstOption);
            } else {
                const placeholderOption = document.createElement('option');
                placeholderOption.value = '';
                placeholderOption.textContent = 'Selecciona un plan';
                select.appendChild(placeholderOption);
            }
            
            // Add plan options
            planes.forEach(plan => {
                const option = document.createElement('option');
                option.value = plan.slug || plan.idPlan; // Use slug if available, fallback to idPlan
                option.textContent = plan.nombre;
                option.setAttribute('data-precio-pesos', plan.precioPesos || '');
                option.setAttribute('data-precio-dolar', plan.preciosDolar || '');
                option.setAttribute('data-descripcion', plan.descripcion || '');
                option.setAttribute('data-id-plan', plan.idPlan || '');
                
                if (plan.destacado) {
                    option.textContent += ' ⭐';
                }
                
                select.appendChild(option);
            });
            
            // Remove required attribute initially
            select.removeAttribute('required');
            
        } else {
            // Hide the select if there are no plans
            if (parentContainer) {
                parentContainer.style.display = 'none';
            }
            select.style.display = 'none';
            
            // Remove required attribute when hidden
            select.removeAttribute('required');
            
            // Clear the select value
            select.value = '';
        }
    });
}

/**
 * Gets plan information by ID
 * @param {number} planId - Plan ID to get information for
 * @returns {Object|null} Plan object or null if not found
 */
function getPlanById(planId) {
    if (!arePlanesLoaded || !planesData) {
        console.warn('Planes data not loaded yet');
        return null;
    }
    
    return planesData.find(plan => plan.idPlan == planId) || null;
}

/**
 * Gets all loaded plans
 * @returns {Array} Array of plan objects
 */
function getAllPlanes() {
    return planesData || [];
}
async function getEmpresaData(idEmpresa = DEFAULT_EMPRESA_ID) {
    try {
        const response = await fetch(`${API_BASE_URL}/empresa`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                idEmpresa: idEmpresa
            })
        });

        const result = await response.json();

        if (result.success && result.data) {
            return result.data;
        } else {
            console.error('Error fetching empresa data:', result.message);
            return null;
        }
    } catch (error) {
        console.error('Network error fetching empresa data:', error);
        return null;
    }
}

/**
 * Loads company data and stores it in global variables
 * @param {number} idEmpresa - Company ID to load
 */
async function loadEmpresaData(idEmpresa = DEFAULT_EMPRESA_ID) {
    try {
        
        
        const data = await getEmpresaData(idEmpresa);
        
        if (data) {
            // Store data in global variables
            empresaData = data;
            isEmpresaLoaded = true;
            
            // Create individual variables for easy access
            window.empresaId = data.idEmpresa;
            window.empresaNombre = data.nombre;
            window.empresaEmail = data.email;
            window.empresaMovil = data.movil;
            window.empresaDireccion = data.direccion;
            window.empresaCreatedAt = data.created_at;
            window.empresaUpdatedAt = data.updated_at;
            
            
            
            // Trigger custom event for other scripts to listen to
            document.dispatchEvent(new CustomEvent('empresaDataLoaded', {
                detail: data
            }));
            
            // Update dynamic content in the page
            updatePageContent(data);
            
            // Load plans for this empresa
            await loadEmpresaPlanes(data.idEmpresa);
            
            return true;
        } else {
            console.error('Failed to load empresa data');
            return false;
        }
    } catch (error) {
        console.error('Error loading empresa data:', error);
        return false;
    }
}

/**
 * Gets specific empresa data field
 * @param {string} field - Field name to get
 * @returns {*} Field value or null if not found
 */
function getEmpresaField(field) {
    if (!isEmpresaLoaded || !empresaData) {
        console.warn('Empresa data not loaded yet');
        return null;
    }
    
    return empresaData[field] || null;
}

/**
 * Gets current locale from URL or default to 'es'
 * @returns {string} Current locale (es/en)
 */
function getCurrentLocale() {
    const pathSegments = window.location.pathname.split('/');
    const locale = pathSegments[1];
    return (locale === 'en' || locale === 'es') ? locale : 'es';
}

/**
 * Updates empresa data in memory (doesn't persist to database)
 * @param {Object} newData - New data to merge
 */
function updateEmpresaData(newData) {
    if (!isEmpresaLoaded || !empresaData) {
        console.warn('Empresa data not loaded yet');
        return false;
    }
    
    Object.assign(empresaData, newData);
    
    // Update global variables
    window.empresaId = empresaData.idEmpresa;
    window.empresaNombre = empresaData.nombre;
    window.empresaEmail = empresaData.email;
    window.empresaMovil = empresaData.movil;
    window.empresaDireccion = empresaData.direccion;
    
    // Update page content with new data
    updatePageContent(empresaData);
    
    // Trigger update event
    document.dispatchEvent(new CustomEvent('empresaDataUpdated', {
        detail: empresaData
    }));
    
    return true;
}

/**
 * Reloads empresa data from API
 * @param {number} idEmpresa - Company ID to reload
 */
async function reloadEmpresaData(idEmpresa = DEFAULT_EMPRESA_ID) {
    isEmpresaLoaded = false;
    empresaData = null;
    arePlanesLoaded = false;
    planesData = null;
    return await loadEmpresaData(idEmpresa);
}

/**
 * Clean phone number for WhatsApp formatting
 * @param {string} phone - Phone number to clean
 * @returns {string} Cleaned phone number
 */
function cleanPhoneForWhatsApp(phone) {
    if (!phone) return '';
    
    // Remove spaces, dashes, parentheses, and other non-numeric characters except +
    let cleaned = phone.replace(/[\s\-\(\)\.]/g, '');
    
    // Ensure it starts with + if it doesn't already
    if (!cleaned.startsWith('+')) {
        // Add default country code if needed (you can customize this)
        if (cleaned.length === 10) {
            cleaned = '+57' + cleaned; // Colombia default
        } else {
            cleaned = '+' + cleaned;
        }
    }
    
    return cleaned;
}

/**
 * Updates dynamic content on the page with empresa data
 * @param {Object} data - Empresa data object
 */
function updatePageContent(data) {
    // Update footer content
    updateFooterContent(data);
    
    // Update contact page content
    updateContactContent(data);
    
    // Update meta title if needed
    updatePageTitle(data);
    
    
}

/**
 * Updates footer elements with empresa data
 * @param {Object} data - Empresa data object
 */
function updateFooterContent(data) {
    // Update footer email link and href
    const footerEmail = document.getElementById('footer-empresa-email');
    if (footerEmail && data.email) {
        footerEmail.textContent = data.email;
        footerEmail.href = `mailto:${data.email}`;
    }
    
    // Update footer mobile/WhatsApp link and href
    const footerMovil = document.getElementById('footer-empresa-movil');
    if (footerMovil && data.movil) {
        footerMovil.textContent = data.movil;
        // Clean phone number for WhatsApp
        const cleanPhone = cleanPhoneForWhatsApp(data.movil);
        const whatsappMessage = encodeURIComponent('Hola, me gustaría obtener más información sobre sus servicios.');
        footerMovil.href = `https://wa.me/${cleanPhone}?text=${whatsappMessage}`;
    }
    
    // Update footer address link and href
    const footerDireccion = document.getElementById('footer-empresa-direccion');
    if (footerDireccion && data.direccion) {
        footerDireccion.textContent = data.direccion;
        footerDireccion.href = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(data.direccion)}`;
    }
    
    // Update footer company name
    const footerNombre = document.getElementById('footer-empresa-nombre');
    if (footerNombre && data.nombre) {
        footerNombre.textContent = data.nombre;
    }
    
    // Update social links dynamically
    updateSocialLinks(data);
}

/**
 * Updates contact page elements with empresa data
 * @param {Object} data - Empresa data object
 */
function updateContactContent(data) {
    // Update contact page email link and href
    const contactEmail = document.getElementById('contact-empresa-email');
    if (contactEmail && data.email) {
        contactEmail.textContent = data.email;
        // If it's a link, update the href
        if (contactEmail.tagName.toLowerCase() === 'a') {
            contactEmail.href = `mailto:${data.email}`;
        }
    }
    
    // Update contact page mobile/WhatsApp link and href
    const contactMovil = document.getElementById('contact-empresa-movil');
    if (contactMovil && data.movil) {
        contactMovil.textContent = data.movil;
        // If it's a link, update the href for WhatsApp
        if (contactMovil.tagName.toLowerCase() === 'a') {
            const cleanPhone = cleanPhoneForWhatsApp(data.movil);
            const whatsappMessage = encodeURIComponent('Hola, me gustaría obtener más información sobre sus servicios.');
            contactMovil.href = `https://wa.me/${cleanPhone}?text=${whatsappMessage}`;
        }
    }
}

/**
 * Updates page title with empresa name if needed
 * @param {Object} data - Empresa data object
 */
function updatePageTitle(data) {
    // Only update if the title contains default text and we have empresa name
    if (data.nombre && document.title.includes('BBB Páginas Web')) {
        // You can customize this logic based on your needs
        // document.title = document.title.replace('BBB Páginas Web', data.nombre);
    }
}

// Export functions for global use
window.BBB = {
    getEmpresaData,
    loadEmpresaData,
    getEmpresaField,
    updateEmpresaData,
    reloadEmpresaData,
    updatePageContent,
    updateFooterContent,
    updateContactContent,
    cleanPhoneForWhatsApp,
    // Plan functions
    getEmpresaPlanes,
    loadEmpresaPlanes,
    getPlanById,
    getAllPlanes,
    updatePlanSelects,
    // Status functions
    isEmpresaLoaded: () => isEmpresaLoaded,
    getFullEmpresaData: () => empresaData,
    arePlanesLoaded: () => arePlanesLoaded,
    getFullPlanesData: () => planesData
};

/**
 * ============================================
 * CONTACT FORM FUNCTIONALITY WITH SWEETALERT2
 * ============================================
 */

// Import SweetAlert2 (if using modules) or include via CDN
// For CDN include this in your HTML: <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

/**
 * Validates form data before submission
 * @param {FormData} formData - Form data to validate
 * @returns {Object} Validation result with isValid boolean and errors array
 */
function validateContactForm(formData) {
    const errors = [];
    
    // Name validation
    const name = formData.get('name')?.trim();
    if (!name || name.length < 2) {
        errors.push('El nombre debe tener al menos 2 caracteres');
    }
    
    // Email validation
    const email = formData.get('email')?.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email || !emailRegex.test(email)) {
        errors.push('Por favor ingresa un email válido');
    }
    
    // Phone validation (optional but if provided, should be valid)
    const phone = formData.get('phone')?.trim();
    if (phone && phone.length < 7) {
        errors.push('El teléfono debe tener al menos 7 dígitos');
    }
    
    // Country validation
    const country = formData.get('country');
    if (!country) {
        errors.push('Por favor selecciona un país');
    }
    
    // Plan validation (only required if plan select is visible and has options)
    const planSelect = document.querySelector('select[name="plan"]');
    const plan = formData.get('plan');
    if (planSelect && planSelect.style.display !== 'none' && planSelect.options.length > 1) {
        // Plan select is visible and has options, so plan selection is required
        if (!plan) {
            errors.push('Por favor selecciona un plan');
        }
    }
    
    // Message validation
    const message = formData.get('message')?.trim();
    if (!message || message.length < 10) {
        errors.push('El mensaje debe tener al menos 10 caracteres');
    }
    
    return {
        isValid: errors.length === 0,
        errors: errors
    };
}

/**
 * Sends contact form data to API
 * @param {FormData} formData - Form data to send
 * @returns {Promise<Object>} API response
 */
async function sendContactForm(formData) {
    // Add empresa ID to form data
    const empresaId = getEmpresaField('idEmpresa') || DEFAULT_EMPRESA_ID;
    
    // Get plan information if selected
    const planId = formData.get('plan');
    let planNombre = null;
    if (planId && planId.trim() !== '') {
        const planInfo = getPlanById(planId);
        if (planInfo) {
            planNombre = planInfo.nombre;
        }
    }
    // Get current locale
    const currentLocale = document.documentElement.lang || 
                         window.location.pathname.split('/')[1] || 
                         'es';
    
    const requestData = {
        name: formData.get('name'),
        email: formData.get('email'),
        phone: formData.get('phone'),
        country: formData.get('country'),
        message: formData.get('message'),
        empresa_id: empresaId,
        locale: currentLocale
    };
    
    // Only include plan data if it's actually selected
    if (planId && planId.trim() !== '') {
        requestData.plan = planId;
        if (planNombre) {
            requestData.plan_nombre = planNombre;
        }
    }
    
    const response = await fetch(`${API_BASE_URL}/contact/send`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(requestData)
    });
    
    return await response.json();
}

/**
 * Handles contact form submission
 * @param {Event} event - Form submit event
 */
async function handleContactFormSubmit(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;
    
    // Validate form
    const validation = validateContactForm(formData);
    if (!validation.isValid) {
        Swal.fire({
            icon: 'error',
            title: '¡Datos incompletos!',
            html: validation.errors.map(error => `• ${error}`).join('<br>'),
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#667eea'
        });
        return;
    }
    
    // Show loading state
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
    
    try {
        // Send form data
        const result = await sendContactForm(formData);
        
        if (result.success) {
            // Success alert
            await Swal.fire({
                icon: 'success',
                title: '¡Mensaje enviado!',
                text: result.message || 'Tu mensaje ha sido enviado correctamente. Pronto nos pondremos en contacto contigo.',
                confirmButtonText: 'Perfecto',
                confirmButtonColor: '#28a745',
                timer: 5000,
                timerProgressBar: true
            });
            
            // Reset form
            form.reset();
            
            // Optional: Track conversion (Google Analytics, Facebook Pixel, etc.)
            if (typeof gtag !== 'undefined') {
                gtag('event', 'form_submit', {
                    event_category: 'Contact',
                    event_label: 'Contact Form Submission'
                });
            }
            
        } else {
            // Error from server
            let errorMessage = result.message || 'Hubo un error al enviar el mensaje';
            
            // Handle validation errors
            if (result.errors) {
                const errorList = Object.values(result.errors).flat();
                errorMessage = errorList.join('<br>');
            }
            
            Swal.fire({
                icon: 'error',
                title: 'Error al enviar',
                html: errorMessage,
                confirmButtonText: 'Intentar nuevamente',
                confirmButtonColor: '#dc3545'
            });
        }
        
    } catch (error) {
        console.error('Error sending contact form:', error);
        
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor. Por favor verifica tu conexión a internet e intenta nuevamente.',
            confirmButtonText: 'Entendido',
            confirmButtonColor: '#dc3545'
        });
    } finally {
        // Restore button state
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
    }
}

/**
 * Initialize contact form functionality
 */
function initializeContactForm() {
    const contactForms = document.querySelectorAll('.contact-form');
    
    contactForms.forEach(form => {
        form.addEventListener('submit', handleContactFormSubmit);
        
        // Add real-time validation feedback (optional)
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateInputField(this);
            });
        });
    });
}

/**
 * Validates individual input field
 * @param {HTMLElement} input - Input element to validate
 */
function validateInputField(input) {
    const value = input.value.trim();
    const isRequired = input.hasAttribute('required');
    let isValid = true;
    let errorMessage = '';
    
    // Remove existing error styling
    input.classList.remove('is-invalid');
    const existingError = input.parentNode.querySelector('.error-message');
    if (existingError) {
        existingError.remove();
    }
    
    // Validate based on input type
    switch (input.type) {
        case 'email':
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (isRequired && !value) {
                isValid = false;
                errorMessage = 'El email es requerido';
            } else if (value && !emailRegex.test(value)) {
                isValid = false;
                errorMessage = 'Formato de email inválido';
            }
            break;
            
        case 'tel':
            if (value && value.length < 7) {
                isValid = false;
                errorMessage = 'Teléfono muy corto';
            }
            break;
            
        default:
            if (isRequired && !value) {
                isValid = false;
                errorMessage = 'Este campo es requerido';
            } else if (input.name === 'name' && value.length < 2) {
                isValid = false;
                errorMessage = 'Nombre muy corto';
            } else if (input.name === 'message' && value.length < 10) {
                isValid = false;
                errorMessage = 'Mensaje muy corto (mínimo 10 caracteres)';
            }
    }
    
    // Show error if invalid
    if (!isValid) {
        input.classList.add('is-invalid');
        const errorDiv = document.createElement('small');
        errorDiv.className = 'error-message text-danger';
        errorDiv.textContent = errorMessage;
        input.parentNode.appendChild(errorDiv);
    }
    
    return isValid;
}

// Initialize contact form when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if empresa ID is specified in meta tag or data attribute
    const metaEmpresaId = document.querySelector('meta[name="empresa-id"]');
    const bodyEmpresaId = document.body.getAttribute('data-empresa-id');
    
    const empresaId = metaEmpresaId ? 
        parseInt(metaEmpresaId.content) : 
        (bodyEmpresaId ? parseInt(bodyEmpresaId) : DEFAULT_EMPRESA_ID);
    
    loadEmpresaData(empresaId);
    
    // Initialize contact form functionality
    initializeContactForm();
    
    // Add SweetAlert2 styles if not already included
    if (!document.querySelector('link[href*="sweetalert2"]')) {
        const swalCSS = document.createElement('link');
        swalCSS.rel = 'stylesheet';
        swalCSS.href = 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css';
        document.head.appendChild(swalCSS);
    }
});

/**
 * ============================================
 * SOCIAL MEDIA DYNAMIC FUNCTIONALITY
 * ============================================
 */

/**
 * Updates social media links based on empresa data
 * @param {Object} data - Empresa data object
 */
function updateSocialLinks(data) {
    const socialContainer = document.getElementById('footer-social-links');
    if (!socialContainer) return;
    
    // Clear existing social links
    socialContainer.innerHTML = '';
    
    // Social media mapping with icons and prefixes
    const socialMedia = {
        facebook: {
            icon: 'fab fa-facebook-f',
            prefix: 'https://facebook.com/',
            title: 'Facebook'
        },
        instagram: {
            icon: 'fab fa-instagram',
            prefix: 'https://instagram.com/',
            title: 'Instagram'
        },
        tiktok: {
            icon: 'fab fa-tiktok',
            prefix: 'https://tiktok.com/@',
            title: 'TikTok'
        },
        linkedin: {
            icon: 'fab fa-linkedin-in',
            prefix: 'https://linkedin.com/in/',
            title: 'LinkedIn'
        },
        youtube: {
            icon: 'fab fa-youtube',
            prefix: 'https://youtube.com/',
            title: 'YouTube'
        },
        twitter: {
            icon: 'fab fa-twitter',
            prefix: 'https://twitter.com/',
            title: 'Twitter'
        },
        whatsapp: {
            icon: 'fab fa-whatsapp',
            prefix: 'https://wa.me/',
            title: 'WhatsApp'
        }
    };
    
    // Add social links that have values
    Object.keys(socialMedia).forEach(platform => {
        const value = data[platform];
        if (value && value.trim() !== '') {
            const link = document.createElement('a');
            link.href = formatSocialUrl(platform, value, socialMedia[platform].prefix);
            link.title = socialMedia[platform].title;
            link.target = '_blank';
            link.rel = 'noopener noreferrer';
            
            const icon = document.createElement('i');
            icon.className = socialMedia[platform].icon;
            
            link.appendChild(icon);
            socialContainer.appendChild(link);
        }
    });
    
    // Add website link if available
    if (data.website && data.website.trim() !== '') {
        const link = document.createElement('a');
        link.href = formatWebsiteUrl(data.website);
        link.title = 'Sitio Web';
        link.target = '_blank';
        link.rel = 'noopener noreferrer';
        
        const icon = document.createElement('i');
        icon.className = 'fas fa-globe';
        
        link.appendChild(icon);
        socialContainer.appendChild(link);
    }
}

/**
 * Formats social media URL
 * @param {string} platform - Platform name
 * @param {string} value - Platform value/username
 * @param {string} prefix - URL prefix
 * @returns {string} Formatted URL
 */
function formatSocialUrl(platform, value, prefix) {
    let cleanValue = value.trim();
    
    // Remove common prefixes if user included full URL
    if (cleanValue.startsWith('http://') || cleanValue.startsWith('https://')) {
        return cleanValue;
    }
    
    // Remove @ symbol if included
    if (cleanValue.startsWith('@')) {
        cleanValue = cleanValue.substring(1);
    }
    
    // Special handling for WhatsApp (should be phone number)
    if (platform === 'whatsapp') {
        return prefix + cleanPhoneForWhatsApp(cleanValue);
    }
    
    return prefix + cleanValue;
}

/**
 * Formats website URL
 * @param {string} url - Website URL
 * @returns {string} Formatted URL
 */
function formatWebsiteUrl(url) {
    let cleanUrl = url.trim();
    
    if (!cleanUrl.startsWith('http://') && !cleanUrl.startsWith('https://')) {
        cleanUrl = 'https://' + cleanUrl;
    }
    
    return cleanUrl;
}

/**
 * ============================================
 * LEGACY CODE REMOVED
 * Modal functionality for terms & policies has been replaced with dedicated pages
 * ============================================
 */