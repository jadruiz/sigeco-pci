<?= $this->extend('layouts/template_hero') ?>
<?= $this->section('header') ?>
<?= $this->endSection() ?>
<?= $this->section('content') ?>

<style>
    .login-wrapper .btn {
        width: 100%;
    }

    input::placeholder {
        color: #dee2e6 !important;
    }

    .password-toggle {
        cursor: pointer;
    }

    .is-invalid {
        border-color: #dc3545 !important;
    }
</style>

<div class="container login-wrapper mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-primary text-center mb-4">¡Bienvenido de nuevo!</h1>
            <p class="text-center pb-4">Inicia sesión para acceder a tu cuenta y disfrutar de todas las funcionalidades.</p>
            <!-- Mensajes de éxito y error -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= esc(session()->getFlashdata('success')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('alert')): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?= esc(session()->getFlashdata('alert')) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                </div>
            <?php endif; ?>
            <!-- Formulario de Login -->
            <form id="loginForm" action="<?= base_url('iniciar-sesion/procesar'); ?>" method="post" novalidate>
                <!-- Usuario/Correo -->
                <div class="mb-4">
                    <label for="username" class="form-label">Usuario/Correo</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Ej. micuenta o micorreo@ejemplo.com" required>
                    <div class="invalid-feedback">Por favor ingresa tu usuario o correo.</div>
                </div>

                <!-- Contraseña -->
                <div class="mb-4">
                    <label for="password" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                        <span class="input-group-text password-toggle" aria-label="Mostrar u ocultar contraseña">
                            <i class="fa-solid fa-eye-slash" id="togglePasswordIcon"></i>
                        </span>
                        <div class="invalid-feedback">Por favor ingresa tu contraseña.</div>
                    </div>
                </div>

                <!-- Recordarme y Enlace al Registro -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                        <label class="form-check-label" for="rememberMe">
                            Recuérdame
                        </label>
                    </div>
                    <a href="<?= base_url('registro') ?>" class="text-decoration-none">¿No tienes cuenta? Regístrate</a>
                </div>

                <!-- Botón de Inicio -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-lg btn-primary">Iniciar sesión</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('bottom_body') ?>
<script>
    $(document).ready(function() {
        // Mostrar/Ocultar Contraseña
        const togglePasswordIcon = $('#togglePasswordIcon');
        const passwordField = $('#password');

        $('.password-toggle').on('click', function() {
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);

            // Cambiar el ícono
            if (type === 'text') {
                togglePasswordIcon.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                togglePasswordIcon.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        });

        // Validación en el lado del cliente
        $('#loginForm').on('submit', function(e) {
            let isValid = true;

            // Validar Usuario/Correo
            const username = $('#username');
            if (username.val().trim() === '') {
                username.addClass('is-invalid');
                isValid = false;
            } else {
                username.removeClass('is-invalid');
            }

            // Validar Contraseña
            const password = $('#password');
            if (password.val().trim() === '') {
                password.addClass('is-invalid');
                isValid = false;
            } else {
                password.removeClass('is-invalid');
            }

            // Prevenir envío si no es válido
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
</script>
<?= $this->endSection() ?>