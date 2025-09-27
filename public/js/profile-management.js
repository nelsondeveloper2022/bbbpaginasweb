// Profile Management JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Website URL mask handling
    const websiteInput = document.querySelector('input[data-mask="website"]');
    if (websiteInput) {
        const prefix = websiteInput.parentElement.querySelector('.website-prefix');
        
        // Remove https:// from the value if it exists
        let currentValue = websiteInput.value;
        if (currentValue.startsWith('https://')) {
            websiteInput.value = currentValue.replace('https://', '');
        } else if (currentValue.startsWith('http://')) {
            websiteInput.value = currentValue.replace('http://', '');
        }
        
        // Add focus/blur events for visual feedback
        websiteInput.addEventListener('focus', function() {
            prefix.style.opacity = '1';
            prefix.style.color = '#FFD700';
        });
        
        websiteInput.addEventListener('blur', function() {
            prefix.style.opacity = '0.6';
            prefix.style.color = '#6c757d';
            
            // Clean up the value - remove any protocol if user added it
            let value = this.value.trim();
            if (value.startsWith('https://')) {
                this.value = value.replace('https://', '');
            } else if (value.startsWith('http://')) {
                this.value = value.replace('http://', '');
            }
            
            // Add www. if not present and not empty
            if (value && !value.startsWith('www.') && !value.includes('.')) {
                this.value = 'www.' + value + '.com';
            } else if (value && !value.startsWith('www.') && value.includes('.')) {
                // Value already has domain extension, just ensure it's clean
                this.value = value;
            }
        });
        
        // Prevent user from typing protocols
        websiteInput.addEventListener('input', function() {
            let value = this.value;
            if (value.startsWith('https://') || value.startsWith('http://')) {
                this.value = value.replace(/^https?:\/\//, '');
            }
        });
        
        // Handle form submission - add https:// back
        const form = websiteInput.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                const value = websiteInput.value.trim();
                if (value && !value.startsWith('http')) {
                    websiteInput.value = 'https://' + value;
                }
            });
        }
        
        // Validation indicator
        websiteInput.addEventListener('input', function() {
            const value = this.value.trim();
            const parentDiv = this.closest('.form-floating');
            
            if (value) {
                // Simple domain validation
                const domainRegex = /^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9]\.[a-zA-Z]{2,}$/;
                const isValid = domainRegex.test(value) || domainRegex.test('www.' + value);
                
                if (isValid) {
                    parentDiv.classList.remove('invalid-input');
                    parentDiv.classList.add('valid-input');
                } else {
                    parentDiv.classList.remove('valid-input');
                    parentDiv.classList.add('invalid-input');
                }
            } else {
                parentDiv.classList.remove('valid-input', 'invalid-input');
            }
        });
    }

    // Social media URL validation and formatting
    const socialInputs = document.querySelectorAll('input[name^="facebook"], input[name^="instagram"], input[name^="linkedin"], input[name^="twitter"], input[name^="tiktok"], input[name^="youtube"]');
    
    socialInputs.forEach(input => {
        input.addEventListener('blur', function() {
            const value = this.value.trim();
            if (value && !value.startsWith('http://') && !value.startsWith('https://')) {
                this.value = 'https://' + value;
            }
        });
    });

    // Phone number formatting
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 0 && !value.startsWith('57')) {
                if (value.startsWith('3')) {
                    value = '57' + value;
                }
            }
            
            // Format: +57 300 123 4567
            if (value.length >= 10) {
                const formatted = '+' + value.substring(0, 2) + ' ' + 
                                value.substring(2, 5) + ' ' + 
                                value.substring(5, 8) + ' ' + 
                                value.substring(8, 12);
                this.value = formatted;
            }
        });
    });

    // Form validation enhancement
    const form = document.querySelector('form[action*="profile"]');
    if (form) {
        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('input[required], textarea[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                // Scroll to first invalid field
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    firstInvalid.focus();
                }
            }
        });
    }

    // Upgrade modal functionality
    window.showUpgradeModal = function() {
        const upgradeModal = new bootstrap.Modal(document.getElementById('upgradeModal'));
        upgradeModal.show();
    };

    // Character count for textareas
    const textareas = document.querySelectorAll('textarea');
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        if (maxLength) {
            const container = textarea.closest('.form-floating');
            const counter = document.createElement('small');
            counter.className = 'text-muted mt-1';
            counter.style.float = 'right';
            
            const updateCounter = () => {
                const remaining = maxLength - textarea.value.length;
                counter.textContent = `${remaining} caracteres restantes`;
                counter.style.color = remaining < 50 ? '#dc3545' : '#6c757d';
            };
            
            textarea.addEventListener('input', updateCounter);
            updateCounter();
            
            container.appendChild(counter);
        }
    });

    // Save draft functionality
    let saveTimeout;
    const formInputs = document.querySelectorAll('form input, form textarea');
    
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                saveDraft();
            }, 2000);
        });
    });
    
    function saveDraft() {
        const formData = new FormData(form);
        const draftData = {};
        
        for (let [key, value] of formData.entries()) {
            if (key !== '_token' && key !== '_method') {
                draftData[key] = value;
            }
        }
        
        localStorage.setItem('profile_draft', JSON.stringify(draftData));
        showNotification('Borrador guardado automáticamente', 'info');
    }

    // Load draft on page load
    function loadDraft() {
        const draft = localStorage.getItem('profile_draft');
        if (draft) {
            const draftData = JSON.parse(draft);
            Object.keys(draftData).forEach(key => {
                const input = document.querySelector(`[name="${key}"]`);
                if (input && !input.value) {
                    input.value = draftData[key];
                }
            });
        }
    }

    // Clear draft after successful submission
    if (document.querySelector('.alert-success')) {
        localStorage.removeItem('profile_draft');
    }

    // Show notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            <i class="bi bi-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(notification);
            bsAlert.close();
        }, 3000);
    }

    // Initialize draft loading
    loadDraft();
});