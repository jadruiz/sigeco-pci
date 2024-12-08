<?= $this->extend('layouts/template_hero') ?>
<?= $this->section('content'); ?>

<div class="container py-5">
    <h1 class="text-primary mb-4 text-center">Dashboard - Convocatorias</h1>

    <!-- Filtro de convocatorias -->
    <form method="get" action="<?= base_url('dashboard'); ?>" class="mb-4">
        <div class="row">
            <div class="col-md-6">
                <label for="estado" class="form-label">Filtrar por Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="">Todas</option>
                    <option value="convocatoria" <?= ($filter == 'convocatoria') ? 'selected' : '' ?>>Convocatoria</option>
                    <option value="registro" <?= ($filter == 'registro') ? 'selected' : '' ?>>Registro</option>
                    <option value="activo" <?= ($filter == 'activo') ? 'selected' : '' ?>>Activo</option>
                    <option value="finalizado" <?= ($filter == 'finalizado') ? 'selected' : '' ?>>Finalizado</option>
                </select>
            </div>
            <div class="col-md-6 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Aplicar Filtro</button>
            </div>
        </div>
    </form>

    <!-- Tabla de convocatorias -->
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Congreso</th>
                <th>Descripción</th>
                <th>Fecha Inicio</th>
                <th>Fecha Fin</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($convocatorias)): ?>
                <?php foreach ($convocatorias as $index => $convocatoria): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($convocatoria['nombre_congreso']) ?></td>
                        <td><?= esc($convocatoria['descripcion']) ?></td>
                        <td><?= esc($convocatoria['fecha_inicio']) ?></td>
                        <td><?= esc($convocatoria['fecha_fin']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No hay convocatorias disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?= $this->endSection(); ?>
