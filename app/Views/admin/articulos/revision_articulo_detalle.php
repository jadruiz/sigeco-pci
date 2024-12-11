<?= $this->extend('admin/layouts/main') ?>
<?= $this->section('global-search') ?><?= $this->include('admin/partials/searchbar') ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<?= $this->include('admin/partials/breadcrumbs') ?>
<?= $this->include('admin/partials/alertas') ?>
<div class="container mt-4">
    <h2><?= esc($titulo_pagina) ?></h2>
    <hr>
    <!-- Información del artículo -->
    <div class="mb-4">
        <h4>Título: <?= esc($articulo['titulo']) ?></h4>
        <p><strong>Resumen:</strong> <?= esc($articulo['resumen']) ?></p>
        <p><strong>Estado Actual:</strong> <?= esc($articulo['estado']) ?></p>
        <p><strong>Fecha de Envío:</strong> <?= esc($articulo['fecha_envio']) ?></p>
    </div>
    <!-- Formulario de Revisión -->
    <form method="POST" action="<?= base_url('admin/articulos/revision/guardar') ?>">
        <input type="hidden" name="articulo_id" value="<?= $articulo['id'] ?>">
        <!-- Comentarios -->
        <div class="mb-3">
            <label for="comentarios" class="form-label">Comentarios</label>
            <textarea name="comentarios" class="form-control" rows="5" required></textarea>
        </div>
        <!-- Calificación -->
        <div class="mb-3">
            <label for="calificacion" class="form-label">Calificación</label>
            <input type="number" name="calificacion" class="form-control" min="0" max="10" required>
        </div>
        <!-- Estado de Revisión -->
        <div class="mb-3">
            <label for="estado_revision" class="form-label">Estado de Revisión</label>
            <select name="estado_revision" class="form-select">
                <option value="pendiente">Pendiente</option>
                <option value="en_proceso">En Proceso</option>
                <option value="recomendado">Recomendado</option>
                <option value="no_recomendado">No Recomendado</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar Revisión</button>
        <a href="<?= base_url('admin/articulos') ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
<?= $this->endSection() ?>
<?= $this->section('extra-js') ?>
<script>
    $(document).ready(function() {
       
    });
</script>
<?= $this->endSection() ?>