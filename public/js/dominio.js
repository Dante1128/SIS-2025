// Gestión de interacciones para Dominio y Subdominio

document.addEventListener('DOMContentLoaded', function() {
    // Auto-ocultar mensajes de éxito después de 5 segundos
    const successMessages = document.querySelectorAll('.alert-success');
    successMessages.forEach(message => {
        setTimeout(() => {
            message.style.transition = 'opacity 0.3s ease';
            message.style.opacity = '0';
            setTimeout(() => {
                message.remove();
            }, 300);
        }, 5000);
    });

    // Confirmación mejorada para toggle de estado
    const toggleForms = document.querySelectorAll('form[action*="toggle"]');
    toggleForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const isActive = form.querySelector('input[type="hidden"][name*="estado"]')?.value === '1';
            const action = isActive ? 'desactivar' : 'activar';
            const itemType = form.action.includes('dominio') ? 'dominio' : 'subdominio';
            
            if (confirm(`¿Estás seguro de que deseas ${action} este ${itemType}?`)) {
                form.submit();
            }
        });
    });

    // Mejorar la experiencia de los formularios
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn && !form.action.includes('toggle')) {
            form.addEventListener('submit', function() {
                submitBtn.disabled = true;
                const originalText = submitBtn.textContent;
                submitBtn.textContent = submitBtn.textContent.includes('Registrar') ? 'Registrando...' : 
                                       submitBtn.textContent.includes('Guardar') ? 'Guardando...' : 
                                       submitBtn.textContent.includes('Actualizar') ? 'Actualizando...' : 
                                       'Procesando...';
                
                // Re-habilitar después de 10 segundos por si hay un error
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }, 10000);
            });
        }
    });

    // Validación de formularios en tiempo real
    const inputs = document.querySelectorAll('.form-input, .form-textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '' && this.hasAttribute('required')) {
                this.style.borderColor = 'var(--danger-color)';
            } else {
                this.style.borderColor = '';
            }
        });

        input.addEventListener('input', function() {
            if (this.style.borderColor === 'rgb(239, 68, 68)') {
                this.style.borderColor = '';
            }
        });
    });

    // Animación suave al hacer scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);

    // Observar elementos para animación
    document.querySelectorAll('.card, .dominio-item').forEach(el => {
        observer.observe(el);
    });

    // Efecto de hover mejorado en tarjetas
    const dominioItems = document.querySelectorAll('.dominio-item');
    dominioItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Confirmación para acciones de edición/eliminación
    const editButtons = document.querySelectorAll('a[href*="edit"], button[type="submit"][formaction*="update"]');
    editButtons.forEach(btn => {
        if (btn.tagName === 'FORM') {
            btn.addEventListener('submit', function(e) {
                if (!confirm('¿Estás seguro de que deseas guardar los cambios?')) {
                    e.preventDefault();
                }
            });
        }
    });
});

