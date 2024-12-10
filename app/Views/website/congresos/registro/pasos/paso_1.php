<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <?php if (session()->has('wlp_id')): ?>
                <!-- Usuario autenticado: Mostrar resumen de inscripción -->
                <h3 class="text-center text-primary mb-4">¡Ya estás autenticado!</h3>
                <p class="text-center">Resumen de tu inscripción al congreso:</p>
                <ul class="list-group mb-4">
                    <li class="list-group-item">
                        <strong>Nombre:</strong> <?= esc(session('wlp_name')) ?>
                    </li>
                    <li class="list-group-item">
                        <strong>Congreso seleccionado:</strong> <?= esc($slug) ?>
                    </li>
                </ul>
                <div class="text-center">
                    <a href="<?= base_url("congreso/$slug/registro/paso/2") ?>" class="btn btn-primary btn-lg">
                        Continuar con el registro
                    </a>
                </div>

            <?php else: ?>
                <!-- Usuario no autenticado: Mostrar opciones de login y registro -->
                <h3 class="text-center text-primary mb-4">¡No tienes una cuenta!</h3>
                <p class="text-center">Para continuar con el registro, por favor inicia sesión o crea una cuenta nueva.</p>
                <div class="d-flex justify-content-center gap-4 mb-4">
                    <!-- Botón de inicio de sesión -->
                    <a href="<?= base_url('registro/set_congreso/' . $congreso['slug']) ?>/1" class="btn btn-primary btn-lg">
                        Iniciar Sesión
                    </a>
                    <!-- Botón de crear cuenta -->
                    <a href="<?= base_url('registro/set_congreso/' . $congreso['slug']) ?>/2" class="btn btn-primary btn-lg ml-4">
                        Crear Cuenta
                    </a>
                </div>

                <!-- Sección de ayuda -->
                <div class="text-center mt-4">
                    <p class="text-muted">
                        ¿Necesitas ayuda con el registro? Contáctanos en
                        <a href="mailto:soporte@congreso.com" class="text-decoration-underline">soporte@congreso.com</a>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<style>
     .actions-wrapper{ display: none;}
</style>