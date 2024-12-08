<?= $this->extend('layouts/template_hero') ?>
<?= $this->section('content'); ?>

<style>
    .form-control::placeholder {
        color: #aaa;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .input-group-text {
        cursor: pointer;
    }

    .was-validated .form-control:valid {
        border-color: #198754;
    }

    .was-validated .form-control:invalid {
        border-color: #dc3545;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Notificaciones -->
            <?php if (session()->has('errors')): ?>
                <div class="alert alert-danger" role="alert">
                    <?php foreach (session('errors') as $error): ?>
                        <p><?= esc($error); ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if (session()->has('alert')): ?>
                <div class="alert alert-warning"><?= esc(session('alert')); ?></div>
            <?php endif; ?>
            <?php if (session()->has('success')): ?>
                <div class="alert alert-success"><?= esc(session('success')); ?></div>
            <?php endif; ?>

            <h1 class="text-primary text-center mb-4">¡Crea tu cuenta ahora!</h1>
            <p class="text-center pb-4">Regístrate para acceder a todas las funcionalidades de la plataforma.</p>

            <!-- Formulario de Registro -->
            <form action="<?= base_url('registro/procesar'); ?>" method="post" id="registerForm" novalidate>
                <div class="row g-3">
                    <!-- Nombre de Usuario -->
                    <div class="col-md-6">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Ej. juanperez" required>
                        <div class="invalid-feedback">Por favor, ingresa un nombre de usuario válido.</div>
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="col-md-6">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="ejemplo@correo.com" required>
                        <div class="invalid-feedback">Por favor, ingresa un correo electrónico válido.</div>
                    </div>

                    <!-- Contraseña -->
                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                            <span class="input-group-text">
                                <i class="fa-solid fa-eye-slash togglePassword"></i>
                            </span>
                            <div class="invalid-feedback">La contraseña es obligatoria.</div>
                        </div>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="col-md-6">
                        <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="********" required>
                            <span class="input-group-text">
                                <i class="fa-solid fa-eye-slash togglePassword"></i>
                            </span>
                            <div class="invalid-feedback">Las contraseñas no coinciden.</div>
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                        <div class="invalid-feedback">Por favor, ingresa tu nombre.</div>
                    </div>

                    <!-- Apellido Paterno -->
                    <div class="col-md-6">
                        <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                        <div class="invalid-feedback">Por favor, ingresa tu apellido paterno.</div>
                    </div>

                    <!-- Apellido Materno -->
                    <div class="col-md-6">
                        <label for="apellido_materno" class="form-label">Apellido Materno</label>
                        <input type="text" class="form-control" id="apellido_materno" name="apellido_materno">
                    </div>

                    <!-- Teléfono -->
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Ej. 5512345678" pattern="[0-9]{10}" required>
                        <div class="invalid-feedback">El teléfono debe tener 10 dígitos.</div>
                    </div>
                </div>

                <!-- Botón de Registro -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Registrarse</button>
                </div>
            </form>
            <div class="text-center mt-3">
                ¿Ya tienes cuenta? <a href="<?= base_url('iniciar-sesion'); ?>">Inicia sesión aquí</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Mostrar/Ocultar Contraseña
    document.querySelectorAll('.togglePassword').forEach(icon => {
        icon.addEventListener('click', function() {
            const input = this.parentElement.previousElementSibling;
            const type = input.type === 'password' ? 'text' : 'password';
            input.type = type;
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });

    // Validación de contraseñas
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    confirmPassword.addEventListener('input', function() {
        confirmPassword.classList.toggle('is-invalid', password.value !== confirmPassword.value);
    });

    // Validación Bootstrap
    (function() {
        'use strict';
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            });
        });
    })();
</script>

<?= $this->endSection(); ?>
