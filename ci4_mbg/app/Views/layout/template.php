<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - SISTEM GUDANG MGB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        /* Style untuk menu aktif */
        .navbar-nav .nav-link.active {
            font-weight: bold;
            color: #fff !important;
            border-bottom: 2px solid #fff;
        }
        
        /* Enhanced validation styles */
        .form-control.is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }
        
        .form-control.is-valid {
            border-color: #28a745 !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }
        
        .invalid-feedback {
            display: block !important;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #dc3545;
        }
        
        .valid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875em;
            color: #28a745;
        }
        
        /* Loading overlay */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            border-radius: 0.375rem;
        }
        
        /* Form container dengan position relative untuk overlay */
        .form-container {
            position: relative;
        }
        
        /* Toast notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        /* Required field indicator */
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
    </style>
</head>
<body>

    <?php if(session()->get('isLoggedIn')): ?>
        <?= $this->include('layout/navbar') ?>
    <?php endif; ?>

    <div class="container mt-4">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Toast Container -->
    <div class="toast-container"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Global Form Validator Class
        // Fixed FormValidator Class untuk template.php
class FormValidator {
    constructor(formId, options = {}) {
        this.form = document.getElementById(formId);
        this.options = {
            validateOnInput: true,
            showSuccessMessages: true,
            customRules: {},
            submitCallback: null,
            ...options
        };
        this.init();
    }
    
