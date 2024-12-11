<div class="text-center my-5">
    <h3 class="text-primary">¡Registro Exitoso!</h3>
    <p class="fs-5">
        Te has inscrito correctamente al congreso 
        <strong><?= esc($congreso['nombre']); ?></strong>.
    </p>
    <p class="fs-6 text-secondary">
        Mantente pendiente de tu <strong>correo electrónico</strong> y <strong>teléfono celular</strong> 
        para recibir notificaciones importantes relacionadas con el evento.
    </p>
    <div class="mt-4">
        <a href="<?= base_url('/mis-congresos'); ?>" class="btn btn-primary btn-lg">
            Continuar
        </a>
    </div>
</div>
