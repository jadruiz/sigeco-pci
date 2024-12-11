<?= $this->extend('website/layouts/panel_participants') ?>
<?= $this->section('content'); ?>

<div class="container py-5">
    <h1 class="text-center text-primary mb-4">Mis Congresos</h1>

    <?php if (!empty($inscripciones)) : ?>
        <div class="row g-4">
            <?php foreach ($inscripciones as $inscripcion) : ?>
                <div class="col-md-6 col-lg-6">
                    <div class="card shadow-sm border-0">
                        <!-- Imagen del Congreso -->
                        <img src="<?= base_url((!empty($inscripcion['cover_image']) ? esc($inscripcion['cover_image']) : 'default.jpg')) ?>" 
                             class="card-img-top img-fluid rounded-top" alt="Congreso">

                        <!-- Contenido -->
                        <div class="card-body">
                            <h5 class="card-title text-center"><?= esc($inscripcion['nombre_congreso']) ?></h5>
                            <p class="text-muted text-center">
                                <ion-icon name="calendar-outline"></ion-icon>
                                <small><?= esc($inscripcion['fecha_inicio']) ?> - <?= esc($inscripcion['fecha_fin']) ?></small>
                            </p>
                            <p class="text-center">
                                <span class="badge <?= $inscripcion['estado'] === 'activo' ? 'bg-success' : 'bg-warning' ?>">
                                    <?= ucfirst($inscripcion['estado']) ?>
                                </span>
                            </p>

                            <!-- Tabs -->
                            <ul class="nav nav-tabs" id="tab-<?= $inscripcion['congreso_id'] ?>" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#general-<?= $inscripcion['congreso_id'] ?>" role="tab">
                                        <ion-icon name="information-circle-outline"></ion-icon> General
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#fechas-<?= $inscripcion['congreso_id'] ?>" role="tab">
                                        <ion-icon name="time-outline"></ion-icon> Fechas Importantes
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#articulos-<?= $inscripcion['congreso_id'] ?>" role="tab">
                                        <ion-icon name="document-outline"></ion-icon> Mis Artículos
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content mt-3">
                                <!-- General -->
                                <div class="tab-pane fade show active" id="general-<?= $inscripcion['congreso_id'] ?>">
                                    <p><strong>Fecha Inscripción:</strong> <?= esc($inscripcion['fecha_inscripcion']) ?></p>
                                    <p><strong>Estado del Congreso:</strong> <?= ucfirst($inscripcion['estado']) ?></p>
                                </div>

                                <!-- Fechas Importantes -->
                                <div class="tab-pane fade" id="fechas-<?= $inscripcion['congreso_id'] ?>">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <ion-icon name="calendar-clear-outline"></ion-icon> Inicio: <?= esc($inscripcion['fecha_inicio']) ?>
                                        </li>
                                        <li class="list-group-item">
                                            <ion-icon name="calendar-clear-outline"></ion-icon> Fin: <?= esc($inscripcion['fecha_fin']) ?>
                                        </li>
                                    </ul>
                                    <!-- Botón Agregar a Calendario -->
                                    <div class="text-center mt-3">
                                        <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=<?= urlencode($inscripcion['nombre_congreso']) ?>&dates=<?= date('Ymd', strtotime($inscripcion['fecha_inicio'])) ?>/<?= date('Ymd', strtotime($inscripcion['fecha_fin'])) ?>" 
                                           target="_blank" class="btn btn-outline-info btn-sm">
                                           <ion-icon name="calendar"></ion-icon> Agregar a Google Calendar
                                        </a>
                                    </div>
                                </div>

                                <!-- Mis Artículos -->
                                <div class="tab-pane fade" id="articulos-<?= $inscripcion['congreso_id'] ?>">
                                    <?php 
                                    $misArticulos = array_filter($articulos, fn($a) => $a['congreso_id'] == $inscripcion['congreso_id']); 
                                    $cuantosArticulos=count($misArticulos);
                                    ?>
                                    <?php if (!empty($misArticulos)) : ?>
                                        <ul class="list-group">
                                            <?php foreach ($misArticulos as $articulo) : ?>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <?= esc($articulo['titulo']) ?>
                                                    <span class="badge bg-info"><?= ucfirst($articulo['estado']) ?></span>
                                                    <a href="<?= base_url("articulos/editar/{$articulo['id']}") ?>" class="btn btn-sm btn-warning disabled">
                                                        <ion-icon name="create-outline"></ion-icon> Editar
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <p class="text-muted text-center">No has subido artículos.</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Botones -->
                            <div class="mt-3 text-center">
                                <?php 
                                if ($inscripcion['estado'] === 'activo' && $cuantosArticulos < 1) : ?>
                                    <a href="<?= base_url("articulos/subir/{$inscripcion['congreso_id']}") ?>" class="btn btn-primary btn-sm">
                                        <ion-icon name="cloud-upload-outline"></ion-icon> Subir Artículo
                                    </a>
                                <?php endif; ?>
                                <a href="<?= base_url("congreso/{$inscripcion['slug']}") ?>" target="_blank" class="btn btn-outline-secondary btn-sm">
                                    <ion-icon name="eye-outline"></ion-icon> Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else : ?>
        <div class="alert alert-info text-center">
            <ion-icon name="information-circle-outline" size="large"></ion-icon>
            <p>No tienes inscripciones a congresos actualmente.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection(); ?>
