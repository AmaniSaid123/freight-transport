document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('profileForm');
    if (!form) return;

    const fields = form.querySelectorAll(`
    input[required], 
    textarea[required], 
    select[required],
    input[data-validation-rules],
    textarea[data-validation-rules],
    select[data-validation-rules]
`);

    // Real-time validation
    fields.forEach(field => {
        field.addEventListener('blur', function () {
            validateField(this);
        });

        field.addEventListener('input', function () {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });

    // Form submission validation
    form.addEventListener('submit', function (e) {
        let isValid = true;
        let firstInvalidField = null;

        fields.forEach(field => {
            if (!validateField(field)) {
                isValid = false;
                if (!firstInvalidField) {
                    firstInvalidField = field;
                }
            }
        });

        if (!isValid && firstInvalidField) {
            e.preventDefault();
            firstInvalidField.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
            firstInvalidField.focus();
        }
    });

    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.getAttribute('name');
        const validationRules = field.getAttribute('data-validation-rules');
        let isValid = true;
        let errorMessage = '';

        // Check if field is required
        if (field.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = field.getAttribute('data-required-message') || 'Ce champ est obligatoire';
        }

        // Process custom validation rules if provided
        if (isValid && validationRules) {
            const rules = JSON.parse(validationRules);

            for (const rule in rules) {
                const ruleValue = rules[rule];

                switch (rule) {
                    case 'minLength':
                        if (value.length < ruleValue) {
                            isValid = false;
                            errorMessage = field.getAttribute('data-minlength-message') ||
                                `Doit contenir au moins ${ruleValue} caractères`;
                        }
                        break;

                    case 'maxLength':
                        if (value.length > ruleValue) {
                            isValid = false;
                            errorMessage = field.getAttribute('data-maxlength-message') ||
                                `Doit contenir au maximum ${ruleValue} caractères`;
                        }
                        break;
                }

                if (!isValid) break;
            }
        }

        // Update UI
        updateFieldUI(field, isValid, errorMessage);

        return isValid;
    }

    function updateFieldUI(field, isValid, errorMessage) {
        if (!isValid) {
            field.classList.add('is-invalid');
            field.classList.remove('is-valid');

            // Show error message
            let errorDiv = field.parentNode.querySelector('.invalid-feedback');
            if (!errorDiv) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback d-block';
                field.parentNode.appendChild(errorDiv);
            }
            errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${errorMessage}`;

            // Hide help text
            const helpText = field.parentNode.querySelector('.form-text');
            if (helpText) {
                helpText.style.display = 'none';
            }
        } else {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');

            // Remove error message
            const errorDiv = field.parentNode.querySelector('.invalid-feedback');
            if (errorDiv) {
                errorDiv.remove();
            }

            // Show help text
            const helpText = field.parentNode.querySelector('.form-text');
            if (helpText) {
                helpText.style.display = 'block';
            }
        }
    }
});