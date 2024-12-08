<?= $this->extend('website/layouts/main'); ?>
<?= $this->section('content'); ?>

<section class="congresos-lista">
    <h1>Lista de Congresos</h1>

    <?php if (!empty($congresos)) : ?>
        <ul>
            <?php foreach ($congresos as $congreso) : ?>
                <li>
                    <h3><?= esc($congreso['nombre']); ?></h3>
                    <p><?= esc(substr($congreso['descripcion'], 0, 100)); ?>...</p>
                    <a href="<?= base_url('congreso/' . esc($congreso['slug'])); ?>" class="btn btn-primary">
                        Ver Detalle
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else : ?>
        <p>No hay congresos disponibles en este momento.</p>
    <?php endif; ?>
</section>

<?= $this->endSection(); ?>