    init() {
        if (!this.form) return;
        
        this.form.addEventListener('submit', (e) => this.handleSubmit(e));
        
        if (this.options.validateOnInput) {
            const inputs = this.form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('input', () => this.validateField(input));
                input.addEventListener('blur', () => this.validateField(input));
            });
        }
    }
    
    validateField(field) {
        const value = field.value.trim();
        const rules = this.getFieldRules(field);
        const errors = [];
        
        // Skip validation for optional password in edit forms
        if (field.name === 'password' && !field.hasAttribute('required') && !value) {
            this.updateFieldFeedback(field, []);
            return true;
        }
        
        // Required validation
        if (rules.required && !value) {
            errors.push(`${this.getFieldLabel(field)} wajib diisi`);
        }
        
        // Only validate other rules if field has value
        if (value) {
            // Length validation
            if (rules.minLength && value.length < rules.minLength) {
                errors.push(`${this.getFieldLabel(field)} minimal ${rules.minLength} karakter`);
            }
            
            if (rules.maxLength && value.length > rules.maxLength) {
                errors.push(`${this.getFieldLabel(field)} maksimal ${rules.maxLength} karakter`);
            }
            
            // Number validation
            if (field.type === 'number') {
                const num = parseInt(value);
                if (isNaN(num)) {
                    errors.push(`${this.getFieldLabel(field)} harus berupa angka`);
                } else {
                    if (rules.min !== null && num < rules.min) {
                        errors.push(`${this.getFieldLabel(field)} minimal ${rules.min}`);
                    }
                    if (rules.max !== null && num > rules.max) {
                        errors.push(`${this.getFieldLabel(field)} maksimal ${rules.max}`);
                    }
                }
            }
            
            // Email validation
            if (field.type === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    errors.push(`${this.getFieldLabel(field)} harus berupa email yang valid`);
                }
            }
            
            // NIM validation
            if (field.name === 'nim') {
                const nimRegex = /^\d{8,15}$/;
                if (!nimRegex.test(value)) {
                    errors.push('NIM harus berupa angka 8-15 digit');
                }
            }
            
            // Username validation
            if (field.name === 'username') {
                if (value.length < 3) {
                    errors.push('Username minimal 3 karakter');
                } else if (!/^[a-zA-Z0-9_]+$/.test(value)) {
                    errors.push('Username hanya boleh huruf, angka, dan underscore');
                }
            }
        }
        
        // Custom rules
        if (this.options.customRules[field.name]) {
            const customErrors = this.options.customRules[field.name](value, field);
            if (customErrors) {
                errors.push(...(Array.isArray(customErrors) ? customErrors : [customErrors]));
            }
        }
        
        this.updateFieldFeedback(field, errors);
        return errors.length === 0;
    }
    
    getFieldRules(field) {
        return {
            required: field.hasAttribute('required'),
            minLength: field.getAttribute('minlength') ? parseInt(field.getAttribute('minlength')) : null,
            maxLength: field.getAttribute('maxlength') ? parseInt(field.getAttribute('maxlength')) : null,
            min: field.getAttribute('min') ? parseInt(field.getAttribute('min')) : null,
            max: field.getAttribute('max') ? parseInt(field.getAttribute('max')) : null
        };
    }
    
    getFieldLabel(field) {
        const label = this.form.querySelector(`label[for="${field.id}"]`);
        return label ? label.textContent.replace('*', '').trim() : field.name;
    }
    
    updateFieldFeedback(field, errors) {
        const invalidFeedback = field.parentElement.querySelector('.invalid-feedback');
        const validFeedback = field.parentElement.querySelector('.valid-feedback');
        
        // Always clear previous states
        field.classList.remove('is-invalid', 'is-valid');
        
        // Hide all feedback first
        if (invalidFeedback) {
            invalidFeedback.style.display = 'none';
            invalidFeedback.textContent = '';
        }
        if (validFeedback) {
            validFeedback.style.display = 'none';
        }
        
        if (errors.length > 0) {
            // Show error state
            field.classList.add('is-invalid');
            if (invalidFeedback) {
                invalidFeedback.textContent = errors[0];
                invalidFeedback.style.display = 'block';
            }
        } else if (field.value.trim() || field.name === 'password') {
            // Show valid state only if field has value OR it's a password field (optional)
            if (field.value.trim() || (field.name === 'password' && !field.hasAttribute('required'))) {
                field.classList.add('is-valid');
                if (validFeedback && this.options.showSuccessMessages && field.value.trim()) {
                    validFeedback.style.display = 'block';
                }
            }
        }
    }
    
    validateForm() {
        const inputs = this.form.querySelectorAll('input, select, textarea');
        let isValid = true;
        
        inputs.forEach(input => {
            if (!this.validateField(input)) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    handleSubmit(e) {
        e.preventDefault();
        
        if (!this.validateForm()) {
            showToast('danger', 'Mohon perbaiki error pada form sebelum submit');
            // Focus on first invalid field
            const firstInvalid = this.form.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.focus();
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return false;
        }
        
        if (this.options.submitCallback) {
            this.options.submitCallback(e);
        } else {
            this.form.submit();
        }
    }
    
    showLoading(show = true) {
        const container = this.form.closest('.form-container') || this.form.parentElement;
        let overlay = container.querySelector('.loading-overlay');
        
        if (show) {
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'loading-overlay';
                overlay.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
                container.style.position = 'relative';
                container.appendChild(overlay);
            } else {
                overlay.classList.remove('d-none');
            }
            
            // Disable submit button
            const submitBtn = this.form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                const text = submitBtn.querySelector('.submit-text') || submitBtn;
                const spinner = submitBtn.querySelector('.spinner-border');
                
                if (spinner) spinner.classList.remove('d-none');
                if (text.tagName === 'SPAN') {
                    text.textContent = 'Memproses...';
                } else {
                    text.innerHTML = 'Memproses... <span class="spinner-border spinner-border-sm"></span>';
                }
            }
        } else {
            if (overlay) {
                overlay.classList.add('d-none');
            }
            
            // Enable submit button
            const submitBtn = this.form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = false;
                const text = submitBtn.querySelector('.submit-text') || submitBtn;
                const spinner = submitBtn.querySelector('.spinner-border');
                
                if (spinner) spinner.classList.add('d-none');
                if (text.tagName === 'SPAN') {
                    text.textContent = text.getAttribute('data-original') || 'Simpan';
                } else {
                    text.innerHTML = text.getAttribute('data-original') || 'Simpan';
                }
            }
        }
    }
    
    reset() {
        this.form.reset();
        const inputs = this.form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
            const invalidFeedback = input.parentElement.querySelector('.invalid-feedback');
            const validFeedback = input.parentElement.querySelector('.valid-feedback');
            
            if (invalidFeedback) {
                invalidFeedback.style.display = 'none';
                invalidFeedback.textContent = '';
            }
            if (validFeedback) {
                validFeedback.style.display = 'none';
            }
        });
    }
}
    </script>
    
    <?= $this->renderSection('pageScripts') ?> 
</body>
</html>