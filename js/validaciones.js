// ===== VALIDACIÓN DE FORMULARIOS EN TIEMPO REAL =====
document.addEventListener('DOMContentLoaded', function() {
    // Validación para formulario de registro
    const registerForm = document.querySelector('form[action=""]'); // Formulario de register.php
    
    if (registerForm && registerForm.querySelector('#password')) {
        const passwordInput = registerForm.querySelector('#password');
        const usernameInput = registerForm.querySelector('#username');
        const emailInput = registerForm.querySelector('#email');
        const telefonoInput = registerForm.querySelector('#telefono');
        const codigoPostalInput = registerForm.querySelector('#codigo_postal');
        const fechaNacimientoInput = registerForm.querySelector('#fecha_nacimiento');
        
        // Validación de contraseña en tiempo real
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
                
                if (password && !regex.test(password)) {
                    this.setCustomValidity('Contraseña debe tener: minúscula, mayúscula, número, carácter especial (@$!%*?&) y 8+ caracteres');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (password) {
                    this.setCustomValidity('');
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-valid', 'is-invalid');
                }
            });
        }
        
        // Validación de username
        if (usernameInput) {
            usernameInput.addEventListener('input', function() {
                const username = this.value;
                const regex = /^[a-zA-Z0-9_]{3,50}$/;
                
                if (username && !regex.test(username)) {
                    this.setCustomValidity('Username: alfanumérico/guion bajo, 3-50 caracteres');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (username) {
                    this.setCustomValidity('');
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-valid', 'is-invalid');
                }
            });
        }
        
        // Validación de email
        if (emailInput) {
            emailInput.addEventListener('input', function() {
                const email = this.value;
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (email && !regex.test(email)) {
                    this.setCustomValidity('Ingresa un email válido');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (email) {
                    this.setCustomValidity('');
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-valid', 'is-invalid');
                }
            });
        }
        
        // Validación de teléfono
        if (telefonoInput) {
            telefonoInput.addEventListener('input', function() {
                const telefono = this.value;
                const regex = /^\d{9}$/;
                
                if (telefono && !regex.test(telefono)) {
                    this.setCustomValidity('El teléfono debe tener exactamente 9 dígitos');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (telefono) {
                    this.setCustomValidity('');
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-valid', 'is-invalid');
                }
            });
        }
        
        // Validación de código postal
        if (codigoPostalInput) {
            codigoPostalInput.addEventListener('input', function() {
                const cp = this.value;
                const regex = /^\d{5}$/;
                
                if (cp && !regex.test(cp)) {
                    this.setCustomValidity('El código postal debe tener exactamente 5 dígitos');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (cp) {
                    this.setCustomValidity('');
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-valid', 'is-invalid');
                }
            });
        }
        
        // Validación de fecha de nacimiento (mayor de 18 años)
        if (fechaNacimientoInput) {
            fechaNacimientoInput.addEventListener('change', function() {
                const fechaNac = new Date(this.value);
                const hoy = new Date();
                let edad = hoy.getFullYear() - fechaNac.getFullYear();
                const mes = hoy.getMonth() - fechaNac.getMonth();
                
                if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNac.getDate())) {
                    edad--;
                }
                
                if (this.value && edad < 18) {
                    this.setCustomValidity('Debes ser mayor de 18 años');
                    this.classList.add('is-invalid');
                    this.classList.remove('is-valid');
                } else if (this.value) {
                    this.setCustomValidity('');
                    this.classList.add('is-valid');
                    this.classList.remove('is-invalid');
                } else {
                    this.setCustomValidity('');
                    this.classList.remove('is-valid', 'is-invalid');
                }
            });
        }
    }
});
